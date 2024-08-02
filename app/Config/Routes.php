<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */



$routes->group('', ['filter' => 'auth:Guest'], static function ($routes) {
    $routes->get('/', 'UserController::login', ['as' => 'login']);
    $routes->post('login', 'UserController::loginHandler', ['as' => 'login.handler']);
});

$routes->group('', ['filter' => 'auth:User'], static function ($routes) {
    $routes->get('logout', 'UserController::logout', ['as' => 'logout']);
    
    $routes->get('bill', 'BillController::index', ['as' => 'bill.index']);
    $routes->get('bill-list', 'BillController::list', ['as' => 'bill.list']);
    $routes->get('bill-view', 'BillController::view', ['as' => 'bill.view']);

    $routes->get('product', 'ProductController::index', ['as' => 'product.index']);
    $routes->get('product-list', 'ProductController::list', ['as' => 'product.list']);
    $routes->get('product-search', 'ProductController::search', ['as' => 'product.search']);
    $routes->post('product-generate-bill', 'ProductController::generateBill', ['as' => 'products.generate.bill']);
});
