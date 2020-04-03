<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * State
 *
 * @ORM\Table(name="state")
 * @ORM\Entity(repositoryClass="App\Repository\StateRepository");
 */
class State
{
    /**
     * @var int
     *
     * @ORM\Column(name="state_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $stateId;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=64, nullable=false)
     */
    private $description;


    public function __construct()
    {
    }
	/**
	 * Get the value of stateId
	 *
	 * @return  int
	 */
	public function getStateId()
	{
		return $this->stateId;
	}

	/**
	 * Set the value of stateId
	 *
	 * @param   int  $stateId  
	 *
	 * @return  self
	 */
	public function setStateId(int $stateId)
	{
		$this->stateId = $stateId;

		return $this;
	}

	/**
	 * Get the value of description
	 *
	 * @return  string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Set the value of description
	 *
	 * @param   string  $description  
	 *
	 * @return  self
	 */
	public function setDescription(string $description)
	{
		$this->description = $description;

		return $this;
	}
}
