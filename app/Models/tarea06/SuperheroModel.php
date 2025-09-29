<?php

namespace App\Models\tarea06;

use CodeIgniter\Model;

class SuperheroModel extends Model
{
    protected $table = 'superhero.superhero';
    protected $primaryKey = 'id';
    protected $allowedFields = ['superhero_name', 'full_name', 'gender_id', 'race_id'];

    public function getSuperheroesForPDF($gender_ids = [], $limit = 10)
    {
        $builder = $this->db->table($this->table . ' s')
            ->select('s.id, s.superhero_name, s.full_name, r.race, g.gender')
            ->join('superhero.gender g', 's.gender_id=g.id', 'left')
            ->join('superhero.race r', 's.race_id=r.id', 'left');

        if (!empty($gender_ids)) {
            $builder->whereIn('s.gender_id', $gender_ids);
        }

        $builder->limit($limit);
        return $builder->get()->getResultArray();
    }

    public function getSuperheroesByGenderCount($gender_id, $count)
    {
        $builder = $this->db->table($this->table . ' s')
            ->select('s.id, s.superhero_name, s.full_name, r.race, g.gender')
            ->join('superhero.gender g', 's.gender_id=g.id', 'left')
            ->join('superhero.race r', 's.race_id=r.id', 'left')
            ->where('s.gender_id', $gender_id)
            ->limit($count);

        return $builder->get()->getResultArray();
    }
}
