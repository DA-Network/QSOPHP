<?php

namespace QSOBundle\Controller;

use QSOBundle\Entity\Callsign;
use QSOBundle\Entity\Logbook;
use QSOBundle\Form\LogbookType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CallsignController extends Controller
{
    /**
     * Handles autocompletion calls for the callsign form field
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteAction(Request $request)
    {
        $response = new JsonResponse(array('data' => array()));

        $autocomplete = $request->request->get('autocomplete');

        if (empty($autocomplete))
        {
            return $response;
        }

        $autocomplete .= '%';

        $result = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT c.id, c.callsign AS text FROM QSOBundle:Callsign c WHERE c.callsign LIKE :autocomplete AND c.isActive = true')
            ->setParameter('autocomplete', $autocomplete)
            ->getArrayResult();

        $response->setData(array(
            'data' => $result
        ));

        return $response;
    }
}
