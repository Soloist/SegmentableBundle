<?php

namespace Soloist\Bundle\SegmentableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{

    public function indexAction($name)
    {
        return $this->render('SoloistSegmentableBundle:Default:index.html.twig', array('name' => $name));
    }
}
