<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController {

    protected $session;
    public function __construct()
    {
        header("Access-Control-Allow-Origin: * "); 
        header("Access-Control-Allow-Headers: * ");
        header("Access-Control-Allow-Methods: GET, POST");
        
    }
    public function index() {
        echo 'test';
    }

    public function generateTokenNo() {
        $str = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $token = str_shuffle($str);
        return $token;
    }

    function base64url_encode($str) {

        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }

    function generate_jwt($headers, $payload, $secret = 'secret') {
        $headers_encoded = $this->base64url_encode(json_encode($headers));
        $payload_encoded = $this->base64url_encode(json_encode($payload));
        $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded",
                $secret, true);
        $signature_encoded = $this->base64url_encode($signature);
        $jwt = "$headers_encoded.$payload_encoded.$signature_encoded";
        return $jwt;
    }

    public function login() {
        $data = $this->request->getJSON();
        $email = $data->email;
        $password = $data->password;
              
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('email', $email);
        $builder->where('password', md5($password));
        $rec = $builder->get()->getNumRows();
        
        if ($rec) {
            $headers = array('alg' => 'HS256', 'typ' => 'JWT');
            $payload = array(
                'email' => $data->email,
                'password' => md5($password),
                'logintime' => date("Y-m-d H:i:s"),
            );
            $jwt = $this->generate_jwt($headers, $payload, 'secret');
            $arr = array(
                'token_no' => $jwt
                    //'token_expiry' => date("Y-m-d H:i:s", strtotime("+3600 seconds"))
            );
            $db = \Config\Database::connect();
            $users = $db->table('users');
            $users->where('email', $email);
            $users->update($arr);
            
            $users->select('id, name, email, phone,token_no,role');
            $recnew = $users->getWhere(['email' => $email])->getRow();
            
            $response = array(
                'status' => 'success',
                'reason' => 'Login successful',
                'data' => $recnew,
            );
            return $this->response
                        ->setStatusCode(202)
                        ->setJson($response);
        } else {
            $response = array(
                'status' => 'error',
                'reason' => 'Incorrect Email and Password',
            );
            return $this->response
                        ->setStatusCode(401)
                        ->setJson($response);
        }
        
    }

    public function getAllUser() {
        
//        $authHeader = $this->request->getHeader('Authorization');
//        $token = explode(' ', $authHeader)[1];
//        $db = \Config\Database::connect();
//        $users = $db->table('users');
//        $users->selectCount('id');
//        $rec = $users->getWhere(['token_no' => $token]);
//
//        if (!$rec) {
//            $response = array(
//                'status' => 'success',
//                'reason' => 'Token invalid',
//                'data' => '',
//            );
//            return $this->response
//                            ->setStatusCode(401)
//                            ->setJson($response);
//        }
        $db = \Config\Database::connect();
        $users = $db->table('users');
        $users->select('id, name, email, phone,token_no');
        $recnew = $users->where('status',1)->get()->getResult();
        $response = array(
            'status' => 'success',
            'reason' => 'User Fetched',
            'data' => $recnew,
        );
        return $this->response
                        ->setStatusCode(200)
                        ->setJson($response);
    }

    public function saveUser() {

//        $authHeader = $this->request->getHeader('Authorization');
//        $token = explode(' ', $authHeader)[1];
//        $db = \Config\Database::connect();
//        $users = $db->table('users');
//        $users->selectCount('id');
//        $rec = $users->getWhere(['token_no' => $token]);
//
//        if (!$rec) {
//            $response = array(
//                'status' => 'success',
//                'reason' => 'Token invalid',
//                'data' => '',
//            );
//            return $this->response
//                            ->setStatusCode(401)
//                            ->setJson($response);
//        }
        $userModel = new UserModel();
        $data = $this->request->getJSON();
        $arr = [
            'name' => $data->name,
            'phone' => $data->phone,
            'email' => $data->email,
            'password' => md5($data->password),
            'status' => 1,
            'role' => 2,
            'image' => 'user.png',
        ];

//        $img = $this->request->getFile('image');
//        if ($img && $img->isValid() && !$img->hasMoved()) {
//            $newName = $img->getRandomName();
//            $img->move(FCPATH . 'uploads/users', $newName);
//        } else {
//            $newName = null;
//        }
//        $arr['image'] = $newName;
        $id = $userModel->insert($arr);
        if ($id) {
            $response = array(
                'status' => 'success',
                'reason' => 'User Inserted',
                'data' => $id,
            );
            return $this->response
                            ->setStatusCode(201)
                            ->setJson($response);
        } else {
            $response = array(
                'status' => 'success',
                'reason' => 'User not inserted',
                'data' => '',
            );
            return $this->response
                            ->setStatusCode(400)
                            ->setJson($response);
        }
    }
     public function updateUser() {

        
        $userModel = new UserModel();
        $data = $this->request->getJSON();
        $arr = [
            'name' => $data->name,
            'phone' => $data->phone,
            'email' => $data->email,
        ];
        if($data->password!=''){
            $arr['password'] = md5($data->password);
        }
        $userModel->where('id', $data->id)->set($arr)->update();
        //$userModel->update($data->id, $arr);
       
            $response = array(
                'status' => 'success',
                'reason' => 'User Updated',
                'data' => '',
            );
            return $this->response
                            ->setStatusCode(200)
                            ->setJson($response);
        
    }
    
     public function deleteUser() {

        
        $userModel = new UserModel();
        $id = $this->request->getPost('id');
        $arr = [
            'status' => 0,
            
        ];
        
        $res=$userModel->where('id', $id)->set($arr)->update();
        //$userModel->update($id, $arr);
       if($res){
           $response = array(
                'status' => 'success',
                'reason' => 'User deleted',
                'data' => '',
            );
            return $this->response
                            ->setStatusCode(200)
                            ->setJson($response);
       }else{
           $response = array(
                'status' => 'success',
                'reason' => 'User not deleted',
                'data' => '',
            );
            return $this->response
                            ->setStatusCode(400)
                            ->setJson($response); 
       }
            
        
    }
}
