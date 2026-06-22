<?php

namespace App\Controllers;

class CategoryController extends BaseController {

    public function __construct()
    {
        header("Access-Control-Allow-Origin: * "); 
        header("Access-Control-Allow-Headers: * ");
        header("Access-Control-Allow-Methods: GET, POST");
    }
    public function index() {
       $response = array(
            'status' => 'success',
            'reason' => 'Category Page',
            'data' => '',
        );
        return $this->response
                        ->setStatusCode(200)
                        ->setJson($response);
    }


    public function getAllCategory() {
        
       
        $db = \Config\Database::connect();
        $categories = $db->table('category');
        $categories->select('id, name,slug,description,show_in_nav');
        $recnew = $categories->where('status',1)->get()->getResult();
        $response = array(
            'status' => 'success',
            'reason' => 'Category Fetched',
            'data' => $recnew,
        );
        return $this->response
                        ->setStatusCode(200)
                        ->setJson($response);
    }
    
    public function saveCategory() {
       
       $data = $this->request->getJSON();
       
        //print_r($data->slider); die;   
        $arr = [
            'name' => $data->title,
            'description' => $data->description,
            'show_in_nav' => $data->show_in_nav,
            
            ];
            
        $db = \Config\Database::connect();
        $builder = $db->table('category');
         
                $builder->insert($arr);
                $id =$db->insertID();
        if ($id) {
            $response = array(
                'status' => 'success',
                'reason' => 'Category Inserted',
                'data' => $id,
            );
            return $this->response
                            ->setStatusCode(201)
                            ->setJson($response);
        } else {
            $response = array(
                'status' => 'success',
                'reason' => 'Category could not be inserted',
                'data' => '',
            );
            return $this->response
                            ->setStatusCode(400)
                            ->setJson($response);
        }
    }
     public function updatecategory() {

  
       $data = $this->request->getJSON();
       
        //print_r($data->slider); die;   
        $arr = [
            'name' => $data->title,
            'description' => $data->description,
            'show_in_nav' => $data->show_in_nav,
            
            ];
         
        $db = \Config\Database::connect();
        $builder = $db->table('category');
        $builder->where('id', $data->id);
        $builder->update($arr);
             
            $response = array(
                'status' => 'success',
                'reason' => 'Category Updated',
                'data' => '',
            );
            return $this->response
                            ->setStatusCode(200)
                            ->setJson($response);
        
    }
    
     public function deleteCategory() {
     
        $arr = [
            'status' => 0
        ];
        
        $db = \Config\Database::connect();
        $builder = $db->table('category');
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
