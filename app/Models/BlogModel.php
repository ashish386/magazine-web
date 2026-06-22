<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogModel extends Model
{
    protected $table = 'blogs';           // Database table name
    protected $primaryKey = 'id';         // Primary key column
    protected $returnType = 'object';
    protected $allowedFields = [          // Columns you can insert/update
        'name',
        'status',
    ];

    protected $useTimestamps = true;      // Automatically manage created_at, updated_at
}
