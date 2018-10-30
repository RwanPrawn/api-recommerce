<?php

namespace App\Entity;

use App\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class Order implements \JsonSerializable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     * 
     * @Assert\NotBlank
     * @Assert\Email(
     *      message = "This email '{{ value }}' is not valid."
     * )
     */
    private $customerEmail;

    /**
     * @var Product[]
     * 
     * @Assert\NotBlank
     */
    private $mobiles;

    /**
     * @var float
     * 
     * @Assert\NotBlank
     */
    private $amount;

    /**
     * @var \Datetime
     * 
     * @Assert\NotBlank
     */
    private $created;

    /**
     * @param string $customerEmail
     * @param Product[] $mobiles
     */
    public function __construct(string $customerEmail)
    {
        $this->customerEmail = $customerEmail;
        $this->mobiles = new ArrayCollection();
        $this->created = new \DateTime;
    }

    /**
     * @return string
     */
    public function getCustomerEmail(): string
    {
        return $this->customerEmail;
    }

    /**
     * @param string $customerEmail
     */
    public function setCustomerEmail(string $customerEmail)
    {
        $this->customerEmail = $customerEmail;
    }

    /**
     * @return Product[]
     */
    public function getMobiles(): array
    {
        return $this->mobiles;
    }

    /**
     * @param Product[]
     */
    public function setMobiles(array $mobiles)
    {
        $this->mobiles = new ArrayCollection($mobiles);
        $amount = 0.0;
        
        foreach ($mobiles as $mobile) {
            $amount += $mobile->getPrice();
        }

        $this->amount = $amount;
    }

    /**
     * @param Product
     */
    public function addMobile(Product $mobile)
    {
        $this->mobiles[] = $mobile;
        $this->amount += $mobile->getPrice();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id'                => $this->id,
            'customer_email'    => $this->customerEmail,
            'amount'            => $this->amount,
            'mobiles'           => $this->mobiles->toArray(),
            'created'           => $this->created,
        ];
    }
}
