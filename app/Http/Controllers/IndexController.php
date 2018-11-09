<?php

namespace App\Http\Controllers;

use App\Services\ParseService\ParseService;

class IndexController extends Controller {

    private $_parseService;

    public function __construct(ParseService $_parseService) {
        $this->_parseService = $_parseService;
    }

    /**
     *
     * Init service for parsing and send response
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function index() {
        $this->_parseService->init('https://www.amazon.co.uk/Winning-Moves-29612-Trivial-Pursuit/dp/B075716WLM/');
        return response()->json([
            'title' => $this->_parseService->getProductTitle(),
            'asin' => $this->_parseService->getASIN(),
            'price' => $this->_parseService->getPrice(),
            'description' => $this->_parseService->getDescription(),
            'specification' => $this->_parseService->getSpecifications(),
            'img' => $this->_parseService->getImg(),
        ]);
    }
}
