<?php

namespace Acme\WorkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Location
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
    * @ORM\OneToMany(targetEntity="Job", mappedBy="location")
    */
    protected $jobs;

    /**
    * @ORM\OneToMany(targetEntity="Resume", mappedBy="location")
    */
    protected $resumes;

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
     * Set name
     *
     * @param string $name
     * @return Location
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->jobs = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add jobs
     *
     * @param \Acme\WorkBundle\Entity\Job $jobs
     * @return Location
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
     * @return Location
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
}