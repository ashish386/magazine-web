<?php

namespace App\Controllers;
use App\Models\ProductModel;
use App\Models\CustomerModel;
use App\Models\OrderModel;
class HomeController extends BaseController
{
    protected $session;
    public function __construct()
    {
        helper('form');
        $this->session=session();
    }
    public function index(): string
    {
       $product = new ProductModel();
       $data['latestmagzine'] = $product->getLatestProductsByCategoryId(1);
       $data['latestbook'] = $product->getLatestProductsByCategoryId(2);
       $data['magzines'] = $product->getProductsByCategoryId(1);
       $data['magzines'] = $product->getProductsByCategoryId(1);
       $data['books'] = $product->getProductsByCategoryId(2);
       
        return view('header')
            .view('index',$data)
            .view('footer');
    }
    
     public function about(): string
    {
       return view('header')
            .view('about')
            .view('footer');
    }
     public function contact(): string
    {
       return view('header')
            .view('contact')
            .view('footer');
    }
     public function privacy(): string
    {
       return view('header')
            .view('privacy')
            .view('footer');
    }
     public function refund(): string
    {
       return view('header')
            .view('refund')
            .view('footer');
    }
     public function terms(): string
    {
       return view('header')
            .view('terms')
            .view('footer');
    }
     public function category($id): string
    {
       $product = new ProductModel();
       $data['products'] = $product->getProductsByCategoryId($id); 
       return view('header')
            .view('category',$data)
            .view('footer');
    }
     public function product($id): string
    {
        $product = new ProductModel();
		$data['product'] = $product->getProductById($id); 
       return view('header')
            .view('product',$data)
            .view('footer');
    }
     public function checkout($id)
    {
              
        $product = new ProductModel();
        $customer = new CustomerModel();
         $data['product'] = $product->getProductById($id); 
         $session=session();
         //print_r($session->get('userdata')->id);
         
         if($session->has('userdata')){
             $data['address'] = $customer->getCustomerDetailById($session->get('userdata')->id);
         }
        
       return view('header')
            .view('checkout',$data)
            .view('footer');
    }


     public function placeOrder()
{
    $db = \Config\Database::connect();

    $customerid = $this->request->getPost("id");

    // User not logged in
    if ($customerid == 0) {

        $email = $this->request->getPost("email");

        $existingCustomer = $db->table('customers')
                               ->where('email', $email)
                               ->get()
                               ->getRow();

        // Already registered
        if ($existingCustomer) {

            return redirect()->back()->with(
                'error',
                'Email already registered. Please login first.'
            );
        }

        // New customer registration
        $arr = [
            'name'     => $this->request->getPost("name"),
            'email'    => $email,
            'phone'    => $this->request->getPost("phone"),
            'address'  => $this->request->getPost("address"),
            'city'     => $this->request->getPost("city"),
            'state'    => $this->request->getPost("state"),
            'pincode'  => $this->request->getPost("pincode"),
            'password' => md5(rand(100000,999999))
        ];

        $db->table('customers')->insert($arr);

        $customerid = $db->insertID();
    }
    else {

        // Update logged-in user's address
        $arr = [
            'address' => $this->request->getPost("address"),
            'city'    => $this->request->getPost("city"),
            'state'   => $this->request->getPost("state"),
            'pincode' => $this->request->getPost("pincode"),
        ];

        $db->table('customers')
           ->where('id', $customerid)
           ->update($arr);
    }

    // Save Order
    $arr2 = [
        'customer_id' => $customerid,
        'product_id'  => $this->request->getPost("product_id"),
        'date'        => date("Y-m-d"),
        'amount'      => $this->request->getPost("amount"),
        'quantity'    => $this->request->getPost("quantity"),
    ];

    $db->table('orders')->insert($arr2);

    $orderid = $db->insertID();

    return redirect()->to(
        'payOrder/' .
        $orderid . '/' .
        $this->request->getPost("product_id")
    );
}




