<?php

namespace Tests;

use App\Entity\Person;
use App\Entity\Product;
use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    public function testConstruct(): void
    {
        $person = new Person('Ronald MCdonald', 'USD');
        $this->assertEquals('Ronald MCdonald', $person->getName());
        $this->assertEquals('USD', $person->getWallet()->getCurrency());
        $this->assertEquals(0, $person->getWallet()->getBalance());
    }

    public function testConstructMauvaisCurrency(): void
    {
        $this->expectException(\Exception::class);
        $person = new Person('Ronald MCdonald', 'mcnugget');
    }

    public function testSetWallet(): void
    {
        $person = new Person('Ronald MCdonald', 'USD');
        $wallet = new Wallet('EUR');
        $person->setWallet($wallet);
        $this->assertEquals('EUR', $person->getWallet()->getCurrency());
    }

    public function testHasFunds(): void
    {
        $person = new Person('Ronald MCdonald', 'USD');
        $this->assertFalse($person->hasFund());
        $person->getWallet()->setBalance(100);
        $this->assertTrue($person->hasFund());
    }

    public function testTransferFund(): void
    {
        $person1 = new Person('Ronald MCdonald', 'USD');
        $person2 = new Person('Burger King', 'USD');
        $person1->getWallet()->setBalance(100);
        $person1->transferFund(50, $person2);
        $this->assertEquals(50, $person1->getWallet()->getBalance());
        $this->assertEquals(50, $person2->getWallet()->getBalance());
    }

    public function testTransferFundDifferentCurrency(): void
    {
        $person1 = new Person('Ronald MCdonald', 'USD');
        $person2 = new Person('Burger King', 'EUR');
        $this->expectException(\Exception::class);
        $person1->getWallet()->setBalance(100);
        $person1->transferFund(50, $person2);
    }

    public function testDivideFunction(): void
    {
        $person1 = new Person('Ronald MCdonald', 'USD');
        $person2 = new Person('Burger King', 'USD');
        $person3 = new Person('Colonel Sanders', 'USD');
        $person1->getWallet()->setBalance(100);
        $person1->divideWallet([$person2, $person3]);
        $this->assertEquals(50, $person2->getWallet()->getBalance());
        $this->assertEquals(50, $person3->getWallet()->getBalance());
    }

    public function testDivideFunction3(): void
    {
        $person1 = new Person('Ronald MCdonald', 'USD');
        $person2 = new Person('Burger King', 'USD');
        $person3 = new Person('Colonel Sanders', 'USD');
        $person4 = new Person('Wendy', 'USD');
        $person1->getWallet()->setBalance(100);
        $person1->divideWallet([$person2, $person3, $person4]);

        $this->assertEquals(33.34, $person2->getWallet()->getBalance());
        $this->assertEquals(33.33, $person3->getWallet()->getBalance());
        $this->assertEquals(33.33, $person4->getWallet()->getBalance());
    }

    public function testBuyProduct(): void
    {

        $person = new Person('Ronald MCdonald', 'USD');
        $person->getWallet()->setBalance(100);
        $product = new Product('Product', ['USD' => 100, 'EUR' => 2], 'food');
        $person->buyProduct($product);
        $this->assertEquals(0, $person->getWallet()->getBalance());

    }

    public function testBuyProductBadCurrency(): void
    {
        $person = new Person('Ronald MCdonald', 'USD');
        $person->getWallet()->setBalance(100);
        $product = new Product('Product', ['EUR' => 2], 'food');
        $this->expectException(\Exception::class);
        $person->buyProduct($product);
    }

}
