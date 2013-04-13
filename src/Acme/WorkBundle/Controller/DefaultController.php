<?php

namespace Acme\WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Acme\WorkBundle\Entity\Job;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        $user = $this->getUser();
        $jobs = $user->getJobs();
        $last_job = $jobs->last();
        $languages = $last_job->getLanguages();
        return array('name' => $name, 'jobs' => $jobs, 'last_job' => $last_job, 'languages' => $languages);
    }

}
