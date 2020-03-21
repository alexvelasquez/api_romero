<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository");
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="category_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $categoryId;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=64, nullable=false)
     */
    private $description;

    public function __construct(String $description)
    {
        $this->description = $description;
    }


	/**
	 * Get the value of categoryId
	 *
	 * @return  int
	 */
	public function getCategoryId()
	{
		return $this->categoryId;
	}

	/**
	 * Set the value of categoryId
	 *
	 * @param   int  $categoryId  
	 *
	 * @return  self
	 */
	public function setCategoryId(int $categoryId)
	{
		$this->categoryId = $categoryId;

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
