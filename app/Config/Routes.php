<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'HomeController::index');
$routes->get('/about', 'HomeController::about');
$routes->get('/contact', 'HomeController::contact');
$routes->get('/privacy', 'HomeController::privacy');
$routes->get('/refund', 'HomeController::refund');
$routes->get('/terms', 'HomeController::terms');
$routes->get('/magzine', 'HomeController::magzine');
$routes->get('/detail', 'HomeController::detail');
$routes->get('/category/(:segment)', 'HomeController::category/$1');
$routes->get('/product/(:segment)', 'HomeController::product/$1');
$routes->get('/checkout/(:segment)', 'HomeController::checkout/$1');
$routes->get('/login', 'HomeController::login');
$routes->get('/dashboard', 'HomeController::dashboard');
$routes->post('/registerCustomer', 'HomeController::registerCustomer');
$routes->post('/loginCustomer', 'HomeController::loginCustomer');
$routes->post('/loginViaCheckout', 'HomeController::loginViaCheckout');
$routes->post('/placeOrder', 'HomeController::placeOrder');
$routes->get('/payOrder/(:segment)/(:segment)', 'HomeController::payOrder/$1/$2');
$routes->post('/orderSuccess', 'HomeController::orderSuccess');
$routes->get('/orderFailed', 'HomeController::orderFailed');
$routes->get('/downloadFile/(:segment)', 'HomeController::downloadFile/$1');
$routes->get('/logout', 'HomeController::logout');

$routes->group("api",function($routes){
	$routes->post('login', 'UserController::login'); 
    
	$routes->get('getDashboardWidgetData', 'DashboardController::getDashboardWidgetData'); 
    
    $routes->get('getAllProduct', 'ProductController::getAllProduct');
    $routes->get('getProductById', 'ProductController::getProductById'); 
    $routes->post('saveProduct', 'ProductController::saveProduct');  
    $routes->post('updateProduct', 'ProductController::updateProduct');  
    $routes->get('deleteProduct', 'ProductController::deleteProduct'); 
     
    
    
    $routes->get('getAllBlog', 'BlogController::getAllBlog');
    $routes->post('saveBlog', 'BlogController::saveBlog');  
    $routes->post('updateBlog', 'BlogController::updateBlog');  
    $routes->get('deleteBlog', 'BlogController::deleteBlog');
    
    $routes->get('getAllCustomer', 'CustomerController::getAllCustomer');
    
    
    $routes->get('getAllCategory', 'CategoryController::getAllCategory');
    $routes->post('saveCategory', 'CategoryController::saveCategory');  
    $routes->post('updateCategory', 'CategoryController::updateCategory');  
    $routes->get('deleteCategory', 'CategoryController::deleteCategory');
	
    $routes->get('getAllOrder', 'OrderController::getAllOrder');
    $routes->post('getOrderId', 'PaymentController::getOrderId');
    
    
});
