<?php

namespace App\Controllers;
use App\Libraries\ImageProcess;
use App\Models\OrderModel;

class OrderController extends BaseController {

    public function __construct()
    {
        header("Access-Control-Allow-Origin: * "); 
        header("Access-Control-Allow-Headers: * ");
        header("Access-Control-Allow-Methods: GET, POST");
    }
    public function index() {
        echo 'test';
    }

    public function getAllOrder() {
        
        $order = new OrderModel();
		$orders = $order->getAllOrder();
        $response = array(
            'status' => 'success',
            'reason' => 'Customers Fetched',
            'data' => $orders,
        );
        return $this->response
                        ->setStatusCode(200)
                        ->setJson($response);
    }

    public function saveProduct() {
       
       $data = $this->request->getJSON();
       
        //print_r($data->slider); die;   
        $arr = [
            'title' => $data->title,
            'short_description' => $data->shortDescription,
            'description' => $data->description,
            'category' => $data->category,
            'price' => $data->price,
            'special_price' => $data->special_price,
            
            ];
            
        $db = \Config\Database::connect();
        $builder = $db->table('products');
         
                $builder->insert($arr);
                $id =$db->insertID();
        if ($id) {
            
            $imgProcess = new ImageProcess(); // Create an instance
            $i=1;
            $builder = $db->table('product_images');          
            foreach( $data->slider as $row){
               
                $arr2[$i]['product_id'] = $id;
                $arr2[$i]['file'] = $imgProcess->saveBase64ImageToFile($row,'products');
                $arr2[$i]['default_image'] = $i==1?1:0;
                $i++;
               
            }
           
           $builder->insertBatch($arr2);
            $response = array(
                'status' => 'success',
                'reason' => 'Product Inserted',
                'data' => $id,
            );
            return $this->response
                            ->setStatusCode(201)
                            ->setJson($response);
        } else {
            $response = array(
                'status' => 'success',
                'reason' => 'Product could not be inserted',
                'data' => '',
            );
            return $this->response
                            ->setStatusCode(400)
                            ->setJson($response);
        }
    }
     public function updateProduct() {

  
       $data = $this->request->getJSON();
        $arr = [
            'title' => $data->title,
            'short_description' => $data->shortDescription,
            'description' => $data->description,
            'category' => $data->category,
            'price' => $data->price,
            'special_price' => $data->special_price,
            
            ];
        $db = \Config\Database::connect();
        $builder = $db->table('products');
        $builder->where('id', $data->id);
        $builder->update($arr);
             
            $response = array(
                'status' => 'success',
                'reason' => 'Product Updated',
                'data' => '',
            );
            return $this->response
                            ->setStatusCode(200)
                            ->setJson($response);
        
    }
    
     public function deleteProduct() {
     
        $arr = [
            'status' => 0
        ];
        
        $db = \Config\Database::connect();
        $builder = $db->table('products');
        $builder->where('id', $this->request->getGet("id"));
        $res=$builder->update($arr);
       
       if($res){
           $response = array(
                'status' => 'success',
                'reason' => 'Product deleted',
                'data' => '',
            );
            return $this->response
                            ->setStatusCode(200)
                            ->setJson($response);
       }else{
           $response = array(
                'status' => 'success',
                'reason' => 'Product could not be deleted',
                'data' => '',
            );
            return $this->response
                            ->setStatusCode(400)
                            ->setJson($response); 
       }
            
        
    }
}
