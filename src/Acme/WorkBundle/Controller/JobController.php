<?php

namespace Acme\WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Acme\WorkBundle\Entity\Job;
use Acme\WorkBundle\Entity\Applicant;

class JobController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    // public function indexAction($name)
    // {
    //     $user = $this->getUser();
    //     $jobs = $user->getJobs();
    //     return array('name' => $name, 'jobs' => $jobs);
    // }

    public function createAction(Request $request)
    {
      if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
        throw new AccessDeniedException();
      }

      $user = $this->getUser();
      if ($user->getIsEmployer() === false) {
        throw new AccessDeniedException();
      }

      $job = new Job();

      $form = $this->createFormBuilder($job)
        ->add('title', 'text')
        ->add('contact', 'text')
        ->add('requiredApplication', 'textarea')
        ->add('address', 'text')
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
        'expanded' => false,
        'multiple' => false))
        ->add('otherBenefit', 'textarea')
        ->add('jobRequirement', 'textarea')
        ->add('jobPosition', 'entity', array(
        'class' => 'AcmeWorkBundle:JobPosition',
        'property' => 'name',
        'expanded' => false,
        'multiple' => false))
        ->add('location', 'entity', array(
        'class' => 'AcmeWorkBundle:Location',
        'property' => 'name',
        'expanded' => false,
        'multiple' => false))
        ->add('otherDescription', 'textarea')
        ->add('neededNumber', 'text')
        ->add('recruitedNumber', 'text')
        ->add('expiredDate', 'date', array(
        'input'  => 'datetime',
        'widget' => 'single_text',
        'format' => 'yyyy-MM-dd',))
	  	  ->getForm();

      if ($request->isMethod('POST')) {
        $form->bind($request);
        
        if ($form->isValid()) {
          $job->setUser($user);

          $em = $this->getDoctrine()->getManager();
          $em->persist($job);
          $em->flush();
          return $this->redirect($this->generateUrl('work_showJob', array('id' => $job->getId()) ));
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

    public function indexAction(Request $request)
    {
      if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
        throw new AccessDeniedException();
      }

      $user = $this->getUser();
      $jobs = $user->getJobs();
      $paginator  = $this->get('knp_paginator');
      $pagination = $paginator->paginate(
        $jobs,
        $this->get('request')->query->get('page', 1)/*page number*/,
        10/*limit per page*/
        );

      return $this->render('AcmeWorkBundle:Job:index.html.twig', array(
            'pagination' => $pagination,
            ));
    }

    public function showAction($id)
    {
      if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
        throw new AccessDeniedException();
      }

      $user = $this->getUser();
      $resume = $user->getResume();
      $job = $this->getDoctrine()
            ->getRepository('AcmeWorkBundle:Job')
            ->find($id);
      if (!$job) {
        throw $this->createNotFoundException( 
          'No job found'
        );
      }
      $applicant = new Applicant();
      $existedApplicant = false;
      $form = NULL;
      if ($user->getIsEmployer() === false) {
        $form = $this->createFormBuilder($applicant)
          ->add('job', 'hidden', array(
              'data' => $job->getId()
          ))
          ->add('resume', 'hidden', array(
              'data' => $resume->getId()
          ))
        ->getForm()->createView();
        
        foreach ($resume->getApplicants() as $key => $value) {
          if ($value->getJob() == $job)
            $existedApplicant = true;
        }
      } 
      
      return $this->render('AcmeWorkBundle:Job:show.html.twig', array(
            'job' => $job,
            'resume' => $resume,
            'form' => $form,
            'existedApplicant' => $existedApplicant,
            ));
    }

    public function updateAction($id)
    {
      if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
        throw new AccessDeniedException();
      }

      $em = $this->getDoctrine()->getManager();
      $job = $em->getRepository('AcmeWorkBundle:Job')->find($id);
      if (!$job) {
        throw $this->createNotFoundException( 
          'No job found'
        );
      }

      $user = $this->getUser();
      if ($job->getUser()->getId() != $user->getId()) {
        throw new AccessDeniedException();
      }

      $request = $this->get('request');

      $form = $this->createFormBuilder($job)
        ->add('title', 'text')
        ->add('contact', 'text')
        ->add('requiredApplication', 'textarea')
        ->add('address', 'text')
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
        'expanded' => false,
        'multiple' => false))
        ->add('otherBenefit', 'textarea')
        ->add('jobRequirement', 'textarea')
        ->add('jobPosition', 'entity', array(
        'class' => 'AcmeWorkBundle:JobPosition',
        'property' => 'name',
        'expanded' => false,
        'multiple' => false))
        ->add('location', 'entity', array(
        'class' => 'AcmeWorkBundle:Location',
        'property' => 'name',
        'expanded' => false,
        'multiple' => false))
        ->add('otherDescription', 'textarea')
        ->add('neededNumber', 'text')
        ->add('recruitedNumber', 'text')
        ->add('expiredDate', 'date', array(
        'input'  => 'datetime',
        'widget' => 'single_text',
        'format' => 'yyyy-MM-dd',))
        ->getForm();

      if ($request->isMethod('POST')) {
        $form->bind($request);
        
        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($job);
          $em->flush();
          return $this->redirect($this->generateUrl('work_showJob', array('id' => $job->getId()) ));
        } else {
          return $this->render('AcmeWorkBundle:Job:edit.html.twig', array(
            'form' => $form->createView(),
            'job' => $job,
            ));
        }
      } else {
        return $this->render('AcmeWorkBundle:Job:edit.html.twig', array(
            'form' => $form->createView(),
            'job' => $job,
            ));
      }      
    }
}
