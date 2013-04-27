<?php

namespace Acme\WorkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Count;

/**
 * Job
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Job
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="text")
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="requiredApplication", type="text")
     */
    private $requiredApplication;    

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text")
     */
    private $address;

    /**
    * @ORM\ManyToOne(targetEntity="Acme\UserBundle\Entity\User", inversedBy="jobs")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    protected $user;

    /**
    * @ORM\ManyToMany(targetEntity="Language", inversedBy="jobs")
    * @ORM\JoinTable(name="jobs_languages")
    * @Count(min = 1, minMessage = "At least one language must be selected")
    **/
    private $languages;

    /**
    * @ORM\ManyToMany(targetEntity="Category", inversedBy="jobs")
    * @ORM\JoinTable(name="jobs_categories")
    * @Count(min = 1, minMessage = "At least one category must be selected")
    **/
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity="Salary", inversedBy="job")
     * @ORM\JoinColumn(name="salary_id", referencedColumnName="id")
     */
    private $salary;

    /**
     * @ORM\ManyToOne(targetEntity="JobPosition", inversedBy="job")
     * @ORM\JoinColumn(name="jobPosition_id", referencedColumnName="id")
    */
    private $jobPosition;

    /**
     * @var string
     *
     * @ORM\Column(name="otherBenefit", type="text")
     */
    private $otherBenefit;

    /**
     * @var string
     *
     * @ORM\Column(name="jobRequirement", type="text")
     */
    private $jobRequirement;

    /**
     * @var string
     *
     * @ORM\Column(name="otherDescription", type="text")
     */
    private $otherDescription;

    /**
    * @ORM\ManyToOne(targetEntity="Location", inversedBy="jobs")
    * @ORM\JoinColumn(name="location_id", referencedColumnName="id")
    */
    protected $location;

    public function __construct() {
        $this->languages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Job
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set contact
     *
     * @param string $contact
     * @return Job
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    
        return $this;
    }

    /**
     * Get contact
     *
     * @return string 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set user
     *
     * @param \Acme\UserBundle\Entity\User $user
     * @return Job
     */
    public function setUser(\Acme\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Acme\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add languages
     *
     * @param \Acme\WorkBundle\Entity\Language $languages
     * @return Job
     */
    public function addLanguage(\Acme\WorkBundle\Entity\Language $languages)
    {
        $this->languages[] = $languages;
    
        return $this;
    }

    /**
     * Remove languages
     *
     * @param \Acme\WorkBundle\Entity\Language $languages
     */
    public function removeLanguage(\Acme\WorkBundle\Entity\Language $languages)
    {
        $this->languages->removeElement($languages);
    }

    /**
     * Get languages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Set requiredApplication
     *
     * @param string $requiredApplication
     * @return Job
     */
    public function setRequiredApplication($requiredApplication)
    {
        $this->requiredApplication = $requiredApplication;
    
        return $this;
    }

    /**
     * Get requiredApplication
     *
     * @return string 
     */
    public function getRequiredApplication()
    {
        return $this->requiredApplication;
    }

    /**
     * Add categories
     *
     * @param \Acme\WorkBundle\Entity\Category $categories
     * @return Job
     */
    public function addCategorie(\Acme\WorkBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;
    
        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Acme\WorkBundle\Entity\Category $categories
     */
    public function removeCategorie(\Acme\WorkBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set salary
     *
     * @param \Acme\WorkBundle\Entity\Salary $salary
     * @return Job
     */
    public function setSalary(\Acme\WorkBundle\Entity\Salary $salary = null)
    {
        $this->salary = $salary;
    
        return $this;
    }

    /**
     * Get salary
     *
     * @return \Acme\WorkBundle\Entity\Salary 
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Set otherBenefit
     *
     * @param string $otherBenefit
     * @return Job
     */
    public function setOtherBenefit($otherBenefit)
    {
        $this->otherBenefit = $otherBenefit;
    
        return $this;
    }

    /**
     * Get otherBenefit
     *
     * @return string 
     */
    public function getOtherBenefit()
    {
        return $this->otherBenefit;
    }

    /**
     * Set jobRequirement
     *
     * @param string $jobRequirement
     * @return Job
     */
    public function setJobRequirement($jobRequirement)
    {
        $this->jobRequirement = $jobRequirement;
    
        return $this;
    }

    /**
     * Get jobRequirement
     *
     * @return string 
     */
    public function getJobRequirement()
    {
        return $this->jobRequirement;
    }

    /**
     * Set jobPosition
     *
     * @param \Acme\WorkBundle\Entity\JobPosition $jobPosition
     * @return Job
     */
    public function setJobPosition(\Acme\WorkBundle\Entity\JobPosition $jobPosition = null)
    {
        $this->jobPosition = $jobPosition;
    
        return $this;
    }

    /**
     * Get jobPosition
     *
     * @return \Acme\WorkBundle\Entity\JobPosition 
     */
    public function getJobPosition()
    {
        return $this->jobPosition;
    }

    /**
     * Set otherDescription
     *
     * @param string $otherDescription
     * @return Job
     */
    public function setOtherDescription($otherDescription)
    {
        $this->otherDescription = $otherDescription;
    
        return $this;
    }

    /**
     * Get otherDescription
     *
     * @return string 
     */
    public function getOtherDescription()
    {
        return $this->otherDescription;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Job
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set location
     *
     * @param \Acme\WorkBundle\Entity\Location $location
     * @return Job
     */
    public function setLocation(\Acme\WorkBundle\Entity\Location $location = null)
    {
        $this->location = $location;
    
        return $this;
    }

    /**
     * Get location
     *
     * @return \Acme\WorkBundle\Entity\Location 
     */
    public function getLocation()
    {
        return $this->location;
    }
}