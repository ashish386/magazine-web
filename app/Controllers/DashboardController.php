<?php

namespace App\Controllers;
use App\Models\ProductModel;
use App\Models\UserModel;
use App\Models\CategoryModel;
class DashboardController extends BaseController
{
    
    public function __construct()
    {
        helper('form');
		header("Access-Control-Allow-Origin: * "); 
        header("Access-Control-Allow-Headers: * ");
        header("Access-Control-Allow-Methods: GET, POST");
        
    }
    public function index()
    {
       $response = array(
            'status' => 'success',
            'reason' => 'API Working',
            'data' => '',
        );
        return $this->response
                        ->setStatusCode(200)
                        ->setJson($response);
    }
    public function getDashboardWidgetData()
    {
		$product = new ProductModel();
		$user = new UserModel();
		$category = new CategoryModel();
        $data['product'] = $product->getProductCount(); 
        $data['users'] = $user->getUserCount(); 
        $data['category'] = $category->getCategoryCount(); 
        $response = array(
            'status' => 'success',
            'reason' => 'Products Fetched',
            'data' => $data,
        );
        return $this->response
                        ->setStatusCode(200)
                        ->setJson($response);
       
    }
    
    
    
   
    
}
