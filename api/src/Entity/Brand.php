<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Brand implements \JsonSerializable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     * 
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
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
        ];
    }
}
