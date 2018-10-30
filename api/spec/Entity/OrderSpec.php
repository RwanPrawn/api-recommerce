<?php

namespace Spec\Entity;

use App\Entity\Order;
use PhpSpec\ObjectBehavior;

class OrderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Order::class);
    }
}