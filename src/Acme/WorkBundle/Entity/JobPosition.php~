<?php

namespace Acme\WorkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JobPosition
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class JobPosition
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Job", mappedBy="jobPosition")
     */
    private $job;

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
     * @return JobPosition
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
        $this->job = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add job
     *
     * @param \Acme\WorkBundle\Entity\Job $job
     * @return JobPosition
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
}