<?php

namespace BoncoinBundle\Controller;

use BoncoinBundle\BoncoinBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class AnnonceController
 * @package BoncoinBundle\Controller
 *
 * @Route("/")
 */
class AnnonceController extends Controller
{

    /**
     * Show load data page
     *
     * @Route("/loadData/{limit}", requirements={"limit" = "\d+"}, defaults={"limit" = 100}, name="boncoin_loaddata")
     */
    public function loadAction($limit)
    {
        $annonces = $this->container->get("boncoin.parsing")->getBonCoinResults("/animaux/offres/rhone_alpes/", $limit);

        $this->deleteAnnoncesAction();

        $this->createAnnoncesAction($annonces);

        return $this->render('BoncoinBundle:Main:load.html.twig', array(
            'annonces' => $annonces,
        ));
    }

    /**
     * Persist an array of annonces
     *
     * @param array $annonces
     */
    public function createAnnoncesAction(array $annonces)
    {
        $em = $this->getDoctrine()->getManager();

        foreach ($annonces as $annonce) {
            $em->persist($annonce);
        }

        $em->flush();
        $em->clear();
    }

    /**
     * Delete all Annonces from database
     */
    public function deleteAnnoncesAction()
    {
        $this->getDoctrine()->getManager()->getRepository("BoncoinBundle:Annonce")->deleteAll();
    }
}
