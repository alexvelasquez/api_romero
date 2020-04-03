<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cuota
 *
 * @ORM\Table(name="cuota")
 * @ORM\Entity(repositoryClass="App\Repository\CuotaRepository");
 */
class Cuota
{
    /**
     * @var int
     *
     * @ORM\Column(name="cuota_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $cuotaId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    public function __construct(\DateTime $date)
    {
        $this->date = $date;
    }


	/**
	 * Get the value of cuotaId
	 *
	 * @return  int
	 */
	public function getCuotaId()
	{
		return $this->cuotaId;
	}

	/**
	 * Set the value of cuotaId
	 *
	 * @param   int  $cuotaId  
	 *
	 * @return  self
	 */
	public function setCuotaId(int $cuotaId)
	{
		$this->cuotaId = $cuotaId;

		return $this;
	}

	/**
	 * Get the value of date
	 *
	 * @return  \DateTime
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * Set the value of date
	 *
	 * @param   \DateTime  $date  
	 *
	 * @return  self
	 */
	public function setDate(\DateTime $date)
	{
		$this->date = $date;

		return $this;
	}
}
