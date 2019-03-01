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
$route['default_controller'] = 'auth/laikipiaauth/login_admin';
$route['404_override'] = 'auth/laikipiaauth/login_admin';
$route['translate_uri_dashes'] = false;

/**
 * Merchant Routes
 */
/**
 * Auth
 */

$route['administration/login'] = 'auth/laikipiaauth/login_admin';
$route['administration/logout'] = 'auth/laikipiaauth/logout';

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
$route['administration/donations'] = 'laikipiaschools/donations/index';
$route['administration/single-donation/(:num)'] = 'laikipiaschools/donations/single_donation/$1';
$route['administration/edit-donation/(:num)'] = 'laikipiaschools/donations/edit_donation/$1';
$route['administration/delete-donation/(:num)'] = 'laikipiaschools/donations/delete_donation/$1';
$route['administration/export-donations'] = 'laikipiaschools/donations/export_transactions';
$route['administration/donations/(:any)/(:any)/(:num)'] = 'laikipiaschools/donations/index/$1/$2/$3';
$route['administration/donations/(:any)/(:any)'] = 'laikipiaschools/donations/index/$1/$2';
$route['administration/donations/bulk-actions'] = 'laikipiaschools/donations/bulk_actions';

//donation corrections

//partners

$route['administration/partners'] = 'laikipiaschools/partners/index';
$route['administration/partners/add-partners'] = 'laikipiaschools/partners/create_partner';
$route['administration/partners/read-partner/(:num)'] = 'laikipiaschools/partners/read_partner/$1';
$route['administration/edit_partner/(:num)'] = 'laikipiaschools/partners/edit/$1';
$route['administration/deactivate-partner/(:num)/(:num)'] = 'laikipiaschools/partners/deactivate_partner/$1/$2';
$route['administration/search-partners'] = 'laikipiaschools/partners/search_partners';
$route['administration/partners/close-search'] = 'laikipiaschools/partners/close_search';
$route['administration/export-partners'] = 'laikipiaschools/partners/export_partners';
$route['administration/partners/(:any)/(:any)/(:num)'] = 'laikipiaschools/partners/index/$1/$2/$3';
$route['administration/partners/(:any)/(:any)'] = 'laikipiaschools/partners/index/$1/$2';
$route['administration/partners/bulk-actions'] = 'laikipiaschools/partners/bulk_actions';
$route['administration/delete-partner/(:num)'] = 'laikipiaschools/partners/delete_partner/$1';



//categories

$route['administration/categories'] = 'laikipiaschools/categories/index';
$route['administration/categories/add-categories'] = 'laikipiaschools/categories/create_category';
$route['administration/categories/read-category/(:num)'] = 'laikipiaschools/categories/read_category/$1';
$route['administration/edit/(:num)'] = 'laikipiaschools/categories/edit/$1';
$route['administration/deactivate-category/(:num)/(:num)'] = 'laikipiaschools/categories/deactivate_category/$1/$2';
$route['administration/search-categories'] = 'laikipiaschools/categories/search_categories';
$route['administration/categories/close-search'] = 'laikipiaschools/categories/close_search';
$route['administration/export-categories'] = 'laikipiaschools/categories/export_transactions';
$route['administration/categories/(:any)/(:any)/(:num)'] = 'laikipiaschools/categories/index/$1/$2/$3';
$route['administration/categories/(:any)/(:any)'] = 'laikipiaschools/categories/index/$1/$2';
$route['administration/categories/bulk-actions'] = 'laikipiaschools/categories/bulk_actions';
$route['administration/delete-category/(:num)'] = 'laikipiaschools/categories/delete_category/$1';
/**
 * Schools
 */
$route['administration/update-school/(:num)'] = 'laikipiaschools/schools/edit_school/$1';
$route['administration/delete-school/(:num)'] = 'laikipiaschools/schools/delete_school/$1';
$route['administration/delete-school/(:num)'] = 'laikipiaschools/schools/delete_school/$1';

$route['administration/schools'] = 'laikipiaschools/schools/index';
// $route['administration/schools/add-schools'] = 'laikipiaschools/schools/add_school';
// $route['administration/add-schools'] = 'laikipiaschools/schools/add_school';
$route['administration/search-schools'] = 'laikipiaschools/schools/search_schools';
$route['administration/schools/close-search'] = 'laikipiaschools/schools/close_search';
$route['administration/export-schools'] = 'laikipiaschools/schools/export_schools';
$route['administration/schools/(:any)/(:any)/(:num)'] = 'laikipiaschools/schools/index/$1/$2/$3';
$route['administration/schools/(:any)/(:any)'] = 'laikipiaschools/schools/index/$1/$2';
$route['administration/schools/bulk-actions'] = 'laikipiaschools/schools/bulk_actions';
$route['administration/deactivate-school/(:num)/(:num)'] = 'laikipiaschools/schools/deactivate_school/$1/$2';
// $route['administration/activate-school/(:num)/(:num)'] = 'laikipiaschools/schools/activate_school/$1/$2';

$route['administration/edit-school/(:num)'] = 'laikipiaschools/schools/edit_school/$1';

$route['administration/schools/get-schools-details'] = 'laikipiaschools/webservice/get_school_details';

/**
 * Documents
 */
$route['administration/update-school/(:num)'] = 'laikipiaschools/documents/edit_school/$1';
$route['administration/documents'] = 'laikipiadocuments/documents/index';
$route['administration/add-documents'] = 'laikipiadocuments/documents/add_school';
$route['administration/search-documents'] = 'laikipiadocuments/documents/search_school';
$route['administration/close-search'] = 'laikipiadocuments/documents/close_search';
$route['administration/export-documents'] = 'laikipiadocuments/documents/export_transactions';
$route['administration/documents/(:any)/(:any)/(:num)'] = 'laikipiadocuments/documents/index/$1/$2/$3';
$route['administration/documents/(:any)/(:any)'] = 'laikipiadocuments/documents/index/$1/$2';
$route['administration/documents/bulk-actions'] = 'laikipiadocuments/documents/bulk_actions';

/**
 * Posts
 */
$route['administration/edit-post/(:num)'] = 'laikipiaschools/posts/edit_post/$1';
$route['administration/delete-post/(:num)'] = 'laikipiaschools/posts/delete_post/$1';
$route['administration/delete-post/(:num)'] = 'laikipiaschools/posts/delete_post/$1';

$route['administration/posts'] = 'laikipiaschools/posts/index';
$route['administration/add-posts'] = 'laikipiaschools/posts/add_post';
$route['administration/search-posts'] = 'laikipiaschools/posts/search_posts';
$route['administration/posts/close-search'] = 'laikipiaschools/posts/close_search';
$route['administration/export-posts'] = 'laikipiaschools/posts/export_posts';

$route['administration/posts/(:any)/(:any)/(:num)'] = 'laikipiaschools/posts/index/$1/$2/$3';
$route['administration/posts/(:any)/(:any)'] = 'laikipiaschools/posts/index/$1/$2';
$route['administration/post/bulk-actions'] = 'laikipiaschools/posts/bulk_actions';
$route['administration/deactivate-post/(:num)/(:num)'] = 'laikipiaschools/posts/deactivate_post/$1/$2';

$route['administration/schools/get-posts-details'] = 'laikipiaschools/webservice/get_post_details';
