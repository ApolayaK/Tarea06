<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ReporteAlignment;
use App\Models\ReporteGender;
use App\Models\ReportePublisher;

class DashboardController extends BaseController
{

  /* =============================
   *   VISTAS (HTML)
   * ============================= */
  public function getInforme1()
  {
    return view('dashboard/informe1');
  }

  public function getInforme2()
  {
    return view('dashboard/informe2');
  }

  public function getInforme3()
  {
    return view('dashboard/informe3');
  }

  public function getInforme4()
  {
    return view('dashboard/informe4');
  }


  /* =============================
   *   API - INFORME 2 (Popularidad)
   * ============================= */
  public function getDataInforme2()
  {
    $this->response->setContentType('application/json');

    // Simulación de datos (en un caso real vendrían de BD)
    $data = [
      ["superhero" => "Batman", "popularidad" => 20],
      ["superhero" => "Red Hood", "popularidad" => 100],
      ["superhero" => "Super man", "popularidad" => 30],
      ["superhero" => "Spiderman", "popularidad" => 50],
      ["superhero" => "Linterna verde", "popularidad" => 10],
    ];

    if (!$data) {
      return $this->response->setJSON([
        'success' => false,
        'message' => 'No encontramos superheroes',
        'resumen' => []
      ]);
    }

    // Simulación de demora en consulta
    sleep(2);

    return $this->response->setJSON([
      'success' => true,
      'message' => 'Popularidad',
      'resumen' => $data
    ]);
  }


  /* =============================
   *   API - INFORME 3 (Alignment)
   * ============================= */
  public function getDataInforme3()
  {
    $this->response->setContentType('application/json');
    $reporteAlignment = new ReporteAlignment();
    $data = $reporteAlignment->findAll();

    if (!$data) {
      return $this->response->setJSON([
        'success' => false,
        'message' => 'No encontramos superheroes',
        'resumen' => []
      ]);
    }

    return $this->response->setJSON([
      'success' => true,
      'message' => 'Alineaciones',
      'resumen' => $data
    ]);
  }


  /* =============================
   *   API - INFORME 4 (Gender)
   * ============================= */
  public function getDataInforme4()
  {
    $this->response->setContentType('application/json');
    $reporteGender = new ReporteGender();
    $data = $reporteGender->findAll();

    if (!$data) {
      return $this->response->setJSON([
        'success' => false,
        'message' => 'No encontramos superheroes',
        'resumen' => []
      ]);
    }

    return $this->response->setJSON([
      'success' => true,
      'message' => 'Gender',
      'resumen' => $data
    ]);
  }


  /* =============================
   *   CACHE - INFORME 3 (Alignment)
   * ============================= */
  public function getDataInforme3Cache()
  {
    $this->response->setContentType('application/json');
    $cacheKey = 'resumenAlignment';

    $data = cache($cacheKey);
    if ($data == null) {
      $reporteAlignment = new ReporteAlignment();
      $data = $reporteAlignment->findAll();
      cache()->save($cacheKey, $data, 3600);
    }

    if (!$data) {
      return $this->response->setJSON([
        'success' => false,
        'message' => 'No encontramos superheroes',
        'resumen' => []
      ]);
    }

    return $this->response->setJSON([
      'success' => true,
      'message' => 'Alineaciones',
      'resumen' => $data
    ]);
  }


  /* =============================
   *   CACHE - INFORME 4 (Gender)
   * ============================= */
  public function getDataInforme4Cache()
  {
    $this->response->setContentType('application/json');
    $cacheKey = 'resumenGender';

    $data = cache($cacheKey);
    if ($data == null) {
      $reporteGender = new ReporteGender();
      $data = $reporteGender->findAll();
      cache()->save($cacheKey, $data, 3600);
    }

    if (!$data) {
      return $this->response->setJSON([
        'success' => false,
        'message' => 'No encontramos superheroes',
        'resumen' => []
      ]);
    }

    return $this->response->setJSON([
      'success' => true,
      'message' => 'Gender',
      'resumen' => $data
    ]);
  }


  /* =============================
   *   CACHE - INFORME 4 (Publishers)
   * ============================= */
  public function getDataInformePublisherCache()
  {
    $this->response->setContentType('application/json');
    $cacheKey = 'resumenPublisher';

    $data = cache($cacheKey);
    if ($data == null) {
      $reportePublisher = new ReportePublisher();
      $data = $reportePublisher->getResumenPublisher(); // Método personalizado en el modelo
      cache()->save($cacheKey, $data, 3600);
    }

    if (!$data) {
      return $this->response->setJSON([
        'success' => false,
        'message' => 'No se encontraron datos de publishers',
        'resumen' => []
      ]);
    }

    return $this->response->setJSON([
      'success' => true,
      'message' => 'Publishers',
      'resumen' => $data
    ]);
  }

}
