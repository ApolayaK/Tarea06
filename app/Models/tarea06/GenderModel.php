<?php

namespace App\Models\tarea06;

use CodeIgniter\Model;

class GenderModel extends Model
{
    protected $table = 'superhero.gender';
    protected $primaryKey = 'id';
    protected $allowedFields = ['gender'];
}
