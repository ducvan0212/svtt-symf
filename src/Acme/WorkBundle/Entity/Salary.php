<?php

namespace Acme\WorkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salary
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Salary
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
     * @ORM\Column(name="level", type="string", length=100)
     */
    private $level;

    /**
     * @ORM\OneToMany(targetEntity="Job", mappedBy="salary")
     */
    private $job;

    /**
     * @ORM\OneToMany(targetEntity="Resume", mappedBy="salary")
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
     * Set level
     *
     * @param string $level
     * @return Salary
     */
    public function setLevel($level)
    {
        $this->level = $level;
    
        return $this;
    }

    /**
     * Get level
     *
     * @return string 
     */
    public function getLevel()
    {
        return $this->level;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->job = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add job
     *
     * @param \Acme\WorkBundle\Entity\Job $job
     * @return Salary
     */
    public function addJob(\Acme\WorkBundle\Entity\Job $job)
    {
        $this->job[] = $job;
    
        return $this;
    }

    /**
     * Remove job
     *
     * @param \Acme\WorkBundle\Entity\Job $job
     */
    public function removeJob(\Acme\WorkBundle\Entity\Job $job)
    {
        $this->job->removeElement($job);
    }

    /**
     * Get job
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Add resume
     *
     * @param \Acme\WorkBundle\Entity\Resume $resume
     * @return Salary
     */
    public function addResume(\Acme\WorkBundle\Entity\Resume $resume)
    {
        $this->resume[] = $resume;
    
        return $this;
    }

    /**
     * Remove resume
     *
     * @param \Acme\WorkBundle\Entity\Resume $resume
     */
    public function removeResume(\Acme\WorkBundle\Entity\Resume $resume)
    {
        $this->resume->removeElement($resume);
    }

    /**
     * Get resume
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getResume()
    {
        return $this->resume;
    }
}