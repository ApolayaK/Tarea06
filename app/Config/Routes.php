<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ------------------------------
// RUTA PRINCIPAL
// ------------------------------
$routes->get('/', 'Home::index');

// ------------------------------
// RUTAS DE REPORTES (Interfaz y Excel)
// ------------------------------

// Reportes individuales
$routes->get('/reportes/r1', 'ReporteController::getReport1');
$routes->get('/reportes/r2', 'ReporteController::getReport2');
$routes->get('/reportes/r3', 'ReporteController::getReport3');

// Exportar a Excel
$routes->get('/reportes/excel1', 'ReporteController::getExcel1');

// Interfaz web para selección de reportes
$routes->get('/reportes/showui', 'ReporteController::showUIReport');

// Reportes basados en filtros (POST)
$routes->post('/reportes/publisher', 'ReporteController::getReportByPublisher');
$routes->post('/reportes/racealignment', 'ReporteController::getReportByRaceAlignment');

// ------------------------------
// DASHBOARD (Vistas de informes)
// ------------------------------
$routes->get('/dashboard/informe1', 'DashboardController::getInforme1');
$routes->get('/dashboard/informe2', 'DashboardController::getInforme2');
$routes->get('/dashboard/informe3', 'DashboardController::getInforme3');
$routes->get('/dashboard/informe4', 'DashboardController::getInforme4'); // Informe con dos gráficos (Gender y Publisher)

// ------------------------------
// API SIN CACHE
// ------------------------------
$routes->get('/public/api/getdatainforme2', 'DashboardController::getDataInforme2'); // Popularidad
$routes->get('/public/api/getdatainforme3', 'DashboardController::getDataInforme3'); // Alignment
$routes->get('/public/api/getdatainforme4', 'DashboardController::getDataInforme4'); // Gender

// ------------------------------
// API CON CACHE (para mejorar performance)
// ------------------------------
$routes->get('/public/api/getdatainforme3cache', 'DashboardController::getDataInforme3Cache'); // Alignment
$routes->get('/public/api/getdatainforme4cache', 'DashboardController::getDataInforme4Cache'); // Gender
$routes->get('/public/api/getdatainformepublishercache', 'DashboardController::getDataInformePublisherCache'); // Publisher (IMPORTANTE: gráfico 2)
