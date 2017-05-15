<?php

namespace QSOBundle\Controller;

use QSOBundle\Entity\Callsign;
use QSOBundle\Entity\User;
use QSOBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class SecurityController
 *
 * Handle all security related tasks
 *
 * @package QSOBundle\Controller
 */
class SecurityController extends Controller
{

    /**
     * Login the user into the application
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('QSOBundle:security:login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error
        ));
    }

    /**
     * Allows the user to register for an account
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $form = $this->createForm(UserType::class, new User());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $data = $form->getData();

            // Create the callsign if the autocomplete could not find it
            $callsign = $em->getRepository('QSOBundle:Callsign')->findOneBy(array(
                'callsign' => $data->getCallsignName()
            ));

            if (empty($callsign))
            {
                $callsign = new Callsign();
                $callsign->setCallsign($data->getCallsignName());
                $callsign->setIsActive(true);

                $em->persist($callsign);
                $em->flush();
            }

            $data->setCallsign($callsign);
            $data->setUsername($data->getEmail());
            $data->setIsActive(true);
            $encoder = $this->container->get('security.password_encoder');
            $data->setPassword($encoder->encodePassword($data, $data->getPlainPassword()));

            $em->persist($data);
            $em->flush();

            $token = new UsernamePasswordToken($data, $data->getPassword(), 'main', $data->getRoles());
            $this->get('security.token_storage')->setToken($token);

            $event = new InteractiveLoginEvent($request, $token);
            $this->get('event_dispatcher')->dispatch('security.interactive_login', $event);

            return $this->redirectToRoute('qso_dashboard');
        }

        $errors = array();
        foreach ($form as $field)
        {
            $fieldErrors = $field->getErrors();
            if ($fieldErrors->count() > 0)
            {
                $errors[] = $fieldErrors;
            }
        }

        return $this->render('QSOBundle:security:register.html.twig', array(
            'form' => $form->createView(),
            'errors' => $errors
        ));
    }
}