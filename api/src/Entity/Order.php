<?php

namespace App\Entity;

use App\Entity\Product;

class Order implements \JsonSerializable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $customerEmail;

    /**
     * @var Product[]
     */
    private $mobiles;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var \Datetime
     */
    private $created;

    /**
     * @param string $customerEmail
     * @param Product[] $mobiles
     */
    public function __construct(
        string $customerEmail,
        array $mobiles
    ) {
        $this->customerEmail = $customerEmail;
        $this->setMobiles($mobiles);
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
        $this->mobiles = $mobiles;
        $amount = 0.0;
        
        foreach ($mobiles as $mobile) {
            $amount += $mobile->getPrice();
        }

        $this->amount = $amount;
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

    public function jsonSerialize(): array
    {
        return [
            'id'                => $this->id,
            'customer_email'    => $this->customerEmail,
            'amount'            => $this->amount,
            'mobiles'           => $this->mobiles,
            'created'           => $this->created,
        ];
    }
}
