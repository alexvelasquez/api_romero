<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Category;

/**
 * Player
 *
 * @ORM\Table(name="player", indexes={@ORM\Index(name="category_id", columns={"category_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository");
 */
class Player
{
    /**
     * @var int
     *
     * @ORM\Column(name="player_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $playerId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=32, nullable=false)
     */
    private $lastName;

    /**
     * @var int
     *
     * @ORM\Column(name="dni", type="integer", nullable=true)
     */
    private $dni;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     */
	private $birthDate;
	
	/**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=32, nullable=true)
     */
    private $phone;

    /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="category_id")
     * })
     */
    private $category;



    public function __construct(String $name, String $lastName, Category $category,\DateTime $birthDate = null, String $dni = null,String $phone = null)
    {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->birthDate = $birthDate;
		$this->dni = $dni;
		$this->phone = $phone;
        $this->category = $category;

    }

	/**
	 * Get the value of playerId
	 *
	 * @return  int
	 */
	public function getPlayerId()
	{
		return $this->playerId;
	}

	/**
	 * Set the value of playerId
	 *
	 * @param   int  $playerId  
	 *
	 * @return  self
	 */
	public function setPlayerId(int $playerId)
	{
		$this->playerId = $playerId;

		return $this;
	}

	/**
	 * Get the value of name
	 *
	 * @return  string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set the value of name
	 *
	 * @param   string  $name  
	 *
	 * @return  self
	 */
	public function setName(string $name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get the value of lastName
	 *
	 * @return  string
	 */
	public function getLastName()
	{
		return $this->lastName;
	}

	/**
	 * Set the value of lastName
	 *
	 * @param   string  $lastName  
	 *
	 * @return  self
	 */
	public function setLastName(string $lastName)
	{
		$this->lastName = $lastName;

		return $this;
	}

	/**
	 * Get the value of dni
	 *
	 * @return 
	 */
	public function getDni()
	{
		return $this->dni;
	}

	/**
	 * Set the value of dni
	 *
	 * @param 
	 *
	 * @return  self
	 */
	public function setDni($dni)
	{
		$this->dni = $dni;

		return $this;
	}

	/**
	 * Get the value of birthDate
	 *
	 * @return 
	 */
	public function getBirthDate()
	{
		return $this->birthDate;
	}

	/**
	 * Set the value of birthDate
	 *
	 * @param   $birthDate  
	 *
	 * @return  self
	 */
	public function setBirthDate($birthDate)
	{
		$this->birthDate = $birthDate;

		return $this;
	}

	/**
	 * Get the value of phone
	 *
	 * @return 
	 */
	public function getPhone()
	{
		return $this->phone;
	}

	/**
	 * Set the value of phone
	 *
	 * @param   
	 *
	 * @return  self
	 */
	public function setPhone( $phone)
	{
		$this->phone = $phone;

		return $this;
	}
	/**
	 * Get the value of category
	 *
	 * @return  Category
	 */
	public function getCategory()
	{
		return $this->category;
	}

	/**
	 * Set the value of category
	 *
	 * @param   Category  $category  
	 *
	 * @return  self
	 */
	public function setCategory(Category $category)
	{
		$this->category = $category;

		return $this;
	}
}
