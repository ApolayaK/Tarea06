<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportePublisher extends Model
{
    protected $table = 'publisher';
    protected $primaryKey = 'id';
    protected $allowedFields = ['publisher_name'];

    /**
     * Retorna un resumen de superhéroes por publisher (IDs filtrados)
     * Publisher IDs: 3, 4, 5, 10, 13
     */
    public function getResumenPublisher()
    {
        return $this->select('publisher.id, publisher.publisher_name AS publisher, COUNT(superhero.id) AS total')
                    ->join('superhero', 'superhero.publisher_id = publisher.id', 'left')
                    ->whereIn('publisher.id', [3, 4, 5, 10, 13])
                    ->groupBy('publisher.id, publisher.publisher_name')
                    ->findAll();
    }
}

