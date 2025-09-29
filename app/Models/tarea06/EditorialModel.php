<?php
namespace App\Models\tarea06;

use CodeIgniter\Model;

class EditorialModel extends Model
{
    protected $table = 'view_superhero_publisher';
    protected $primaryKey = 'id';
    protected $allowedFields = ['publisher_name', 'total_superheroes'];

    // Obtener todas las editoriales con héroes
    public function getEditoriales()
    {
        return $this->where('total_superheroes >', 0)->findAll();
    }

    // Obtener datos filtrados según IDs seleccionados
    public function getData($ids = [])
    {
        $builder = $this->db->table($this->table);
        $builder->select('id, publisher_name, total_superheroes');

        if (!empty($ids)) {
            $builder->whereIn('id', $ids);
        }

        return $builder->get()->getResultArray();
    }

    public function getSuperheroesByEditorials(array $ids)
    {
        if (empty($ids))
            return [];

        $builder = $this->db->table('superhero s');
        $builder->select('s.id, s.superhero_name, s.full_name, r.race, g.gender, a.alignment, p.publisher_name');
        $builder->join('publisher p', 's.publisher_id = p.id');
        $builder->join('gender g', 's.gender_id = g.id', 'left');
        $builder->join('race r', 's.race_id = r.id', 'left');
        $builder->join('alignment a', 's.alignment_id = a.id', 'left');
        $builder->whereIn('p.id', $ids);
        $builder->orderBy('s.superhero_name', 'ASC');

        return $builder->get()->getResultArray();
    }

}
