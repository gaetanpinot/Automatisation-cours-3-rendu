<?php

namespace Tests;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testConstruct(): void
    {
        $product = new Product('Product', ['USD' => 100, 'EUR' => 2], 'food');
        $this->assertEquals('Product', $product->getName());
        $this->assertEquals(['USD' => 100, 'EUR' => 2], $product->getPrices());
        $this->assertEquals('food', $product->getType());
    }

    public function testWrongCurrencyAndWrongPrice(): void
    {
        $product = new Product('Product', ['USD' => 100, 'EUR' => -10, 'mcnugget' => 188], 'food');
        $this->assertEquals(['USD' => 100], $product->getPrices());
    }

    public function testWrongType(): void
    {
        $this->expectException(\Exception::class);
        $product = new Product('Product', ['USD' => 100, 'EUR' => 2], 'mcnugget');
    }

    public function testTva(): void
    {
        $product = new Product('Product', ['USD' => 100, 'EUR' => 2], 'food');
        $this->assertEquals(0.1, $product->getTVA());

        $product = new Product('Product', ['USD' => 100, 'EUR' => 2], 'tech');
        $this->assertEquals(0.2, $product->getTVA());
    }

    public function testCurrencies(): void
    {
        $product = new Product('Product', ['USD' => 100, 'EUR' => 2], 'food');
        $this->assertEquals(['USD', 'EUR'], $product->listCurrencies());
    }

    public function testPriceInCurrency(): void
    {
        $product = new Product('Product', ['USD' => 100, 'EUR' => 2], 'food');
        $this->assertEquals(100, $product->getPrice('USD'));
        $this->assertEquals(2, $product->getPrice('EUR'));
    }

    public function testPriceInUnknownCurrency(): void
    {
        $product = new Product('Product', ['USD' => 100, 'EUR' => 2], 'food');
        $this->expectException(\Exception::class);
        $product->getPrice('mcnugget');
    }

    public function testPriceUnavailableCurrency(): void
    {
        $product = new Product('Product', ['USD' => 100], 'food');
        $this->expectException(\Exception::class);
        $product->getPrice('EUR');
    }

}
