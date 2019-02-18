<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|    example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|    https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|    $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|    $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|    $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:    my-controller/index    -> my_controller/index
|        my-controller/my-method    -> my_controller/my_method
 */
$route['default_controller'] = 'laikipia/login';
// $route['404_override'] = 'auth/login_merchant';
$route['translate_uri_dashes'] = false;

/**
 * Merchant Routes
 */
/**
 * Auth
 */

$route['laikipia/login'] = 'auth/laikipiaauth/login_admin';
$route['laikipia/logout'] = 'auth/laikipiaauth/logout';

/**
 * Admin
 */
$route['administration'] = 'admin';
$route['admin'] = 'admin';
$route['dashboard'] = 'admin/dashboard';

/**
 * Sections
 */
$route['administration/sections'] = 'admin/sections/index';
$route['administration/sections/(:any)/(:any)/(:num)'] = 'admin/sections/index/$1/$2/$3';
$route['administration/sections/(:any)/(:any)'] = 'admin/sections/index/$1/$2';
$route['administration/add-section'] = 'admin/sections/add_section';
$route['administration/edit-section/(:num)'] = 'admin/sections/edit_section/$1';
$route['administration/edit-section/(:num)/(:num)'] = 'admin/sections/edit_section/$1/$2';
$route['administration/delete-section/(:num)'] = 'admin/sections/delete_section/$1';
$route['administration/delete-section/(:num)/(:num)'] = 'admin/sections/delete_section/$1/$2';
$route['administration/activate-section/(:num)'] = 'admin/sections/activate_section/$1';
$route['administration/activate-section/(:num)/(:num)'] = 'admin/sections/activate_section/$1/$2';
$route['administration/deactivate-section/(:num)'] = 'admin/sections/deactivate_section/$1';
$route['administration/deactivate-section/(:num)/(:num)'] = 'admin/sections/deactivate_section/$1/$2';



//Laikipia schools
/**
 * Donations
 */
$route['laikipiaschools/donations'] = 'laikipiaschools/donations/index';
$route['laikipiaschools/single-donation/(:num)'] = 'laikipiaschools/donations/single_donation/$1';
$route['laikipiaschools/edit-donation/(:num)'] = 'laikipiaschools/donations/edit_donation/$1';
$route['laikipiaschools/delete-donation/(:num)'] = 'laikipiaschools/donations/delete_donation/$1';
$route['laikipiaschools/export-donations'] = 'laikipiaschools/donations/export_transactions';
$route['laikipiaschools/donations/(:any)/(:any)/(:num)'] = 'laikipiaschools/donations/index/$1/$2/$3';
$route['laikipiaschools/donations/(:any)/(:any)'] = 'laikipiaschools/donations/index/$1/$2';
$route['laikipiaschools/donations/bulk-actions'] = 'laikipiaschools/donations/bulk_actions';

//partners

$route['laikipiaschools/update-merchants/(:num)/(:num)'] = 'laikipiaschools/partners/update_merchant_info/$1/$2';
$route['laikipiaschools/partners'] = 'laikipiaschools/partners/index';
$route['laikipiaschools/edit/(:num)'] = 'laikipiaschools/partners/edit/$1';
$route['laikipiaschools/search-partners'] = 'laikipiaschools/partners/search_transactions';
$route['laikipiaschools/close-search'] = 'laikipiaschools/partners/close_search';
$route['laikipiaschools/export-partners'] = 'laikipiaschools/partners/export_transactions';
$route['laikipiaschools/partners/(:any)/(:any)/(:num)'] = 'laikipiaschools/partners/index/$1/$2/$3';
$route['laikipiaschools/partners/(:any)/(:any)'] = 'laikipiaschools/partners/index/$1/$2';
$route['laikipiaschools/partners/bulk-actions'] = 'laikipiaschools/partners/bulk_actions';
$route['laikipiaschools/delete-partner/(:num)'] = 'laikipiaschools/partners/delete_partner/$1';
/**
 * Schools
 */
$route['laikipiaschools/update-school/(:num)'] = 'laikipiaschools/schools/edit_school/$1';
$route['laikipiaschools/schools'] = 'laikipiaschools/schools/index';
$route['laikipiaschools/add-schools'] = 'laikipiaschools/schools/add_school';
$route['laikipiaschools/search-schools'] = 'laikipiaschools/schools/search_transactions';
$route['laikipiaschools/close-search'] = 'laikipiaschools/schools/close_search';
$route['laikipiaschools/export-schools'] = 'laikipiaschools/schools/export_transactions';
$route['laikipiaschools/schools/(:any)/(:any)/(:num)'] = 'laikipiaschools/schools/index/$1/$2/$3';
$route['laikipiaschools/schools/(:any)/(:any)'] = 'laikipiaschools/schools/index/$1/$2';
$route['laikipiaschools/schools/bulk-actions'] = 'laikipiaschools/schools/bulk_actions';


/**
 * Documents
 */
$route['laikipiaschools/update-school/(:num)'] = 'laikipiaschools/documents/edit_school/$1';
$route['laikipiaschools/documents'] = 'laikipiadocuments/documents/index';
$route['laikipiaschools/add-documents'] = 'laikipiadocuments/documents/add_school';
$route['laikipiaschools/search-documents'] = 'laikipiadocuments/documents/search_transactions';
$route['laikipiaschools/close-search'] = 'laikipiadocuments/documents/close_search';
$route['laikipiaschools/export-documents'] = 'laikipiadocuments/documents/export_transactions';
$route['laikipiaschools/documents/(:any)/(:any)/(:num)'] = 'laikipiadocuments/documents/index/$1/$2/$3';
$route['laikipiaschools/documents/(:any)/(:any)'] = 'laikipiadocuments/documents/index/$1/$2';
$route['laikipiaschools/documents/bulk-actions'] = 'laikipiadocuments/documents/bulk_actions';
