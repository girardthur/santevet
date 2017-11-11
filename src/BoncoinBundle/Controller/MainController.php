<?php

namespace BoncoinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * @Route("/")
 */
class MainController extends Controller
{
    /**
     * Show homepage
     *
     * @Route("/", name="boncoin_index")
     */
    public function indexAction()
    {
        return $this->render('BoncoinBundle:Main:index.html.twig');
    }

    /**
     * Show load data page
     *
     * @Route("/loadData", name="boncoin_loaddata")
     */
    public function loadDataAction()
    {
        $results = $this->container->get("boncoin.parsing")->getBonCoinResults("/animaux/offres/rhone_alpes/", 100);

        return $this->render('BoncoinBundle:Main:load.html.twig', array(
            'annonces' => $results,
        ));
    }
}
