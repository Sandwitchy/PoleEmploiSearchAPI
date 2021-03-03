<?php

namespace App\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Offer;

class OfferFetcher
{
    public function __construct(HttpClientInterface $httpClient){
        $this->httpClient = $httpClient;
    }

    /**
     * Fetch token
     */
    public function getToken(){
        $response = $this->httpClient->request(
            'POST',
            'https://entreprise.pole-emploi.fr/connexion/oauth2/access_token',
            [
                'body' => array(
                    "grant_type"    => "client_credentials",
                    "client_id"     => $_ENV["CLIENT_ID"],
                    "client_secret" => $_ENV["CLIENT_SECRET"],
                    "scope"         => "application_".$_ENV["CLIENT_ID"]." ".$_ENV["SCOPE_SUFFIXE"],
                ),
                "query" => array(
                    "realm" => "partenaire"
                )
            ]
        );
        return $response->toArray();
    }

    public function fetch(){
        /**
        * Fetch raw data 
        */
        $response = $this->httpClient->request(
            'GET',
            'https://api.emploi-store.fr/partenaire/offresdemploi/v2/offres/search',
            [
                "auth_bearer" => $this->getToken()["access_token"],
                "query" => [
                    "range" => "0-9",
                    "sort"  => 0,
                ]
            ]
        );

        $data = $response->toArray()["resultats"];

        $offers = array();
        foreach ($data as $offer){
            $offer = new Offer();
        }
    }
}
