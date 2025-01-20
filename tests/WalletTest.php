<?php

namespace Tests;

use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase
{
    public function testConstruct(): void
    {
        $wallet = new Wallet('USD');
        $this->assertEquals(0, $wallet->getBalance());
        $this->assertEquals('USD', $wallet->getCurrency());
    }

    public function testBadCurrency()
    {
        $this->expectException(\Exception::class);
        $wallet = new Wallet('Not a currency');
    }

    public function testSetBalance(): void
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(100);
        $this->assertEquals(100, $wallet->getBalance());
    }

    public function testBadBalance(): void
    {
        $wallet = new Wallet('USD');
        $this->expectException(\Exception::class);
        $wallet->setBalance(-100);
    }

    public function testRemoveFund(): void
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(100);
        $wallet->removeFund(50);
        $this->assertEquals(50, $wallet->getBalance());
    }

    public function testRemoveTooMuchFund(): void
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(100);
        $this->expectException(\Exception::class);
        $wallet->removeFund(150);
    }

    public function testRemoveNegativeFund(): void
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(100);
        $this->expectException(\Exception::class);
        $wallet->removeFund(-50);
    }

    public function testAddFund(): void
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(100);
        $wallet->addFund(50);
        $this->assertEquals(150, $wallet->getBalance());
    }

    public function testAddNegativeFund(): void
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(100);
        $this->expectException(\Exception::class);
        $wallet->addFund(-50);
    }
}
