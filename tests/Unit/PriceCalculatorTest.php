<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\PriceCalculator;

class PriceCalculatorTest extends TestCase
{
    public function test_discount_calculation()
    {
        $calculator = new PriceCalculator();
        $finalPrice = $calculator->applyDiscount(100, 10); // 10% discount

        $this->assertEquals(90, $finalPrice);
    }

    // public function test_example(): void
    // {
    //     $this->assertTrue(true);
    // }
}
