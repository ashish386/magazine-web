<?php

namespace App\Controllers;
use App\Libraries\ImageProcess;
use App\Models\ProductModel;  
class ProductController extends BaseController {

    public function __construct()
    {
        header("Access-Control-Allow-Origin: * "); 
        header("Access-Control-Allow-Headers: * ");
        header("Access-Control-Allow-Methods: GET, POST");
    }
    public function index() {
        echo 'test';
    }

    public function getAllProduct() {
        $db = \Config\Database::connect();
        $blogs = $db->table('products');
        $blogs->select('id,title,short_description,description,price,special_price,category');
        $recnew = $blogs->where('status',1)->orderBy('id DESC')->get()->getResult();
        $response = array(
            'status' => 'success',
            'reason' => 'Products Fetched',
            'data' => $recnew,
        );
        return $this->response
                        ->setStatusCode(200)
                        ->setJson($response);
    }
	

    public function saveProduct() {
       
       //$data = $this->request->getJSON();
       
        //print_r($data->slider); die;   
        $arr = [
            'title' => $this->request->getPost('title'),
            'short_description' => $this->request->getPost('shortDescription'),
            'description' => $this->request->getPost('description'),
            'category' => $this->request->getPost('category'),
            'price' => $this->request->getPost('price'),
            'special_price' => $this->request->getPost('special_price'),
            
            ];
        $imgProcess = new ImageProcess(); // Create an instance  
		$arr['file'] = $imgProcess->uploadFile($this->request->getFile('file'),'files');
		
        $db = \Config\Database::connect();
        $builder = $db->table('products');
         
                $builder->insert($arr);
                $id =$db->insertID();
        if ($id) {
            
			
		$files = $this->request->getFiles();

        $imageNames = []; // this will be the array of saved images

        if ($files && isset($files['slider'])) {
			 $i=1;
            foreach ($files['slider'] as $img) { 

                /*if ($img->isValid() && !$img->hasMoved()) {

                    $newName = $img->getRandomName();
                    $img->move(WRITEPATH . 'uploads', $newName);

                    $imageNames[] = $newName;
                }*/
				
				
				$arr2[$i]['product_id'] = $id;
                $arr2[$i]['file'] = $imgProcess->uploadFile($img,'products'); 
                $arr2[$i]['default_image'] = $i==1?1:0;
                $i++;
            }
        }
			
			
			
			
			
			
            
           /*  $i=1;
                  
            foreach( json_decode($this->request->getPost('slider')) as $row){ 
               
                $arr2[$i]['product_id'] = $id;
                $arr2[$i]['file'] = $imgProcess->saveBase64ImageToFile($row,'products');
                $arr2[$i]['default_image'] = $i==1?1:0;
                $i++;
               
            } */
           $builder = $db->table('product_images');    
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

  
       
        $arr = [
            'title' => $this->request->getPost('title'),
            'short_description' => $this->request->getPost('shortDescription'),
            'description' => $this->request->getPost('description'),
            'category' => $this->request->getPost('category'),
            'price' => $this->request->getPost('price'),
            'special_price' => $this->request->getPost('special_price'),
            
            ];
		$id=$this->request->getPost('id');
        $imgProcess = new ImageProcess(); // Create an instance  
		$image = $imgProcess->uploadFile($this->request->getFile('file'),'files');
		$image!==''?$arr['file']=$image:'';
        $db = \Config\Database::connect();
        $builder = $db->table('products');
        $builder->where('id', $id);
        $builder->update($arr);
        
		
		$files = $this->request->getFiles();

        $imageNames = []; // this will be the array of saved images

        if ($files && isset($files['slider'])) {
			 $i=1;
            foreach ($files['slider'] as $img) { 

                				
				$arr2[$i]['product_id'] = $id;
                $arr2[$i]['file'] = $imgProcess->uploadFile($img,'products'); 
                $arr2[$i]['default_image'] = $i==1?1:0;
                $i++;
            }
			$builder = $db->table('product_images');    
           $builder->insertBatch($arr2); 
        }
		
        if ($this->request->getPost('deleted_images')) {
			 $i=1;
            foreach ($this->request->getPost('deleted_images') as $id) { 

                				
				$builder = $db->table('product_images');    
				$builder->where('id', $id);
				$builder->delete();
            }
			
        }
		
           
		   
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
	public function getProductById(){
		$product=new ProductModel();
		$rec=$product->getProductById($this->request->getGet('id'));
        $response = array(
            'status' => 'success',
            'reason' => 'Products Fetched',
            'data' => $rec,
        );
        return $this->response
                        ->setStatusCode(200)
                        ->setJson($response);
	}
}
