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
      
      $user = $this->getUser();
      if (true === $user->getIsEmployer()) {
        throw new AccessDeniedException(); 
      }

      $resume = new Resume();

      $form = $this->createFormBuilder($resume)
        ->add('contact', 'text')
        ->add('realName', 'text')
        ->add('languages', 'entity', array(
        'class' => 'AcmeWorkBundle:Language',
        'property' => 'name',
        'expanded' => true,
        'multiple' => true))
        ->add('birthday', 'date', array(
        'input'  => 'datetime',
        'widget' => 'single_text',
        'format' => 'yyyy-MM-dd',))
        ->add('aboutMe', 'textarea')
        ->add('graduatedPlace', 'text')
        ->add('falcuty', 'text')
        ->add('averageScore', 'number')
        ->getForm();

      if ($request->isMethod('POST')) {
        $form->bind($request);
        
        if ($form->isValid()) {
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
        ->add('contact', 'text')
        ->add('realName', 'text')
        ->add('languages', 'entity', array(
        'class' => 'AcmeWorkBundle:Language',
        'property' => 'name',
        'expanded' => true,
        'multiple' => true))
        ->add('birthday', 'date', array(
        'input'  => 'datetime',
        'widget' => 'single_text',
        'format' => 'yyyy-MM-dd',))
        ->add('aboutMe', 'textarea')
        ->add('graduatedPlace', 'text')
        ->add('falcuty', 'text')
        ->add('averageScore', 'number')
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
