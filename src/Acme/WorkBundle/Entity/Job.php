<?php

namespace Acme\WorkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
    * @ORM\ManyToOne(targetEntity="Acme\UserBundle\Entity\User", inversedBy="jobs")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    protected $user;

    /**
    * @ORM\ManyToMany(targetEntity="Language", inversedBy="jobs")
    * @ORM\JoinTable(name="jobs_languages")
    **/
    private $languages;

    /**
    * @ORM\ManyToMany(targetEntity="Category", inversedBy="jobs")
    * @ORM\JoinTable(name="jobs_categories")
    **/
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity="Salary", inversedBy="job")
     * @ORM\JoinColumn(name="salary_id", referencedColumnName="id")
     */
    private $salary;

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
}