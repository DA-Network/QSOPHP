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
    public function dashboardAction()
    {
        return $this->render('QSOBundle:page:dashboard.html.twig');
    }

    public function indexAction()
    {
        return $this->render('QSOBundle:page:index.html.twig');
    }
}
