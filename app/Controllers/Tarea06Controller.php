<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\tarea06\SuperheroModel;
use App\Models\Tarea06\EditorialModel;
use App\Models\tarea06\GenderModel;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

class Tarea06Controller extends BaseController
{
    public function interfaz()
    {
        $genderModel = new GenderModel();
        $data['genders'] = $genderModel->findAll();
        return view('tarea06/interfaz', $data);
    }

    public function interfaz2()
    {
        return view('tarea06/interfaz2');
    }

    public function exportPDF()
    {
        $request = $this->request;
        $titulo = $request->getPost('titulo');
        $gender_ids = $request->getPost('gender_ids');
        $limit = intval($request->getPost('limit'));

        if ($limit < 10)
            $limit = 10;
        if ($limit > 200)
            $limit = 200;

        $superheroModel = new SuperheroModel();

        // Caso con 2 o 3 géneros y personalización de cantidades
        if ((count($gender_ids) === 2 || count($gender_ids) === 3) && $request->getPost('gender_counts')) {
            $gender_counts = $request->getPost('gender_counts'); // ['1'=>5, '3'=>6]
            $total_counts = array_sum($gender_counts);

            // Ajustar si sobrepasa el límite
            if ($total_counts > $limit) {
                $factor = $limit / $total_counts;
                foreach ($gender_counts as $id => $count) {
                    $gender_counts[$id] = floor($count * $factor);
                }
            }

            $superheroes = [];
            foreach ($gender_counts as $gid => $count) {
                $heroes = $superheroModel->getSuperheroesByGenderCount($gid, $count);
                $superheroes = array_merge($superheroes, $heroes);
            }

        } else {

            $superheroes = $superheroModel->getSuperheroesForPDF($gender_ids, $limit);
        }

        try {
            $html = view('tarea06/resultados_pdf', [
                'titulo' => $titulo,
                'superheroes' => $superheroes
            ]);

            $html2pdf = new Html2Pdf('L', 'A4', 'es', true, 'UTF-8', [20, 10, 10, 10]);
            $html2pdf->writeHTML($html);
            $this->response->setHeader('Content-Type', 'application/pdf');
            $html2pdf->output('Reporte-Superheroes.pdf');
            exit();

        } catch (Html2PdfException $e) {
            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
    }

    public function getEditoriales()
    {
        $model = new EditorialModel();
        return $this->response->setJSON($model->getEditoriales());
    }

    public function getEditorialData()
    {
        $ids = $this->request->getPost('editorial_ids') ?? [];
        $model = new EditorialModel();
        $data = $model->getData($ids);

        return $this->response->setJSON([
            'success' => true,
            'resumen' => $data
        ]);
    }

    public function exportPDFEditorial()
    {
        $ids = $this->request->getPost('editorial_ids') ?? [];
        $model = new EditorialModel();

        // Obtener los héroes de las editoriales seleccionadas
        $superheroes = $model->getSuperheroesByEditorials($ids);

        try {
            $html = view('tarea06/resultados2_pdf', [
                'titulo' => 'Reporte Editorial',
                'superheroes' => $superheroes
            ]);

            $html2pdf = new Html2Pdf('L', 'A4', 'es');
            $html2pdf->writeHTML($html);
            $this->response->setHeader('Content-Type', 'application/pdf');
            $html2pdf->output('Reporte-Editorial.pdf');
            exit();
        } catch (Html2PdfException $e) {
            echo $e->getMessage();
        }
    }



}
