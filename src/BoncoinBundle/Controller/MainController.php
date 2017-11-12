<?php

namespace BoncoinBundle\Controller;

use BoncoinBundle\Form\Type\MySearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/", name="boncoin_index")
     */
    public function indexAction(Request $request)
    {
        $annonceRepository = $this->getDoctrine()->getRepository('BoncoinBundle:Annonce');

        $searchForm = $this->createForm(MySearchType::class);

        $searchForm->handleRequest($request);

        if ($searchForm->isValid()) {
            $annonces = $annonceRepository->findBySearch(
                $searchForm->getData()['title'],
                $searchForm->getData()['pmin'],
                $searchForm->getData()['pmax']
            );
        } else {
            $annonces = $annonceRepository->findBySearch();
        }

        return $this->render('BoncoinBundle:Main:index.html.twig', array(
            'annonces' => $annonces,
            'searchForm' => $searchForm->createView()
        ));
    }

}
