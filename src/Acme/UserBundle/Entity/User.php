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
     * @ORM\OneToOne(targetEntity="Acme\WorkBundle\Entity\Resume", mappedBy="user")
     */
    protected $resume;

    /**
    * @ORM\OneToMany(targetEntity="Acme\WorkBundle\Entity\Filter", mappedBy="user")
    */
    protected $filters;

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
     * Add filters
     *
     * @param \Acme\WorkBundle\Entity\Filter $filters
     * @return User
     */
    public function addFilter(\Acme\WorkBundle\Entity\Filter $filters)
    {
        $this->filters[] = $filters;
    
        return $this;
    }

    /**
     * Remove filters
     *
     * @param \Acme\WorkBundle\Entity\Filter $filters
     */
    public function removeFilter(\Acme\WorkBundle\Entity\Filter $filters)
    {
        $this->filters->removeElement($filters);
    }

    /**
     * Get filters
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilters()
    {
        return $this->filters;
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

    /**
     * Set resume
     *
     * @param \Acme\WorkBundle\Entity\Resume $resume
     * @return User
     */
    public function setResume(\Acme\WorkBundle\Entity\Resume $resume = null)
    {
        $this->resume = $resume;
    
        return $this;
    }

    /**
     * Get resume
     *
     * @return \Acme\WorkBundle\Entity\Resume 
     */
    public function getResume()
    {
        return $this->resume;
    }
}