      public function payOrder()
    {
            $uri = current_url(true);
            $orderid=$uri->getSegment(2);
            $id=$uri->getSegment(3);
            $product = new ProductModel();
            $customer = new CustomerModel();
            $session=session();

            $db=\config\Database::connect();

            $orderData= $db->table('orders')->where('id', $orderid)->get()->getRow();
            if(!$orderData){
                return redirect()->to('/');
            }
            $address= $db->table('customers')->where('id', $orderData->customer_id)->get()->getRow();
            if(!$address){
                return redirect()->to('/');
            }

             $data['name'] = $address->name;
             $data['email'] = $address->email;              
             $data['phone'] = $address->phone;
    

            $pro= $product->getProductById($id);
            $data['product'] = $pro->title;
            $data['amount'] = $pro->special_price;
            $data['merchantkey']=$merchantkey = "lp1Rxd";
            $data['payurl']="https://secure.payu.in/_payment";
            $data['salt']= $salt = "5b16codcBM4SJ36dvqhSAquHJMJrCwr5";
            $data['txnid']=$txnid=substr(hash('sha256', mt_rand() . microtime()), 0, 20);

            // echo "<pre>";
            // print_r($orderData); 
            //  print_r($address);
            // die;
            $hash_string=  $merchantkey.'|'.$txnid.'|'.$pro->special_price.'|'.$pro->title.'|'.$address->name.'|'.$address->email.'|'.$salt;
            $data['hash']= strtolower(hash('sha512', $hash_string)); 
            $data['callback_url']       = base_url('callback');
            $data['currency_code']      = 'INR';
            $data['surl']               = base_url('orderSuccess');
            $data['furl']               = base_url('orderFailed');
            
            $arr=array(
			'pay_status'=>0,
			'txnid'=>$txnid
		   );
            $db = \Config\Database::connect();
		   	$builder = $db->table('orders');
			$builder->where('id', $orderid);
			$builder->update($arr);
       return view('header')
            .view('payOrder',$data)
            .view('footer');
    }
      public function orderSuccess()
    {
          //print_r($_POST);
           $arr=array(
			'pay_status'=>1,
			'pay_mode'=>$this->request->getPost("mode"),
			'pay_date'=>date("Y-m-d"),
			'trans_no'=>$this->request->getPost("bank_ref_num"),
		   );
           $db = \Config\Database::connect();
		   	$builder = $db->table('orders');
			$builder->where('txnid', $this->request->getPost("txnid"));
			$builder->update($arr);
       return view('header')
            .view('orderSuccess')
            .view('footer');
    }
      public function orderFailed()
    {
       return view('header')
            .view('orderFailed')
            .view('footer');
    }
      public function login(): string
    {
       return view('header')
            .view('login')
            .view('footer');
    }
    
      public function registerCustomer()
    {
          $arr = [
            'name' => $this->request->getPost("name"),
            'phone' => $this->request->getPost("phone"),
            'email' => $this->request->getPost("email"),
            'password' => md5($this->request->getPost("password")),
            
            ];
                    
            $db = \Config\Database::connect();
            $builder = $db->table('customers');
            $builder->insert($arr);
            return view('header')
                 .view('login')
                 .view('footer');
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

    public function loginCustomer() {
       
        $email = $this->request->getPost("email"); 
        $password = $this->request->getPost("password");
              
        $db = \Config\Database::connect();
        $builder = $db->table('customers');
        $builder->select('id, name, email, phone,token');
        $builder->where('email', $email);
        $builder->where('password', md5($password));
        $rec = $builder->get();
        
        if ($rec->getNumRows()) {
            
            $headers = array('alg' => 'HS256', 'typ' => 'JWT');
            $payload = array(
                'email' => $email,
                'password' => md5($password),
                'logintime' => date("Y-m-d H:i:s"),
            );
            $jwt = $this->generate_jwt($headers, $payload, 'secret');
            $arr = array(
                'token' => $jwt
                //'token_expiry' => date("Y-m-d H:i:s", strtotime("+3600 seconds"))
            );
            $db = \Config\Database::connect();
            $users = $db->table('customers');
            $users->where('email', $email);
            $users->update($arr);

            $session=session();
            $session->set('userdata',$rec->getRow());
           
        
            return redirect()->to('dashboard');
        } else {
            return view('header')
            .view('login')
            .view('footer');
        }
        
    }
    public function loginViaCheckout() {
       
        $email = $this->request->getPost("email");
        $password = $this->request->getPost("password");
              
        $db = \Config\Database::connect();
        $builder = $db->table('customers');
        $builder->select('id, name, email, phone,token');
        $builder->where('email', $email);
        $builder->where('password', md5($password));
        $rec = $builder->get();
        //print_r($rec->getRow()); die;
        if ($rec->getNumRows()) {
            
            $headers = array('alg' => 'HS256', 'typ' => 'JWT');
            $payload = array(
                'email' => $email,
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

            $session=session();
            $session->set('userdata',$rec->getRow());
           
        
            return redirect()->to('checkout/'.$this->request->getPost("product"));
        } else {
            return view('header')
            .view('login')
            .view('footer');
        }
        
    }
      public function dashboard(): string
    {	
        $order = new OrderModel();
        $session=session();
        //print_r($session->get("userdata"));die;
		$data['orders'] = $order->getOrdersByCustomerId($session->get("userdata")->id);
        return view('header')
            .view('dashboard',$data)
            .view('footer');
    }
      public function logout()
    {
          $session=session();
          $session->destroy();
       return redirect()->to('/');
    }
	public function downloadFile($id)
    {
		$order = new OrderModel();
		$orderdetail = $order->getOrdersById($id);
		//print_r($orderdetail);die;
		$filePath = base_url('public/uploads/products/'.$orderdetail->file); 
        		return $this->response->setHeader('Content-Type', 'application/pdf')
                    ->setHeader('Content-Disposition', 'attachment; filename="'.$orderdetail->product.'.pdf"')
                    ->setBody(file_get_contents($filePath));

    }
    
   
    
}
