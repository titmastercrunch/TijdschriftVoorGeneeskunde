<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class User
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="regular_user")
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=150)
     */
    protected $_name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=150)
     */
    protected $_firstname;

    /**
     * @var string
     * @ORM\Column(name="telephone", type="phone_number")
     * @AssertPhoneNumber(defaultRegion="BE")
     */
    protected $_telephone;

    /**
     * @var Subscriber
     *
     * @ORM\OneToOne(targetEntity="Subscriber", mappedBy="_user")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    protected $_subscriber;

    /**
     * @var Bookstore
     *
     * @ORM\ManyToOne(targetEntity="Bookstore", inversedBy="_subscribers")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $_bookstore;

    /**
     * @var HealthCare
     *
     * @ORM\ManyToOne(targetEntity="HealthCare", inversedBy="_subscribers")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $_healthcare;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime")
     * @var \DateTime
     */
    protected $_created;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return this
     */
    public function setName($name)
    {
        $this->_name = $name;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->_firstname;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return this
     */
    public function setFirstName($name)
    {
        $this->_firstname = $name;

        return $this;
    }

    /**
     * Get Telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->_telephone;
    }

    /**
     * Set name
     *
     * @param PhoneNumber $telephone
     * @return this
     */
    public function setTelephone(\libphonenumber\PhoneNumber $telephone)
    {
        $this->_telephone = $telephone;

        return $this;
    }

    /**
     * @return Subscriber
     */
    public function getSubscriber()
    {
        return $this->_subscriber;
    }

    /**
     * @param Subscriber
     * @return this
     */
    public function setSubscriber($subscriber)
    {
        $this->_subscriber = $subscriber;

        return $this;
    }

    /**
     * @return Bookstore
     */
    public function getBookstore()
    {
        return $this->_bookstore;
    }

    /**
     * @param Bookstore
     * @return this
     */
    public function setBookstore($bookstore)
    {
        $this->_bookstore = $bookstore;

        return $this;
    }

    /**
     * @return HealthCare
     */
    public function getHealthCare()
    {
        return $this->_healthcare;
    }

    /**
     * @param HealthCare
     * @return this
     */
    public function setHealthCare($healthcare)
    {
        $this->_healthcare= $healthcare;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->_created;
    }

    /**
     * @param Datetime $created
     */
    public function setCreated($created)
    {
        $this->_created = $created;

        return $this;
    }
}
