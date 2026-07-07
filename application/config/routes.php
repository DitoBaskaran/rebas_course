<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Admin settings routes
$route['admin/settings/(:any)'] = 'admin/settings/$1';
$route['admin/settings'] = 'admin/settings/general';

// Marketing / Pages routes
$route['sitemap\.xml'] = 'sitemap/index';
$route['about'] = 'pages/about';
$route['contact'] = 'pages/contact';
$route['contact/send'] = 'pages/contact_send';
$route['faq'] = 'pages/faq';
$route['pricing'] = 'pages/pricing';
$route['terms'] = 'pages/terms';
$route['privacy'] = 'pages/privacy';
$route['blog'] = 'courses?content_type=article';

// Auth routes
$route['auth/forgot_password'] = 'auth/forgot_password';
$route['auth/reset_password/(:any)'] = 'auth/reset_password/$1';

// Affiliate routes
$route['affiliate'] = 'affiliate/index';

// Wishlist routes
$route['wishlist'] = 'wishlist/index';
$route['wishlist/toggle/(:num)'] = 'wishlist/toggle/$1';

// Quiz / Essay grading routes
$route['admin/grade_essays/(:num)'] = 'admin/grade_essays/$1';
$route['admin/save_essay_grade/(:num)/(:num)'] = 'admin/save_essay_grade/$1/$2';

// Payment gateway routes
$route['checkout/midtrans_snap/(:num)'] = 'checkout/midtrans_snap/$1';
$route['checkout/midtrans_callback'] = 'checkout/midtrans_callback';
$route['checkout/pakasir/(:any)'] = 'checkout/pakasir_pay/$1';
$route['checkout/pakasir_check/(:num)'] = 'checkout/pakasir_check/$1';
$route['checkout/pakasir_webhook'] = 'checkout/pakasir_webhook';

// Referral redirect
$route['ref/(:any)'] = 'referral/index/$1';

// Course detail by slug (clean URLs)
$route['courses/detail/(:num)'] = 'courses/detail/$1';
$route['courses/detail/(:any)'] = 'courses/detail_slug/$1';

// Allow slug-based course routes
$route['courses/buy/(:any)'] = 'courses/buy/$1';
$route['courses/review/(:any)'] = 'courses/review/$1';
$route['courses/complete_lesson/(:any)/(:num)'] = 'courses/complete_lesson/$1/$2';
$route['forum/index/(:any)'] = 'forum/index/$1';
$route['forum/create/(:any)'] = 'forum/create/$1';
$route['wishlist/toggle/(:any)'] = 'wishlist/toggle/$1';
