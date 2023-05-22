<?php

namespace App\Controller;

use DateTime;
use App\Entity\Raise;
use DateTimeImmutable;
use App\Entity\Auction;
use App\Enum\AuctionStatus;
use App\Enum\Languages;
use Symfony\UX\Turbo\TurboBundle;
use App\Repository\AuctionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\LocaleSwitcher;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    
    public function __construct
    (
        private AuctionRepository $auctionRepository,
    )
    {

    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {

        return $this->render('home/index.html.twig', [
            'auctions' => $this->auctionRepository->findBy(['status'=>AuctionStatus::Visible]),
        ]);
    }
    #[Route('/raise/{id?}', name: 'app_raise')]
    public function raise(ValidatorInterface $validator,?Auction $auction,Request $request,$id,EntityManagerInterface $manager): Response
    {
        
        if(!$auction) return $this->redirectToRoute('app_home');
        $price = $request->get('price');
        $raise = new Raise();
        $raise->setAuction($auction);
        $raise->setPrice((int)$price*100);
        $errors = $validator->validate($raise);
        
        

        if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            // dd(TurboBundle::class);
            if(count($errors)===0){
                
                $raise->setCreatedAt(new DateTimeImmutable());
                $manager->persist($raise);
                $auction->setPrice((int)$price*100);
                $manager->persist($raise);
                $manager->flush();
                return $this->render('home/success.stream.html.twig', [
                    'auctionId' => $id,
                    'auction'=>$auction,
                    'alert'=>true,

                    ]) ;
            }else{
                return $this->render('home/error.stream.html.twig', [
                    'errors' =>$errors,
                    'auctionId' => $id,
                    ]) ;
            }
        }   
       
    }

    #[Route('/{lang}', name: 'app_fr')]
    public function fr(Request $request ,?Languages $lang): Response
    {
        if(!$lang) return $this->redirectToRoute('app_home');
        $session = $request->getSession();
        $session->set('_local',$lang->value);
        $previousURL = $request->headers->get('referer');
        return $this->redirect($previousURL);
        // return $this->redirect($previousURL);
    
    }
    #[Route('/{lang}', name: 'app_en')]
    public function en(Request $request ,Languages $lang): Response
    {
        if(!$lang) return $this->redirectToRoute('app_home');
        $session = $request->getSession();
        $session->set('_local',$lang->value);
        $previousURL = $request->headers->get('referer');
        
        return $this->redirect($previousURL);
    
    }
   
}