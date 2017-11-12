<?php

namespace BoncoinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use BoncoinBundle\Form\Type\MySearchType;

/**
 * Class MainController
 * @package BoncoinBundle\Controller
 *
 * @Route("/")
 * @Method({"GET", "POST"})
 */
class MainController extends Controller
{
    /**
     * Show homepage
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="boncoin_index")
     */
    public function indexAction(Request $request)
    {
        $annonceRepository = $this->getDoctrine()->getRepository('BoncoinBundle:Annonce');
        $annonces = [];

        $searchForm = $this->createForm(MySearchType::class);

        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted()) {
            if ($searchForm->isValid()) {
                $annonces = $annonceRepository->findBySearch(
                    $searchForm->getData()['title'],
                    $searchForm->getData()['pmin'],
                    $searchForm->getData()['pmax']
                );
            }
        } else {
            $annonces = $annonceRepository->findBySearch();
        }

        return $this->render('BoncoinBundle:Main:index.html.twig', array(
            'annonces' => $annonces,
            'searchForm' => $searchForm->createView()
        ));
    }

}
