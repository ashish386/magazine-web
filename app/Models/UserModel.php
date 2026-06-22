<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';           // Database table name
    protected $primaryKey = 'id';         // Primary key column
    protected $returnType = 'object';
    protected $allowedFields = [          // Columns you can insert/update
        'name',
        'phone',
        'email',
        'password',
        'status',
        'image',
        'role'
    ];

    protected $useTimestamps = true;      // Automatically manage created_at, updated_at
	
	
	public function getUserCount() {
        $db=\Config\Database::connect();
        $builder = $db->table('users');
        return $builder->CountAll();
               
    }
}
