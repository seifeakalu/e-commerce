<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['vendor'] = 'vendor/index';
$route['admin'] = 'admin/index';
$route['vendor/edit/(:any)'] = 'admin/edit/$1';
$route['product/edit/(:any)'] = 'vendor/edit/$1';
$route['product/view/(:any)'] = 'vendor/productdetail/$1';
$route['default_controller'] = 'admin/view';
$route['(:any)']='admin/view/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
