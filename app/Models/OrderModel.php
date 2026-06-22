<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';           // Database table name
    protected $primaryKey = 'id';         // Primary key column
    protected $returnType = 'object';
    protected $allowedFields = [          // Columns you can insert/update
        'product_id',
        'customer_id',
        'date',
        'amount',
        'quantity',
        
    ];

    protected $useTimestamps = true;      // Automatically manage created_at, updated_at
    
    public function getOrdersByCustomerId($id) {
        $db=\Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('orders.*,products.title product');
        $builder->join('products','orders.product_id=products.id','left');
        $builder->where('customer_id',$id);
        $builder->where('status',1);
        $order = $builder->get()->getResult();
        return $order;
        
    }
	public function getOrdersById($id) {
        $db=\Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('orders.*,products.title product,products.file');
        $builder->join('products','orders.product_id=products.id');
        $builder->where('orders.id',$id);
        $builder->where('status',1);
        $order = $builder->get()->getRow();
        return $order;
        
    }
	public function getAllOrder() {
        $db=\Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('orders.*,products.title product,products.file,customers.name customer');
        $builder->join('products','orders.product_id=products.id');
        $builder->join('customers','orders.customer_id=customers.id');
        //$builder->where('orders.status',1);
        $order = $builder->get()->getResult();
        return $order; 
    }
}
