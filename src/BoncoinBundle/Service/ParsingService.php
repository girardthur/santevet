<?php

namespace BoncoinBundle\Service;

use BoncoinBundle\Entity\Annonce;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Service in charge to parse content from DOM
 *
 * Class ParsingService
 * @package BoncoinBundle\Service
 */
class ParsingService
{
    /** @var CurlService */
    private $curlService;

    /**
     * ParsingService constructor.
     */
    public function __construct(CurlService $curlService)
    {
        $this->setCurlService($curlService);
    }

    /**
     * Return a list of ad from an url parameters part
     *
     * @param string $urlParamsPart
     * @param int $limit
     * @return array
     */
    public function getBonCoinResults(string $urlParamsPart, int $limit = 100)
    {
        $pageNumber = 1;
        $annonces = [];

        while (count($annonces) < $limit) {
            $annonces = array_merge($annonces, $this->getBonCoinPageResults($urlParamsPart, $pageNumber));
            $pageNumber++;
        }
        return array_slice($annonces, 0, $limit);
    }

    /**
     * Return a list of ad from an url parameters part (for one page)
     *
     * @param string $urlParamsPart
     * @param int $pagenumber
     * @return array
     */
    public function getBonCoinPageResults(string $urlParamsPart, int $pagenumber = 1)
    {
        $url = "https://www.leboncoin.fr" . $urlParamsPart . "?o=" . $pagenumber;

        $domPage = $this->getCurlService()->getUrlDOM($url);

        $crawler = new Crawler($domPage);

        $annoncesInfos = $crawler
            ->filterXPath('//section[@class="tabsContent block-white dontSwitch"]')
            ->filter('.item_infos')
            ->each(function (Crawler $nodeCrawler) {

                // Get title
                $title = trim($nodeCrawler->filter('.item_title')->text());

                //Get location
                $location = trim($nodeCrawler->filterXPath('//p[@itemprop="availableAtOrFrom"]')->text());
                $location = preg_replace('/\s+/', '', $location);

                //Get price
                if ($nodeCrawler->filter('.item_price')->count()) {
                    $price = $nodeCrawler->filter('.item_price')->attr("content");
                } else {
                    $price = null;
                }

                return new Annonce($title, $location, $price);
            });

        if (count($annoncesInfos) == 0) {
            throw new Exception("No content in " . $url);
        }

        return $annoncesInfos;
    }

    /**
     * @return mixed
     */
    public function getCurlService()
    {
        return $this->curlService;
    }

    /**
     * @param mixed $curlService
     */
    public function setCurlService($curlService)
    {
        $this->curlService = $curlService;
    }
}
