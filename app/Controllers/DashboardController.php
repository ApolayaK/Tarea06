<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ReporteAlignment;
use App\Models\ReporteGender;
use App\Models\ReportePublisher;

class DashboardController extends BaseController
{
  public function getInforme1()
  {
    return view('dashboard/informe1');
  }

  //Retorna una vista
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

  //Retorna el JSON que requiere la vista
  public function getDataInforme2()
  {
    $this->response->setContentType('application/json');

    //Popularidad (consulta BD...)
    $data = [
      ["superhero" => "Batman", "popularidad" => 20],
      ["superhero" => "Red Hood", "popularidad" => 100],
      ["superhero" => "Super man", "popularidad" => 30],
      ["superhero" => "Spiderman", "popularidad" => 50],
      ["superhero" => "Linterna verde", "popularidad" => 10],
    ];

    //En caso no encontramos datos..
    if (!$data) {
      return $this->response->setJSON([
        'success' => false,
        'message' => 'No entramos superhero',
        'resumen' => []
      ]);
    }

    sleep(3);
    //Datos encontramos, enviando JSON
    return $this->response->setJSON([
      'success' => true,
      'message' => 'Popularidad',
      'resumen' => $data
    ]);

  }

  public function getDataInforme3()
  {
    $this->response->setContentType('application/json');
    $reporteAlignment = new ReporteAlignment();
    $data = $reporteAlignment->findAll();

    //En caso no encontramos datos..
    if (!$data) {
      return $this->response->setJSON([
        'success' => false,
        'message' => 'No entramos superhero',
        'resumen' => []
      ]);
    }

    //Datos encontramos, enviando JSON
    return $this->response->setJSON([
      'success' => true,
      'message' => 'Alineaciones',
      'resumen' => $data
    ]);
  }


  public function getDataInforme4()
  {
    $this->response->setContentType('application/json');
    $reporteGender = new ReporteGender();
    $data = $reporteGender->findAll();

    //En caso no encontramos datos..
    if (!$data) {
      return $this->response->setJSON([
        'success' => false,
        'message' => 'No entramos superhero',
        'resumen' => []
      ]);
    }

    //Datos encontramos, enviando JSON
    return $this->response->setJSON([
      'success' => true,
      'message' => 'Gender',
      'resumen' => $data
    ]);
  }


  public function getDataInforme3Cache()
  {
    $this->response->setContentType('application/json');

    //Clave unica = identificador al conjunto de datos
    $cacheKey = 'resumenAlignment';

    //Obtener losa dotos de la memoria cache
    $data = cache($cacheKey);

    if ($data == null) {
      $reporteAlignment = new ReporteAlignment();
      $data = $reporteAlignment->findAll();

      cache()->save($cacheKey, $data, 3600);
    }


    //En caso no encontramos datos..
    if (!$data) {
      return $this->response->setJSON([
        'success' => false,
        'message' => 'No entramos superhero',
        'resumen' => []
      ]);
    }

    //Datos encontramos, enviando JSON
    return $this->response->setJSON([
      'success' => true,
      'message' => 'Alineaciones',
      'resumen' => $data
    ]);
  }


  public function getDataInforme4Cache()
  {
    $this->response->setContentType('application/json');

    //Clave unica = identificador al conjunto de datos
    $cacheKey = 'resumenGender';

    //Obtener losa dotos de la memoria cache
    $data = cache($cacheKey);

    if ($data == null) {
      $reporteGender = new ReporteGender();
      $data = $reporteGender->findAll();

      cache()->save($cacheKey, $data, 3600);
    }


    //En caso no encontramos datos..
    if (!$data) {
      return $this->response->setJSON([
        'success' => false,
        'message' => 'No entramos superhero',
        'resumen' => []
      ]);
    }

    //Datos encontramos, enviando JSON
    return $this->response->setJSON([
      'success' => true,
      'message' => 'Alineaciones',
      'resumen' => $data
    ]);
  }

  public function getDataInformePublisherCache()
  {
    $this->response->setContentType('application/json');

    $cacheKey = 'resumenPublisher';

    $data = cache($cacheKey);

    if ($data == null) {
      $reportePublisher = new ReportePublisher();
      $data = $reportePublisher->getResumenPublisher();
  // O un método personalizado que hagas

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