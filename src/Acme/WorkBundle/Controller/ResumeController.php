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
          return new Response('okok'); 
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
      $relatedJobs = $this->getDoctrine()
          ->getRepository('AcmeWorkBundle:Job')
          ->findBy(
            array('location' => $resume->getLocation())
          );
      // convert array of Job to collection array of job
      $convertedJobs = new \Doctrine\Common\Collections\ArrayCollection($relatedJobs);
      // get iterator
      $orderedJobs = $convertedJobs->getIterator();
      // really sorted collection array
      $orderedJobs->uasort(function ($first, $second) {
        if ($first === $second) {
          return 0;
        }
        $i1 = $first->getID(); $i2 = $second->getID();
        $i3 = $first->getTitle(); $i4 = $second->getTitle();
        print("first: $i1, second: $i2<br>first: $i3, second: $i4<br>");
        
        return $first->getID() < $second->getID() ? -1 : 1;
      });

      return $this->render('AcmeWorkBundle:Resume:show.html.twig', array(
            'resume' => $resume,
            'jobs' => $orderedJobs,
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
          return new Response('okok'); 
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
