<?php

namespace Acme\WorkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Count;

/**
 * Resume
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Resume
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
    * @ORM\ManyToOne(targetEntity="Acme\UserBundle\Entity\User", inversedBy="resumes")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    protected $user;

    /**
    * @ORM\ManyToOne(targetEntity="Location", inversedBy="resumes")
    * @ORM\JoinColumn(name="location_id", referencedColumnName="id")
    */
    protected $location;

    /**
    * @ORM\ManyToMany(targetEntity="Language", inversedBy="resumes")
    * @ORM\JoinTable(name="resumes_languages")
    * @Count(min = 1, minMessage = "At least one language must be selected")
    **/
    private $languages;

    /**
     * @ORM\ManyToOne(targetEntity="Salary", inversedBy="resume")
     * @ORM\JoinColumn(name="salary_id", referencedColumnName="id")
     */
    private $salary;

    /**
    * @ORM\ManyToMany(targetEntity="Category", inversedBy="resumes")
    * @ORM\JoinTable(name="resumes_categories")
    * @Count(min = 1, max = 4, minMessage = "At least one category must be selected", maxMessage = " |You cannot specify more than 5 categories")
    **/
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity="JobPosition", inversedBy="resume")
     * @ORM\JoinColumn(name="jobPosition_id", referencedColumnName="id")
    */
    private $jobPosition;

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
     * Constructor
     */
    public function __construct()
    {
        $this->languages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set location
     *
     * @param \Acme\WorkBundle\Entity\Location $location
     * @return Resume
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

    /**
     * Add languages
     *
     * @param \Acme\WorkBundle\Entity\Language $languages
     * @return Resume
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
     * Set salary
     *
     * @param \Acme\WorkBundle\Entity\Salary $salary
     * @return Resume
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
     * Add categories
     *
     * @param \Acme\WorkBundle\Entity\Category $categories
     * @return Resume
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
     * Set jobPosition
     *
     * @param \Acme\WorkBundle\Entity\JobPosition $jobPosition
     * @return Resume
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
     * Set user
     *
     * @param \Acme\UserBundle\Entity\User $user
     * @return Resume
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
}