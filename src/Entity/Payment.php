<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payment
 *
 * @ORM\Table(name="payment", indexes={@ORM\Index(name="cuota_id", columns={"cuota_id"}), @ORM\Index(name="state_id", columns={"state_id"}), @ORM\Index(name="player_id", columns={"player_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\PaymentRepository");
 */
class Payment
{
    /**
     * @var int
     *
     * @ORM\Column(name="payment_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $paymentId;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer", nullable=false)
     */
    private $value;

    /**
     * @var \Player
     *
     * @ORM\ManyToOne(targetEntity="Player",fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="player_id", referencedColumnName="player_id")
     * })
     */
    private $player;

    /**
     * @var \Cuota
     *
     * @ORM\ManyToOne(targetEntity="Cuota")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cuota_id", referencedColumnName="cuota_id")
     * })
     */
    private $cuota;

    /**
     * @var \State
     *
     * @ORM\ManyToOne(targetEntity="State",fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="state_id", referencedColumnName="state_id")
     * })
     */
    private $state;


    public function __construct(Player $player, Cuota $cuota, State $state, $value)
    {	
        $this->player = $player;
        $this->cuota = $cuota;
        $this->state = $state;
		$this->value = $value;
    }


	/**
	 * Get the value of paymentId
	 *
	 * @return  int
	 */
	public function getPaymentId()
	{
		return $this->paymentId;
	}

	/**
	 * Set the value of paymentId
	 *
	 * @param   int  $paymentId  
	 *
	 * @return  self
	 */
	public function setPaymentId(int $paymentId)
	{
		$this->paymentId = $paymentId;

		return $this;
	}

	/**
	 * Get the value of value
	 *
	 * @return  int
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * Set the value of value
	 *
	 * @param   int  $value  
	 *
	 * @return  self
	 */
	public function setValue(int $value)
	{
		$this->value = $value;

		return $this;
	}

	/**
	 * Get the value of player
	 *
	 * @return  \Player
	 */
	public function getPlayer()
	{
		return $this->player;
	}

	/**
	 * Set the value of player
	 *
	 * @param   \Player  $player  
	 *
	 * @return  self
	 */
	public function setPlayer(Player $player)
	{
		$this->player = $player;

		return $this;
	}

	/**
	 * Get the value of cuota
	 *
	 * @return  \Cuota
	 */
	public function getCuota()
	{
		return $this->cuota;
	}

	/**
	 * Set the value of cuota
	 *
	 * @param   \Cuota  $cuota  
	 *
	 * @return  self
	 */
	public function setCuota(Cuota $cuota)
	{
		$this->cuota = $cuota;

		return $this;
	}

	/**
	 * Get the value of state
	 *
	 * @return  \State
	 */
	public function getState()
	{
		return $this->state;
	}

	/**
	 * Set the value of state
	 *
	 * @param   \State  $state  
	 *
	 * @return  self
	 */
	public function setState(State $state)
	{
		$this->state = $state;

		return $this;
	}
}
