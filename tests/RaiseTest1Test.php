<?php

namespace App\Tests;

use DateTime;
use App\Entity\Raise;
use App\Entity\Auction;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RaiseTest1Test extends KernelTestCase
{
    public function testRaise(): void
    {
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
        $kernel = self::bootKernel();
        $constainer = static::getContainer();
         $validator = $constainer->get(ValidatorInterface::class);
        $date = new DateTime();
        $raise=new Raise();
        $raise->setPrice(100);
        $errors = $validator->validate($raise);
        $auction = new Auction();
        $auction->setCreatedAt($date)
                ->setDateOpen($date->modify("+2 day"))
                ->setDateClose($date->modify("+5 day"))
                ->setTitle('title')
                ->setDescription('description')
                ->setImage('image')
                ->setSlug('title')
                ->setPrice(100)
                ;
        $raise->setAuction($auction);
        $this->assertEmpty($errors);

    }
}