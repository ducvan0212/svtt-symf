<?php

namespace Acme\StaticPageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }

    public function homeAction() 
    {
      return $this->render('AcmeStaticPageBundle:Default:home.html.twig');
    }

    public function aboutAction() 
    {
      return $this->render('AcmeStaticPageBundle:Default:about.html.twig');
    }

    public function helpAction() 
    {
      return $this->render('AcmeStaticPageBundle:Default:help.html.twig');
    }
}
