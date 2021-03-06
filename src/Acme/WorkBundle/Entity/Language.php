<?php

namespace Acme\WorkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Language
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Language
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
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;

    /**
    * @ORM\ManyToMany(targetEntity="Acme\WorkBundle\Entity\Job", mappedBy="languages")
    **/
    private $jobs;
	
    /**
    * @ORM\ManyToMany(targetEntity="Acme\WorkBundle\Entity\Resume", mappedBy="languages")
    **/
    private $resumes;

    /**
    * @ORM\ManyToMany(targetEntity="Acme\WorkBundle\Entity\Filter", mappedBy="languages")
    **/
    private $filters;

	public function __construct() {
        $this->jobs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Language
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
     * Add jobs
     *
     * @param \Acme\WorkBundle\Entity\Job $jobs
     * @return Language
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
     * @return Language
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
     * Add resumes
     *
     * @param \Acme\WorkBundle\Entity\Resume $resumes
     * @return Language
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