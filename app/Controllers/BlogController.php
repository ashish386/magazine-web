<?php

namespace App\Controllers;
use App\Models\BlogModel;

class BlogController extends BaseController {

    public function __construct()
    {
        header("Access-Control-Allow-Origin: * "); 
        header("Access-Control-Allow-Headers: * ");
        header("Access-Control-Allow-Methods: GET, POST");
    }
    public function index() {
        echo 'test';
    }

    public function getAllBlog() {
        $db = \Config\Database::connect();
        $blogs = $db->table('blogs');
        $blogs->select('id, title,slug,description,image,category');
        $recnew = $blogs->where('status',1)->get()->getResult();
        $response = array(
            'status' => 'success',
            'reason' => 'blog Fetched',
            'data' => $recnew,
        );
        return $this->response
                        ->setStatusCode(200)
                        ->setJson($response);
    }
    private function uploadFile($file,$path){
        
            if ($file->isValid() && ! $file->hasMoved())
            {
                $newName = $file->getRandomName(); 
                $file->move(ROOTPATH . 'public/uploads/'.$path, $newName); 
                return $newName;
            }
    }
    public function saveBlog() {
       
        $arr = [
            'title' => $this->request->getPost("title"),
            'slug' => url_title($this->request->getPost("title")),
            'description' => $this->request->getPost("description"),
            'category' => $this->request->getPost("category"),
            
            ];
           $arr['image']=$this->uploadFile($this->request->getFile('image'),'blogs');
   
           
        $db = \Config\Database::connect();
        $builder = $db->table('blogs');
        $id = $builder->insert($arr);
        if ($id) {
            $response = array(
                'status' => 'success',
                'reason' => 'Blog Inserted',
                'data' => $id,
            );
            return $this->response
                            ->setStatusCode(201)
                            ->setJson($response);
        } else {
            $response = array(
                'status' => 'success',
                'reason' => 'Blog could not be inserted',
                'data' => '',
            );
            return $this->response
                            ->setStatusCode(400)
                            ->setJson($response);
        }
    }
     public function updateBlog() {

  
        $arr = [
            'title' => $this->request->getPost("title"),
            'description' => $this->request->getPost("description"),
            'category' => $this->request->getPost("category"),
            ];
        $db = \Config\Database::connect();
        $builder = $db->table('blogs');
        $builder->where('id', $this->request->getPost("id"));
        $builder->update($arr);
             
            $response = array(
                'status' => 'success',
                'reason' => 'Blog Updated',
                'data' => '',
            );
            return $this->response
                            ->setStatusCode(200)
                            ->setJson($response);
        
    }
    
     public function deleteBlog() {
     
        $arr = [
            'status' => 0
        ];
        
        $db = \Config\Database::connect();
        $builder = $db->table('blogs');
        $builder->where('id', $this->request->getGet("id"));
        $res=$builder->update($arr);
       
       if($res){
           $response = array(
                'status' => 'success',
                'reason' => 'Blog deleted',
                'data' => '',
            );
            return $this->response
                            ->setStatusCode(200)
                            ->setJson($response);
       }else{
           $response = array(
                'status' => 'success',
                'reason' => 'Blog could not be deleted',
                'data' => '',
            );
            return $this->response
                            ->setStatusCode(400)
                            ->setJson($response); 
       }
            
        
    }
}
