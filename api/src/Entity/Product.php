<?php

namespace App\Entity;

use App\Entity\Brand;
use Symfony\Component\Validator\Constraints as Assert;

class Product implements \JsonSerializable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Brand
     * 
     * @Assert\NotBlank
     */
    private $brand;

    /**
     * @var string
     * 
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var float
     * 
     * @Assert\GreaterThan(0.0)
     */
    private $price;

    public function __construct(
        Brand $brand,
        string $name,
        float $price
    ) {
        $this->brand = $brand;
        $this->name  = $name;
        $this->price = $price;
    }

    /**
     * @return Brand
     */
    public function getBrand(): Brand
    {
        return $this->brand;
    }

    /**
     * @param Brand $brand
     */
    public function setBrand(Brand $brand)
    {
        $this->brand = $brand;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'brand' => $this->brand,
            'price' => $this->price,
        ];
    }
}
