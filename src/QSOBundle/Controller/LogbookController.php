<?php

namespace QSOBundle\Controller;

use Doctrine\ORM\Persisters\Entity\JoinedSubclassPersister;
use QSOBundle\Entity\Callsign;
use QSOBundle\Entity\Logbook;
use QSOBundle\Form\LogbookType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class LogbookController extends Controller
{
    /**
     * Allows us to edit the log entry
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $entry = $this->getDoctrine()
            ->getManager()
            ->getRepository('QSOBundle:Logbook')->findOneBy(array(
                'id' => $id,
                'user' => $this->getUser()
            ));

        if (empty($entry))
        {
            return $this->redirectToRoute('qso_dashboard');
        }

        $form = $this->createForm(LogbookType::class, $entry);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $arrayData = $request->request->get($form->getName());

            // Create the callsign if the autocomplete could not find it
            if (!empty($arrayData['callsignAutocomplete']))
            {
                $callsign = $em->getRepository('QSOBundle:Callsign')->findOneBy(array(
                    'callsign' => $arrayData['callsignAutocomplete']
                ));

                if (empty($callsign))
                {
                    $callsign = new Callsign();
                    $callsign->setCallsign($arrayData['callsignAutocomplete']);
                    $callsign->setIsActive(true);

                    $em->persist($callsign);
                    $em->flush();
                }
            }

            /** @var Logbook $data */
            $data = $form->getData();
            $data->setCallsign($callsign);

            // Assign the user
            $data->setUser($this->getUser());

            $em->persist($data);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Entry succesfully edited!');

            return $this->redirectToRoute('qso_logbook_edit', array(
                'id' => $data->getId()
            ));
        }

        return $this->render('QSOBundle:logbook:form.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Show the add logbook page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(LogbookType::class, new Logbook());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $arrayData = $request->request->get($form->getName());

            // Create the callsign if the autocomplete could not find it
            if (!empty($arrayData['callsignAutocomplete']))
            {
                $callsign = $em->getRepository('QSOBundle:Callsign')->findOneBy(array(
                    'callsign' => $arrayData['callsignAutocomplete']
                ));

                if (empty($callsign))
                {
                    $callsign = new Callsign();
                    $callsign->setCallsign($arrayData['callsignAutocomplete']);
                    $callsign->setIsActive(true);

                    $em->persist($callsign);
                    $em->flush();
                }
            }

            /** @var Logbook $data */
            $data = $form->getData();
            $data->setCallsign($callsign);

            // Assign the user
            $data->setUser($this->getUser());

            $em->persist($data);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Entry succesfully added, you can immediately add another one below.');

            return $this->redirectToRoute('qso_logbook_add');
        }

        return $this->render('QSOBundle:logbook:form.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Show a overview of all logbooks
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function overviewAction(Request $request)
    {
        return $this->render('QSOBundle:logbook:overview.html.twig');
    }

    /**
     * Handle the datatable
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function datatableAction(Request $request)
    {
        $response = new JsonResponse(array());

        $length = $request->query->get('length');
        if (empty($length) || $length > 50)
        {
            $length = 10;
        }
        $em = $this->getDoctrine()->getManager();

        $totalResult = $em->createQuery('SELECT COUNT(l) AS total FROM QSOBundle:Logbook l WHERE l.user = :user')
            ->setParameter(':user', $this->getUser())
            ->getSingleResult();


        /** @var \Doctrine\ORM\Query $query */
        $query = $em->createQuery('SELECT l.id, c.callsign, l.frequency, fu.unit, l.logStart, l.logEnd 
            FROM QSOBundle:Logbook l
            JOIN QSOBundle:FrequencyUnit fu WITH l.frequencyUnit = fu
            JOIN QSOBundle:Callsign c WITH l.callsign = c
            WHERE l.user = :user
            ORDER BY l.createdAt DESC');
        $query->setMaxResults($length);

        $query->setParameter('user', $this->getUser());
        $data = $query->getArrayResult();

        $tmp = array();
        foreach ($data as $row) {
            $diff = $row['logStart']->diff($row['logEnd']);

            $row['totalTime'] = $diff->format('%H:%I:%S');

            $row['actions'] = $this->render('QSOBundle:logbook/table:actions.html.twig', array(
                'id' => $row['id']
            ))->getContent();

            unset($row['id'], $row['frequency'], $row['unit'], $row['logEnd'], $row['logStart']);
            $tmp[] = array_values($row);
        }

        $response->setData(array(
            'draw' => $request->query->get('draw'),
            'recordsTotal' => $totalResult['total'],
            'recordsFiltered' => $totalResult['total'],
            'data' => $tmp
        ));

        return $response;
    }

    /**
     * Delete a logbook
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $logbook = null;

        try {
            $logbook = $this->getDoctrine()->getManager()->createQuery('SELECT l
                  FROM QSOBundle:Logbook l
                  WHERE l.user = :user
                  AND l.id = :id')
                ->setParameter('user', $this->getUser())
                ->setParameter('id', $id)
                ->getSingleResult();
        } catch (\Exception $exc) {}

        if (empty($logbook))
        {
            return $this->redirectToRoute('qso_dashboard');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($logbook);
        $em->flush();

        return $this->redirectToRoute('qso_logbook_overview');
    }

    /**
     * View a logbook
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Request $request, $id)
    {
        $logbook = $this->getDoctrine()->getManager()->createQuery('SELECT 
                        l.id, 
                        l.frequency, 
                        l.logStart, 
                        l.logEnd, 
                        l.rstSent, 
                        l.rstReceived,
                        l.power,
                        l.comment,
                        l.createdAt, 
                        c.callsign,
                        fu.unit, 
                        rm.mode, 
                        b.band
                  FROM QSOBundle:Logbook l
                   
                  JOIN QSOBundle:FrequencyUnit fu WITH l.frequencyUnit = fu
                  JOIN QSOBundle:RadioMode rm WITH l.radioMode = rm
                  JOIN QSOBundle:Callsign c WITH l.callsign = c
                  JOIN QSOBundle:Band b WITH l.band = b
                  WHERE l.user = :user
                  AND l.id = :id')
            ->setParameter('user', $this->getUser())
            ->setParameter('id', $id)
            ->getArrayResult();

        if (empty($logbook))
        {
            return $this->redirectToRoute('qso_dashboard');
        }

        return $this->render('QSOBundle:logbook:view.html.twig', array(
            'logbook' => $logbook[0]
        ));
    }
}