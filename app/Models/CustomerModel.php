<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'users';           // Database table name
    protected $primaryKey = 'id';         // Primary key column
    protected $returnType = 'object';
    protected $allowedFields = [          // Columns you can insert/update
        'name',
        'phone',
        'email',
        'password',
        'state',
        'city',
        'address',
        'pincode'
    ];

    protected $useTimestamps = true;      // Automatically manage created_at, updated_at
    
    public function getCustomerDetailById($id) {
        $db=\Config\Database::connect();
        $builder = $db->table('customers');
        $builder->select('*');
        $builder->where('id',$id);
        $builder->where('status',1);
        $customer = $builder->get()->getRow();
        
        
       
        return $customer;
        
    }
}
