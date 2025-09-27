<?php
namespace App\Models;

use CodeIgniter\Model;

class ReportePublisher extends Model
{
  protected $table = 'superhero';

  public function getResumenPublisher()
  {
    $builder = $this->db->table('superhero AS sh');
    $builder->select('p.name AS publisher, COUNT(sh.id) AS total');
    $builder->join('publisher AS p', 'p.id = sh.publisher_id', 'left');
    $builder->whereIn('p.id', [4, 13, 3, 5, 10]);  // los ids que mencionaste
    $builder->groupBy('p.id');

    return $builder->get()->getResultArray();
  }
}
