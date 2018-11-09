<?php

namespace App\Services\ParseService;


class ParseService {

    /**
     * @var \DOMDocument
     */
    private $doc;

    public function __construct() {
        $this->doc = new \DOMDocument();
    }

    /**
     *
     * Get page from source and turn off errors
     *
     * @param string $url
     */
    public function init(string $url) : void {
        libxml_use_internal_errors(true);
        $this->doc->loadHTMLFile($url);
    }

    /**
     *
     * Getter for product Title
     *
     * @return string
     */
    public function getProductTitle() : string {
        $text = str_replace('/n', '', $this->doc->getElementById('productTitle')->textContent);
        return trim($text);
    }

    /**
     *
     * Getter for ASIN
     *
     * @return string
     */
    public function getASIN() : string {
        $asin = '';
        $td = $this->doc->getElementsByTagName('td');
        foreach ($td as $key => $item) {
            if (strcasecmp($item->textContent, 'asin') == 0) $asin = $td[$key + 1]->textContent;
        }
        return trim($asin);
    }

    /**
     *
     * Getter for price product
     *
     * @return string
     */
    public function getPrice() : string {
        $usersPriceBlock = $this->doc->getElementById('usedBuySection')->getElementsByTagName('span');
        return (isset($usersPriceBlock[1]) ? trim($usersPriceBlock[1]->textContent) : '') ;
    }

    /**
     *
     * Getter for product description
     *
     * @return string
     */
    public function getDescription() : string {
        $description = $this->doc->getElementById('productDescription')->getElementsByTagName('p');
        return (isset($description[0]) ? trim($description[0]->textContent) : '') ;
    }

    /**
     *
     * Getter for product description
     *
     * @return string
     */
    public function getSpecifications() : string {
        $specificationBlock = $this->doc->getElementById('cpsia-product-safety-warning_feature_div')->getElementsByTagName('span');
        return (isset($specificationBlock[0]) ? trim($specificationBlock[0]->textContent) : '');
    }

    /**
     *
     * Getter for image URLs
     *
     * @return array
     */
    public function getImg() : array {
        $imgBlock = $this->doc->getElementById('altImages')->getElementsByTagName('img');
        $arr = [];
        foreach ($imgBlock as $item) {
            $arr[] = $item->getAttribute('src');
        }
        return $arr;
    }

}
