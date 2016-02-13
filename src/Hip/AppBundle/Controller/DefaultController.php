<?php

namespace Hip\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HipAppBundle:Default:index.html.twig');
    }
}
