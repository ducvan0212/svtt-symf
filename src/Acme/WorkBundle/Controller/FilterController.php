<?php

namespace Acme\WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\Common\Collections\ArrayCollection;

use Acme\WorkBundle\Entity\Filter;

class FilterController extends Controller
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

      $filter = new Filter();

      $form = $this->createFormBuilder($filter)
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
          $filter->setUser($user);

          $em = $this->getDoctrine()->getManager();
          $em->persist($filter);
          $em->flush();
          return $this->redirect($this->generateUrl('work_showFilter', array('id' => $filter->getId()) ));
        } else {
          return $this->render('AcmeWorkBundle:Filter:new.html.twig', array(
            'form' => $form->createView(),
            ));
        }
      } else {
        return $this->render('AcmeWorkBundle:Filter:new.html.twig', array(
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
      $filters = $user->getFilters();
      return $this->render('AcmeWorkBundle:Filter:index.html.twig', array(
            'filters' => $filters,
            ));
    }

    public function showAction($id)
    {
      if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
        throw new AccessDeniedException();
      }

      $filter = $this->getDoctrine()
            ->getRepository('AcmeWorkBundle:Filter')
            ->find($id);
      if (!$filter) {
        throw $this->createNotFoundException( 
          'No filter found'
        );
      }
      $qb = $this->getDoctrine()->getRepository('AcmeWorkBundle:Job')->createQueryBuilder('j')
      ->where('j.location = :location AND j.expiredDate > :current_date')
      ->setParameter('location', $filter->getLocation())
      ->setParameter('current_date', new \Datetime('now'));

      $relatedJobs = $qb->getQuery()->getResult();
      // $relatedJobs = $this->getDoctrine()
      //     ->getRepository('AcmeWorkBundle:Job')
      //     ->findBy(
      //       array('location' => $filter->getLocation())
      //       array('date' => $filter->getLocation())
      //     );

      // convert array of Job to collection array of job
      $convertedJobs = new \Doctrine\Common\Collections\ArrayCollection($relatedJobs);
      // get iterator
      $orderedJobs = $convertedJobs->getIterator();
      // really sorted collection array
      // dung & de reference
      // $orderedJobs->uasort(function ($first, $second) use( &$filter) {
      $orderedJobs->uasort(function ($first, $second) use( $filter) {
        if ($first === $second) {
          return 0;
        }
        // $i1 = $first->getID(); $i2 = $second->getID();
        // $i3 = $first->estimator($filter);
        // $i4 = $second->estimator($filter);
        // print("first: $i1, second: $i2<br>es first: $i3, es second: $i4<br>");
        
        return $first->estimator($filter) > $second->estimator($filter) ? -1 : 1;
      });
      
      $orderedJobsInArray =  iterator_to_array($orderedJobs);
      $paginator  = $this->get('knp_paginator');
      $pagination = $paginator->paginate(
        $orderedJobsInArray,
        $this->get('request')->query->get('page', 1)/*page number*/,
        5/*limit per page*/
        );

      return $this->render('AcmeWorkBundle:Filter:show.html.twig', array(
            'filter' => $filter,
            'pagination' => $pagination,
            ));
    }

    public function updateAction($id)
    {
      if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
        throw new AccessDeniedException();
      }

      $em = $this->getDoctrine()->getManager();
      $filter = $em->getRepository('AcmeWorkBundle:Filter')->find($id);
      if (!$filter) {
        throw $this->createNotFoundException( 
          'No filter found'
        );
      }

      $request = $this->get('request');

      $form = $this->createFormBuilder($filter)
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
          $em->persist($filter);
          $em->flush();
          return $this->redirect($this->generateUrl('work_showFilter', array('id' => $filter->getId()) ));
        } else {
          return $this->render('AcmeWorkBundle:Filter:edit.html.twig', array(
            'form' => $form->createView(),
            'filter' => $filter,
            ));
        }
      } else {
        return $this->render('AcmeWorkBundle:Filter:edit.html.twig', array(
            'form' => $form->createView(),
            'filter' => $filter,
            ));
      }      
    }
}
