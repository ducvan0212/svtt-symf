<?php

namespace Acme\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * @ORM\OneToMany(targetEntity="Acme\WorkBundle\Entity\Job", mappedBy="user")
    */
    protected $jobs;

    /**
    * @ORM\OneToMany(targetEntity="Acme\WorkBundle\Entity\Resume", mappedBy="user")
    */
    protected $resumes;

    /**
    * @ORM\Column(type="boolean")
    */
    protected $isEmployer = false;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->jobs = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add jobs
     *
     * @param \Acme\WorkBundle\Entity\Job $jobs
     * @return User
     */
    public function addJob(\Acme\WorkBundle\Entity\Job $jobs)
    {
        $this->jobs[] = $jobs;
    
        return $this;
    }

    /**
     * Remove jobs
     *
     * @param \Acme\WorkBundle\Entity\Job $jobs
     */
    public function removeJob(\Acme\WorkBundle\Entity\Job $jobs)
    {
        $this->jobs->removeElement($jobs);
    }

    /**
     * Get jobs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * Add resumes
     *
     * @param \Acme\WorkBundle\Entity\Resume $resumes
     * @return User
     */
    public function addResume(\Acme\WorkBundle\Entity\Resume $resumes)
    {
        $this->resumes[] = $resumes;
    
        return $this;
    }

    /**
     * Remove resumes
     *
     * @param \Acme\WorkBundle\Entity\Resume $resumes
     */
    public function removeResume(\Acme\WorkBundle\Entity\Resume $resumes)
    {
        $this->resumes->removeElement($resumes);
    }

    /**
     * Get resumes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getResumes()
    {
        return $this->resumes;
    }

    /**
     * Set employer
     *
     * @param boolean $employer
     * @return User
     */
    public function setEmployer($employer)
    {
        $this->employer = $employer;
    
        return $this;
    }

    /**
     * Get employer
     *
     * @return boolean 
     */
    public function getEmployer()
    {
        return $this->employer;
    }

    /**
     * Set isEmployer
     *
     * @param boolean $isEmployer
     * @return User
     */
    public function setIsEmployer($isEmployer)
    {
        $this->isEmployer = $isEmployer;
    
        return $this;
    }

    /**
     * Get isEmployer
     *
     * @return boolean 
     */
    public function getIsEmployer()
    {
        return $this->isEmployer;
    }
}