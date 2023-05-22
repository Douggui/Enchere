<?php

namespace App\Tests;

use App\Enum\AuctionStatus;
use App\Repository\AuctionRepository;
use Symfony\Component\Panther\PantherTestCase;
ini_set('memory_limit', '512M');

class AuctionsTest extends PantherTestCase
{
    public function testAuction(): void
    {
        $client = static::createPantherClient();
        $container = static::getContainer();

        $auctionRepository = $container->get(AuctionRepository::class);
        $getAuctions = $auctionRepository->findBy(['status'=>AuctionStatus::Visible]);
        
        //Goto login page
        $crawler = $client->request('GET', '/');
       
        $crawler = $client->waitFor('#auctions');
        $auctions= $crawler->filter('#auctions .card');
        $this->assertCount(count($getAuctions),$auctions);
        $this->assertSelectorTextContains('h1', 'Auctions');
        $this->assertPageTitleContains('Accueil');

       $id=$getAuctions[0]->getId();

        // $priceOfFirstAuction = $getAuctions[0]->getPrice();
        // $priceOfFirstAuctionInDom = $crawler->filter('#price-'.$getAuctions[0]->getId())->text();
        // $this->assertEquals('€'.($priceOfFirstAuction/100).'00',$priceOfFirstAuctionInDom);
        
        $crawler = $client->waitFor('#price-'.$id);
        
        $this->assertSelectorTextContains('#price-'.$id,'€111.00');

        // $crawler = $client->waitFor('#auction-'.$id);

        // $form = $crawler->filter("#auction-$id form #submit-$id")->text();
        //Wait for  the button to become disabled
        
        // $crawler = $client->waitFor('#info-auction'.$id);
        $client->submitForm('Enchérir', ['price' => 55]);
        $client->waitForElementToContain('#info-auction'.$id, 'vous devez rajouter minimum 5€ au prix initial'); // wait for text to be inserted in the element content
        $this->assertSelectorTextContains('#info-auction'.$id,'vous devez rajouter minimum 5€ au prix initial');
        
        //$client->takeScreenshot(__DIR__ . '/screens/accueil1.png');

    }
}