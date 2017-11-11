<?php

namespace BoncoinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class MainController
 * @package BoncoinBundle\Controller
 *
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

}
