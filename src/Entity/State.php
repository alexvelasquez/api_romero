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


}
