<?php

namespace App\Models\Tarea06;

use CodeIgniter\Model;

class PublisherModel extends Model
{
    protected $table = 'superhero.publisher';
    protected $primaryKey = 'id';
    protected $allowedFields = ['publisher_name'];
}
