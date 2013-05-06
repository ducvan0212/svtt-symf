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
     * @ORM\OneToMany(targetEntity="Filter", mappedBy="salary")
     */
    private $filter;

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
     * Add filter
     *
     * @param \Acme\WorkBundle\Entity\Filter $filter
     * @return Salary
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
}