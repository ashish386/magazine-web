<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';           // Database table name
    protected $primaryKey = 'id';         // Primary key column
    protected $returnType = 'object';
    protected $allowedFields = [          // Columns you can insert/update
        'title',
        'description',
        'price',
        'special_price',
        'short_description',
        'category',
    ];

    protected $useTimestamps = true; // Automatically manage created_at, updated_at
	
	
    public function getProductCount() {
        $db=\Config\Database::connect();
        $builder = $db->table('products');
        return $builder->CountAll();
               
    }
	public function getProductsByCategoryId($id) {
        $db=\Config\Database::connect();
        $builder = $db->table('products');
        $builder->select('products.*,product_images.file image');
        $builder->join('product_images','products.id=product_images.product_id');
        $builder->where('products.category',$id);
        $builder->where('product_images.default_image',1);
        $builder->where('products.status',1);
        $builder->orderBy('id DESC');
        return $builder->get()->getResult();
        
    }
    public function getLatestProductsByCategoryId($id) {
        $db=\Config\Database::connect();
        $builder = $db->table('products');
        $builder->limit(1);
        $builder->select('*');
        $builder->where('category',$id);
        $builder->where('status',1);
		$builder->orderBy('id DESC');
        return $builder->get()->getRow();
        
    }
    public function getProductById($id) {
        $db=\Config\Database::connect();
		$baseurl=base_url()."public/uploads/products/";
        $builder = $db->table('products');
        $builder->select('*');
        $builder->where('id',$id);
        $builder->where('status',1);
        $product = $builder->get()->getRow();
        
        $builder2 = $db->table('product_images');
        $builder2->select("id,CONCAT('$baseurl', file) image_url,default_image"); 
        $builder2->where('product_images.product_id',$id);
        $builder2->where('status',1);

        $product->images=$builder2->get()->getResult();
       
        return $product;
        
    }
}
