<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Auction;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    #[Route('/payer/stripe', name: 'app_stripe_chechout')]
    public function index(?Auction $auction,Request $request): Response
    {
       
        //if(!$auction) return $this->redirectToRoute('app_home');

        Stripe::setApiKey('sk_test_51MPRHZL5OhzN7KHGDGf8Jo7HCWdDYaLWzAeG5D5VRkspWny2Emq4cyMctD0G56UbmA7vIKArauUMcKexsgJwtXmd00VNr6eudn');

        $YOUR_DOMAIN = 'http://localhost:8001';

        $checkout_session = Session::create([
            'line_items' => [[
                'price_data' => [
                  'currency' => 'eur',
                  'product_data' => [
                    'name' =>'tttt' //$auction->getTitle(),
                  ],
                  'unit_amount' =>1000 //$auction->getPrice(),
                ],
                'quantity' => 1,
              ],
              
            ],
        'mode' => 'payment',
        'success_url' => $YOUR_DOMAIN . '/success/{CHECKOUT_SESSION_ID}',
        'cancel_url' => $YOUR_DOMAIN . '/cancel/{CHECKOUT_SESSION_ID}',
        ]);
        
       $session=$request->getSession();
       $session->set('stripeUrl',$checkout_session->id);
    //    dd({CHECKOUT_SESSION_ID});

        $url = $checkout_session->url;
         return $this->redirect($url);
        return $this->render('home/index.html.twig', [
            'url'=>$url,
        ]);
    }

    #[Route('/success/{stripeId}', name: 'app_stripe_success')]
    public function success($stripeId): Response
    {
        // dd($stripeId);
        Stripe::setApiKey('sk_test_51MPRHZL5OhzN7KHGDGf8Jo7HCWdDYaLWzAeG5D5VRkspWny2Emq4cyMctD0G56UbmA7vIKArauUMcKexsgJwtXmd00VNr6eudn');

        $stripeSession = Session::retrieve($stripeId);
        //dd($stripeSession->payment_status);
        // if($stripeSession->id !== $stripeId || $stripeSession->payment_status !== 'paid') return $this->redirectToRoute('app_home');
        return $this->render('stripe/sucess.html.twig', [
           
        ]);
    } 
    #[Route('/cancel', name: 'cancel')]
    public function cancel(): Response
    {
        echo('cancel');
        return $this->render('stripe/cancel.html.twig', [
           
        ]);
    } 
}