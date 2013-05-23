<?php

namespace Acme\WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Acme\WorkBundle\Entity\Applicant;

class ApplicantController extends Controller
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
        
        $resume = $user->getResume();

        $job = $this->getDoctrine()
            ->getRepository('AcmeWorkBundle:Job')
            ->find($request->request->get('form')['job']);

        $applicant = new Applicant();

        $form = $this->createFormBuilder($applicant)
            ->add('job', 'hidden', array(
                'data' => $job->getId()
            ))
            ->add('resume', 'hidden', array(
                'data' => $resume->getId()
            ))
        ->getForm()->createView();
        
        $existedApplicant = false;
        foreach ($resume->getApplicants() as $key => $value) {
          if ($value->getJob() == $job)
            $existedApplicant = true;
        }

        $applicant->setResume($resume);
        $applicant->setJob($job);

        if ($request->isMethod('POST') && $existedApplicant == false) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($applicant);
            $em->flush();
            $existedApplicant = true;
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

        $applicant = $this->getDoctrine()
            ->getRepository('AcmeWorkBundle:Applicant')
            ->find($id);

        $job = $applicant->getJob();

        if ($applicant->getConsideration()) {
            $applicant->setConsideration(false);
            $job->setRecruitedNumber($job->getRecruitedNumber() - 1);
        } else {
            $applicant->setConsideration(true);
            $job->setRecruitedNumber($job->getRecruitedNumber() + 1);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($applicant);
        $em->flush();

        $job = $applicant->getJob();
        $resume = $applicant->getResume();
        $form = $this->createFormBuilder($applicant)
            ->add('job', 'hidden', array(
                'data' => $job->getId()
            ))
            ->add('resume', 'hidden', array(
                'data' => $resume->getId()
            ))
        ->getForm()->createView();
        $existedApplicant = true;

        return $this->render('AcmeWorkBundle:Job:show.html.twig', array(
            'job' => $job,
            'resume' => $resume,
            'form' => $form,
            'existedApplicant' => $existedApplicant,
            ));
    }
}
