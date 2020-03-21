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
     * @ORM\ManyToOne(targetEntity="Player")
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
     * @ORM\ManyToOne(targetEntity="State")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="state_id", referencedColumnName="state_id")
     * })
     */
    private $state;


}
