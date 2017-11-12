<?php

namespace BoncoinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use BoncoinBundle\Entity\Annonce;

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
     * @param $limit
     * @return \Symfony\Component\HttpFoundation\Response
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
     * Action in charge of increment view counter and redirect to url
     *
     * @param Annonce $annonce
     * @param SessionInterface $session
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/view/{annonce}", requirements={"annonce" = "\d+"}, name="boncoin_viewannonce")
     */
    public function viewAnnonceAction(Annonce $annonce, SessionInterface $session)
    {
        $alreadyVisited = $session->get($annonce->getUniqueId());

        // If first clic on url link, increment view counter
        if (is_null($alreadyVisited)) {
            $em = $this->getDoctrine()->getManager();
            $annonce->incrementView();
            $em->persist($annonce);
            $em->flush();
            $em->clear();
            $session->set($annonce->getUniqueId(), 1);
        }

        // Redirect to extern url
        return $this->redirect($annonce->getUrl());
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
