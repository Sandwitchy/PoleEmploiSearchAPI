<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Api\OfferFetcher;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(OfferFetcher $offerFetcher): Response
    {

        $offerFetcher->fetch();
        return $this->render('home.html.twig');
    }
}
