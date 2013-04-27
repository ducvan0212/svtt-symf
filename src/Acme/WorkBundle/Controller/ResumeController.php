<?php

namespace Acme\WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
      return $this->render('AcmeWorkBundle:Resume:show.html.twig', array(
            'resume' => $resume,
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
