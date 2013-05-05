<?php

namespace Acme\WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\Common\Collections\ArrayCollection;

use Acme\WorkBundle\Entity\Resume;

class ResumeController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */

    public function createAction(Request $request)
    {
      if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
        throw new AccessDeniedException();
      }

      $resume = new Resume();

      $form = $this->createFormBuilder($resume)
        // ->add('contact', 'text')
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
        ->getForm();

      if ($request->isMethod('POST')) {
        $form->bind($request);
        
        if ($form->isValid()) {
          $user = $this->getUser();
          // var_dump($user->getUsername());die();
          $resume->setUser($user);

          $em = $this->getDoctrine()->getManager();
          $em->persist($resume);
          $em->flush();
          return $this->redirect($this->generateUrl('work_showResume', array('id' => $resume->getId()) ));
        } else {
          return $this->render('AcmeWorkBundle:Resume:new.html.twig', array(
            'form' => $form->createView(),
            ));
        }
      } else {
        return $this->render('AcmeWorkBundle:Resume:new.html.twig', array(
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
      $resumes = $user->getResumes();
      return $this->render('AcmeWorkBundle:Resume:index.html.twig', array(
            'resumes' => $resumes,
            ));
    }

    public function showAction($id)
    {
      if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
        throw new AccessDeniedException();
      }

      $resume = $this->getDoctrine()
            ->getRepository('AcmeWorkBundle:Resume')
            ->find($id);
      if (!$resume) {
        throw $this->createNotFoundException( 
          'No resume found'
        );
      }
      $qb = $this->getDoctrine()->getRepository('AcmeWorkBundle:Job')->createQueryBuilder('j')
      ->where('j.location = :location AND j.expiredDate > :current_date')
      ->setParameter('location', $resume->getLocation())
      ->setParameter('current_date', new \Datetime('now'));

      $relatedJobs = $qb->getQuery()->getResult();
      // $relatedJobs = $this->getDoctrine()
      //     ->getRepository('AcmeWorkBundle:Job')
      //     ->findBy(
      //       array('location' => $resume->getLocation())
      //       array('date' => $resume->getLocation())
      //     );

      // convert array of Job to collection array of job
      $convertedJobs = new \Doctrine\Common\Collections\ArrayCollection($relatedJobs);
      // get iterator
      $orderedJobs = $convertedJobs->getIterator();
      // really sorted collection array
      // dung & de reference
      // $orderedJobs->uasort(function ($first, $second) use( &$resume) {
      $orderedJobs->uasort(function ($first, $second) use( $resume) {
        if ($first === $second) {
          return 0;
        }
        // $i1 = $first->getID(); $i2 = $second->getID();
        // $i3 = $first->estimator($resume);
        // $i4 = $second->estimator($resume);
        // print("first: $i1, second: $i2<br>es first: $i3, es second: $i4<br>");
        
        return $first->estimator($resume) > $second->estimator($resume) ? -1 : 1;
      });
      
      $orderedJobsInArray =  iterator_to_array($orderedJobs);
      $paginator  = $this->get('knp_paginator');
      $pagination = $paginator->paginate(
        $orderedJobsInArray,
        $this->get('request')->query->get('page', 1)/*page number*/,
        5/*limit per page*/
        );

      return $this->render('AcmeWorkBundle:Resume:show.html.twig', array(
            'resume' => $resume,
            'pagination' => $pagination,
            ));
    }

    public function updateAction($id)
    {
      if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
        throw new AccessDeniedException();
      }

      $em = $this->getDoctrine()->getManager();
      $resume = $em->getRepository('AcmeWorkBundle:Resume')->find($id);
      if (!$resume) {
        throw $this->createNotFoundException( 
          'No resume found'
        );
      }

      $request = $this->get('request');

      $form = $this->createFormBuilder($resume)
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
      ->getForm();
      if ($request->isMethod('POST')) {
        $form->bind($request);
        
        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($resume);
          $em->flush();
          return $this->redirect($this->generateUrl('work_showResume', array('id' => $resume->getId()) ));
        } else {
          return $this->render('AcmeWorkBundle:Resume:edit.html.twig', array(
            'form' => $form->createView(),
            'resume' => $resume,
            ));
        }
      } else {
        return $this->render('AcmeWorkBundle:Resume:edit.html.twig', array(
            'form' => $form->createView(),
            'resume' => $resume,
            ));
      }      
    }
}
