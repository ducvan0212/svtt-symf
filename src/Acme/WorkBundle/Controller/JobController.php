<?php

namespace Acme\WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Acme\WorkBundle\Entity\Job;

class JobController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        $user = $this->getUser();
        $jobs = $user->getJobs();
        return array('name' => $name, 'jobs' => $jobs);
    }

    public function createAction(Request $request)
    {
      if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
        throw new AccessDeniedException();
      }

      $job = new Job();

      $form = $this->createFormBuilder($job)
        ->add('title', 'text')
        ->add('contact', 'textarea')
        ->add('requiredApplication', 'textarea')
        ->add('languages', 'entity', array(
	  		'class' => 'AcmeWorkBundle:Language',
	  		'property' => 'name',
	  		'expanded' => true,
	  		'multiple' => true))
        ->add('categories', 'entity', array(
        'class' => 'AcmeWorkBundle:Category',
        'property' => 'name',
        'expanded' => true,
        'multiple' => true))
        ->add('salary', 'entity', array(
        'class' => 'AcmeWorkBundle:Salary',
        'property' => 'level',
        'expanded' => true,
        'multiple' => false))
	  	  ->getForm();

      if ($request->isMethod('POST')) {
        $form->bind($request);
        
        if ($form->isValid()) {
          $user = $this->getUser();
          // var_dump($user->getUsername());die();
          $job->setUser($user);

          $em = $this->getDoctrine()->getManager();
          $em->persist($job);
          $em->flush();
          return new Response('okok'); 
        } else {
          return $this->render('AcmeWorkBundle:Job:new.html.twig', array(
            'form' => $form->createView(),
            ));
        }
      } else {
        return $this->render('AcmeWorkBundle:Job:new.html.twig', array(
            'form' => $form->createView(),
            ));
      }
    }
}
