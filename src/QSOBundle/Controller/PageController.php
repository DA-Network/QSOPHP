<?php

namespace QSOBundle\Controller;

use QSOBundle\Entity\Callsign;
use QSOBundle\Entity\Logbook;
use QSOBundle\Form\LogbookType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    /**
     * Show the user's personal dashboard
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction()
    {
        $result = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT COUNT(l.id) AS total FROM QSOBundle:Logbook l WHERE l.user = :user')
            ->setParameter('user', $this->getUser())
            ->getSingleResult();

        return $this->render('QSOBundle:page:dashboard.html.twig', array(
            'total_logbooks' => $result['total']
        ));
    }

    public function indexAction()
    {
        return $this->render('QSOBundle:page:index.html.twig');
    }
}
