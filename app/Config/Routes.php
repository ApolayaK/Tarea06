<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Reportes
$routes->get('/reportes/r1', 'ReporteController::getReport1');
$routes->get('/reportes/r2', 'ReporteController::getReport2');
$routes->get('/reportes/r3', 'ReporteController::getReport3');
// Excel
$routes->get('/reportes/excel1', 'ReporteController::getExcel1');

// Muestra una interfaz Web (form) para que el USUARIO seleccione un "tipo de reporte" a generar
$routes->get('/reportes/showui', 'ReporteController::showUIReport');
$routes->post('/reportes/publisher', 'ReporteController::getReportByPublisher');
$routes->post('/reportes/racealignment', 'ReporteController::getReportByRaceAlignment');

// Dashboard 
$routes->get('/dashboard/informe1', 'DashboardController::getInforme1');
$routes->get('/dashboard/informe2', 'DashboardController::getInforme2');
$routes->get('/dashboard/informe3', 'DashboardController::getInforme3');
$routes->get('/dashboard/informe4', 'DashboardController::getInforme4');

// API
$routes->get('/public/api/getdatainforme2', 'DashboardController::getDataInforme2');
$routes->get('/public/api/getdatainforme3', 'DashboardController::getDataInforme3');
$routes->get('/public/api/getdatainforme4', 'DashboardController::getDataInforme4');

// CACHE
$routes->get('/public/api/getdatainforme3cache', 'DashboardController::getDataInforme3Cache');
$routes->get('/public/api/getdatainforme4cache', 'DashboardController::getDataInforme4Cache');
