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


}
