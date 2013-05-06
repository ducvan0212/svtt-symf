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
     * @ORM\OneToMany(targetEntity="Filter", mappedBy="jobPosition")
     */
    private $filter;

    /**
     * @var integer
     *
     * @ORM\Column(name="group", type="integer")
     */
    private $group;

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

    /**
     * Add filter
     *
     * @param \Acme\WorkBundle\Entity\Filter $filter
     * @return JobPosition
     */
    public function addFilter(\Acme\WorkBundle\Entity\Filter $filter)
    {
        $this->filter[] = $filter;
    
        return $this;
    }

    /**
     * Remove filter
     *
     * @param \Acme\WorkBundle\Entity\Filter $filter
     */
    public function removeFilter(\Acme\WorkBundle\Entity\Filter $filter)
    {
        $this->filter->removeElement($filter);
    }

    /**
     * Get filter
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Set group
     *
     * @param integer $group
     * @return JobPosition
     */
    public function setGroup($group)
    {
        $this->group = $group;
    
        return $this;
    }

    /**
     * Get group
     *
     * @return integer 
     */
    public function getGroup()
    {
        return $this->group;
    }
}