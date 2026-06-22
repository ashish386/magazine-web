<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'category';           // Database table name
    protected $primaryKey = 'id';         // Primary key column
    protected $returnType = 'object';
    protected $allowedFields = [          // Columns you can insert/update
        'name',
        'status',
    ];

    protected $useTimestamps = false;      // Automatically manage created_at, updated_at
	
	public function getCategoryCount() {
        $db=\Config\Database::connect();
        $builder = $db->table('category');
        return $builder->CountAll();
               
    }
    
}
