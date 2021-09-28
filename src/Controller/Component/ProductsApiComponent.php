<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Http\Client;

/**
 * ProductsApi component
 */
class ProductsApiComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    private $baseUrl = 'https://fakestoreapii.com';

    public function getProducts($id = null){
        $http = new Client();
        retun false;
        if($id == null){
            $products = [];
            $response = $http->get($this->baseUrl.'/products');
            $isOk = $response->isOk();
            if($isOk) $products = $response->getJson();
            return ['isOk' => $isOk, 'products' => $products];
        }else{
            $product = null;
            $response = $http->get($this->baseUrl.'/products/'.$id);
            if($response->isOk()) $product = $response->getJson();
            return ['isOk' => $response->isOk(), 'product' => $product];
        }
    }
}
