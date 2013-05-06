<?php

namespace Acme\WorkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Range;

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
    * @ORM\OneToOne(targetEntity="Acme\UserBundle\Entity\User", inversedBy="resume")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="text")
     */
    private $contact;

    /**
     * @ORM\Column(name="birthday", type="date")
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="realName", type="text")
     */
    private $realName;

    /**
     * @var string
     *
     * @ORM\Column(name="aboutMe", type="text")
     */
    private $aboutMe;

    /**
     * @var string
     *
     * @ORM\Column(name="graduatedPlace", type="text")
     */
    private $graduatedPlace;

    /**
     * @var string
     *
     * @ORM\Column(name="falcuty", type="text")
     */
    private $falcuty;

    /**
     * @ORM\Column(name="averageScore", type="decimal", scale=2))
     * @Range(min = 0, max = 10, minMessage = "Minimum is 1", maxMessage = "Maximum is 10")
     */
    private $averageScore;    

    /**
    * @ORM\ManyToMany(targetEntity="Language", inversedBy="resumes")
    * @ORM\JoinTable(name="resumes_languages")
    * @Count(min = 1, minMessage = "At least one language must be selected")
    **/
    private $languages;

    /**
    * @ORM\ManyToMany(targetEntity="Job", inversedBy="resumes")
    * @ORM\JoinTable(name="resumes_jobs")
    **/
    private $jobs;

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
        $this->jobs = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set contact
     *
     * @param string $contact
     * @return Resume
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
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return Resume
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    
        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set aboutMe
     *
     * @param string $aboutMe
     * @return Resume
     */
    public function setAboutMe($aboutMe)
    {
        $this->aboutMe = $aboutMe;
    
        return $this;
    }

    /**
     * Get aboutMe
     *
     * @return string 
     */
    public function getAboutMe()
    {
        return $this->aboutMe;
    }

    /**
     * Set graduatedPlace
     *
     * @param string $graduatedPlace
     * @return Resume
     */
    public function setGraduatedPlace($graduatedPlace)
    {
        $this->graduatedPlace = $graduatedPlace;
    
        return $this;
    }

    /**
     * Get graduatedPlace
     *
     * @return string 
     */
    public function getGraduatedPlace()
    {
        return $this->graduatedPlace;
    }

    /**
     * Set falcuty
     *
     * @param string $falcuty
     * @return Resume
     */
    public function setFalcuty($falcuty)
    {
        $this->falcuty = $falcuty;
    
        return $this;
    }

    /**
     * Get falcuty
     *
     * @return string 
     */
    public function getFalcuty()
    {
        return $this->falcuty;
    }

    /**
     * Set averageScore
     *
     * @param float $averageScore
     * @return Resume
     */
    public function setAverageScore($averageScore)
    {
        $this->averageScore = $averageScore;
    
        return $this;
    }

    /**
     * Get averageScore
     *
     * @return float 
     */
    public function getAverageScore()
    {
        return $this->averageScore;
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
     * Set realName
     *
     * @param string $realName
     * @return Resume
     */
    public function setRealName($realName)
    {
        $this->realName = $realName;
    
        return $this;
    }

    /**
     * Get realName
     *
     * @return string 
     */
    public function getRealName()
    {
        return $this->realName;
    }

    /**
     * Add jobs
     *
     * @param \Acme\WorkBundle\Entity\Job $jobs
     * @return Resume
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
}