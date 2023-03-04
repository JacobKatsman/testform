<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Descriptions
 *
 * @ORM\Table(name="order")
 */
class Order
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="taxnumber", type="string", nullable=true)
     * @Assert\NotBlank(message="Blank Fields value taxnumber not allow!")
     * @Assert\Length(
     *     min=9,
     *     max=11,
     *     minMessage="The name must be at least 9 characters long",
     *     maxMessage="The name cannot be longer than 11 characters"
     * )
     * @Assert\Regex(
     *     pattern="/^(DE\d{9}|IT\d{11}|GR\d{9})/",
     *     message="This code not allowed"
     * )
     */
    private $taxnumber;

    /**
     * @var int
     *
     * @ORM\Column(name="productPrice", type="integer", length=255, nullable=true)
     * @Assert\NotBlank(message="Blank Fields value product not allow!")
     */
    private $productPrice;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductPrice(): ?int
    {
        return $this->productPrice;
    }

    public function getTaxnumber(): ?string
    {
        return $this->taxnumber;
    }

    /**
     * @param int $productPrice
     */
    public function setProductPrice(int $productPrice): self
    {
        $this->productPrice = $productPrice;

        return $this;
    }
    /**
     * @param string $taxnumber
     */
    public function setTaxnumber(string $taxnumber): self
    {
        $this->taxnumber = $taxnumber;
        return $this;
    }
}
