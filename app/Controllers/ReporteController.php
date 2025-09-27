<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Alignment;
use App\Models\Publisher;
use App\Models\Race;
use App\Models\Superhero;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

class ReporteController extends BaseController
{
  protected $db;

  public function __construct(){
    $this->db = \Config\Database::connect(); //Acceso BD
  }

  public function showUIReport(){
    $publisher = new Publisher();
    $race = new Race();
    $alignment = new Alignment();

    $data = [
      'publishers'  => $publisher->findAll(),
      'races'       => $race->findAll(),
      'alignments'  => $alignment->findAll(),
    ];

    return view('reportes/rpt-ui', $data);
  }

  public function getReportByPublisher(){
    $superhero = new Superhero();
    $publisher_id = intval($this->request->getVar('publisher_id'));

    $data = [
      'estilos'    => view('reportes/estilos'),
      'superheros' => $superhero->getSuperHeroByPublisher($publisher_id),
    ];

    $html = view('reportes/rpt-superhero', $data);

    try {
      $html2PDF = new Html2Pdf('L', 'A4', 'es', true, 'UTF-8', [20, 10, 10, 10]);
      $html2PDF->writeHTML($html);

      $this->response->setHeader('Content-Type', 'application/pdf');
      $html2PDF->output('Reporte-superhero-publisher.pdf');
      exit();
    } catch (Html2PdfException $e) {
      $html2PDF->clean();
      $formatter = new ExceptionFormatter($e);
      echo $formatter->getMessage();
    }
  }

  public function getReportByRaceAlignment(){
    $superhero = new Superhero();

    $data = [
      'estilos'    => view('reportes/estilos'),
      'superheros' => $superhero->getSuperHeroByRaceAlignment(1, 2),
    ];

    return view('reportes/rpt-superhero-ra', $data);
  }

  public function getReport1()
  {
    $html = view('reportes/reporte1');

    $html2PDF = new Html2Pdf();
    $html2PDF->writeHTML($html);

    $this->response->setHeader('Content-Type', 'application/pdf');

    $html2PDF->output();
  }

  public function getReport2()
  {
    $data = [
      "area" => "Sistemas",
      "autor" => "Jhon Francia Minaya",
      "productos" => [
        ["id" => 1, "descripcion" => "Monitor", "precio" => 750],
        ["id" => 2, "descripcion" => "Impresora", "precio" => 500],
        ["id" => 3, "descripcion" => "WebCam", "precio" => 220]
      ],
      "estilos" => view('reportes/estilos')
    ];

    $html = view('reportes/reporte2', $data);

    try {
      $html2PDF = new Html2Pdf('P', 'A4', 'es', true, 'UTF-8', [20, 10, 10, 10]);
      $html2PDF->writeHTML($html);

      $this->response->setHeader('Content-Type', 'application/pdf');
      $html2PDF->output('Reporte-Finanzas.pdf');
    } catch (Html2PdfException $e) {
      $html2PDF->clean();
      $formatter = new ExceptionFormatter($e);
      echo $formatter->getMessage();
    }
  }

  public function getReport3()
  {
    $query = "
      SELECT
        SH.id,
        SH.superhero_name,
        SH.full_name,
        PB.publisher_name,
        AL.alignment
      FROM superhero SH 
      LEFT JOIN publisher PB ON SH.publisher_id = PB.id
      LEFT JOIN alignment AL ON SH.alignment_id = AL.id
      ORDER BY PB.publisher_name
      LIMIT 150;
    ";

    $rows = $this->db->query($query);

    $data = [
      "rows"    => $rows->getResultArray(),
      "estilos" => view('reportes/estilos')
    ]; 

    $html = view('reportes/reporte3', $data);

    try {
      $html2PDF = new Html2Pdf('L', 'A4', 'es', true, 'UTF-8', [20, 10, 10, 10]);
      $html2PDF->writeHTML($html);

      $this->response->setHeader('Content-Type', 'application/pdf');
      $html2PDF->output('Reporte-superhero.pdf');
      exit();
    } catch (Html2PdfException $e) {
      $html2PDF->clean();
      $formatter = new ExceptionFormatter($e);
      echo $formatter->getMessage();
    }
  }

  public function getExcel1(){
    return view('xlsx/demo1');
  }
}
