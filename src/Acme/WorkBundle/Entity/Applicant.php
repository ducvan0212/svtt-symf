<?php

namespace Acme\WorkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Applicant
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Applicant
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
    * @ORM\Column(type="boolean")
    */
    private $consideration = false;

    /**
     * @ORM\ManyToOne(targetEntity="Job", inversedBy="applicants")
     * @ORM\JoinColumn(name="job_id", referencedColumnName="id")
    */
    private $job;

    /**
     * @ORM\ManyToOne(targetEntity="Resume", inversedBy="applicants")
     * @ORM\JoinColumn(name="resume_id", referencedColumnName="id")
    */
    private $resume;

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
     * Set consideration
     *
     * @param boolean $consideration
     * @return Applicant
     */
    public function setConsideration($consideration)
    {
        $this->consideration = $consideration;
    
        return $this;
    }

    /**
     * Get consideration
     *
     * @return boolean 
     */
    public function getConsideration()
    {
        return $this->consideration;
    }

    /**
     * Set job
     *
     * @param \Acme\WorkBundle\Entity\Job $job
     * @return Applicant
     */
    public function setJob(\Acme\WorkBundle\Entity\Job $job = null)
    {
        $this->job = $job;
    
        return $this;
    }

    /**
     * Get job
     *
     * @return \Acme\WorkBundle\Entity\Job 
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set resume
     *
     * @param \Acme\WorkBundle\Entity\Resume $resume
     * @return Applicant
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