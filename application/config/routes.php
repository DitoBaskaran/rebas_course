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

// ============================================================
// REST API ROUTES (v1)
// ============================================================

// --- Auth ---
$route['api/auth/login'] = 'api/api_auth/login';
$route['api/auth/register'] = 'api/api_auth/register';
$route['api/auth/google'] = 'api/api_auth/google';
$route['api/auth/forgot-password'] = 'api/api_auth/forgot_password';
$route['api/auth/reset-password'] = 'api/api_auth/reset_password';
$route['api/auth/me'] = 'api/api_auth/me';
$route['api/auth/logout'] = 'api/api_auth/logout';

// --- Courses ---
$route['api/courses/featured'] = 'api/api_courses/featured';
$route['api/courses/(:num)/lessons'] = 'api/api_courses/lessons/$1';
$route['api/courses/(:num)/reviews'] = 'api/api_reviews/index/$1';
$route['api/courses/(:num)/reviews/(:any)'] = 'api/api_reviews/$2/$1';
$route['api/courses/(:num)/progress'] = 'api/api_courses/progress/$1';
$route['api/courses/(:num)/enroll'] = 'api/api_courses/enroll/$1';
$route['api/courses/(:num)/discussions'] = 'api/api_discussions/index/$1';
$route['api/courses/(:num)/rating-summary'] = 'api/api_reviews/summary/$1';
$route['api/courses/(:num)'] = 'api/api_courses/show/$1';
$route['api/courses'] = 'api/api_courses/index';

// --- Categories ---
$route['api/categories/tree'] = 'api/api_categories/tree';
$route['api/categories/(:num)'] = 'api/api_categories/show/$1';
$route['api/categories'] = 'api/api_categories/index';

// --- Tags ---
$route['api/tags/(:num)'] = 'api/api_tags/show/$1';
$route['api/tags'] = 'api/api_tags/index';

// --- Lessons ---
$route['api/lessons/(:num)/complete'] = 'api/api_lessons/complete/$1';
$route['api/lessons/(:num)'] = 'api/api_lessons/show/$1';

// --- Quiz ---
$route['api/quizzes/(:num)/start'] = 'api/api_quiz/start/$1';
$route['api/quizzes/(:num)/submit'] = 'api/api_quiz/submit/$1';
$route['api/quizzes/(:num)/result/(:num)'] = 'api/api_quiz/result/$1/$2';
$route['api/quizzes/(:num)'] = 'api/api_quiz/show/$1';

// --- Assignments ---
$route['api/assignments/(:num)/submit'] = 'api/api_assignments/submit/$1';
$route['api/assignments/(:num)'] = 'api/api_assignments/show/$1';

// --- Certificates ---
$route['api/certificates/verify/(:any)'] = 'api/api_certificates/verify/$1';
$route['api/certificates'] = 'api/api_certificates/index';

// --- Seminars ---
$route['api/seminars/mine'] = 'api/api_seminars/mine';
$route['api/seminars/(:num)/register'] = 'api/api_seminars/register/$1';
$route['api/seminars/(:num)'] = 'api/api_seminars/show/$1';
$route['api/seminars'] = 'api/api_seminars/index';

// --- Discussions ---
$route['api/discussions/(:num)/reply'] = 'api/api_discussions/reply/$1';
$route['api/discussions/(:num)'] = 'api/api_discussions/show/$1';

// --- Mentoring ---
$route['api/mentoring/packages'] = 'api/api_mentoring/packages';
$route['api/mentoring/book'] = 'api/api_mentoring/book';
$route['api/mentoring/sessions'] = 'api/api_mentoring/sessions';
$route['api/mentoring/sessions/(:num)/cancel'] = 'api/api_mentoring/cancel/$1';
$route['api/mentoring/favorites'] = 'api/api_mentoring/favorites';
$route['api/mentoring/favorite/(:num)'] = 'api/api_mentoring/favorite/$1';
$route['api/mentors/(:num)/slots'] = 'api/api_mentoring/slots/$1';
$route['api/mentors/(:num)'] = 'api/api_mentoring/mentor_detail/$1';
$route['api/mentors'] = 'api/api_mentoring/mentors';

// --- Learning Paths ---
$route['api/learning-paths/mine'] = 'api/api_learning_paths/mine';
$route['api/learning-paths/(:num)/enroll'] = 'api/api_learning_paths/enroll/$1';
$route['api/learning-paths/(:num)'] = 'api/api_learning_paths/show/$1';
$route['api/learning-paths'] = 'api/api_learning_paths/index';

// --- Wishlist ---
$route['api/wishlist/check/(:num)'] = 'api/api_wishlist/check/$1';
$route['api/wishlist/(:num)'] = 'api/api_wishlist/toggle/$1';
$route['api/wishlist'] = 'api/api_wishlist/index';

// --- Subscriptions ---
$route['api/subscriptions/active'] = 'api/api_subscriptions/active';
$route['api/subscriptions'] = 'api/api_subscriptions/index';
$route['api/subscriptions/buy/(:num)'] = 'api/api_subscriptions/buy/$1';
$route['api/packages'] = 'api/api_subscriptions/packages';

// --- Users (Profile) ---
$route['api/users/me/enrollments'] = 'api/api_users/enrollments';
$route['api/users/me/transactions'] = 'api/api_users/transactions';
$route['api/users/me/avatar'] = 'api/api_users/upload_avatar';
$route['api/users/me/password'] = 'api/api_users/change_password';
$route['api/users/me'] = 'api/api_users/update_profile';

// --- Transactions ---
$route['api/transactions/validate-coupon'] = 'api/api_transactions/validate_coupon';
$route['api/transactions/(:any)/pay'] = 'api/api_transactions/pay/$1';
$route['api/transactions/(:any)'] = 'api/api_transactions/show/$1';
$route['api/transactions'] = 'api/api_transactions/index';

// --- Gamification ---
$route['api/users/me/points'] = 'api/api_gamification/points';
$route['api/users/me/point-history'] = 'api/api_gamification/point_history';
$route['api/users/me/badges'] = 'api/api_gamification/user_badges';
$route['api/badges'] = 'api/api_gamification/badges';

// --- Affiliate ---
$route['api/affiliate/stats'] = 'api/api_affiliate/stats';

// --- Checkout (Payment) ---
$route['api/checkout'] = 'api/api_checkout/create';
$route['api/checkout/apply-coupon'] = 'api/api_checkout/apply_coupon';
$route['api/checkout/midtrans/notification'] = 'api/api_checkout/midtrans_notification';
$route['api/checkout/pakasir/webhook'] = 'api/api_checkout/pakasir_webhook';
$route['api/checkout/(:any)/midtrans'] = 'api/api_checkout/midtrans/$1';
$route['api/checkout/(:any)/pay'] = 'api/api_checkout/pay/$1';
$route['api/checkout/(:any)'] = 'api/api_checkout/show/$1';

// --- Mentor Dashboard ---
$route['api/mentor/dashboard'] = 'api/api_mentor_dashboard/index';
$route['api/mentor/availability'] = 'api/api_mentor_dashboard/availability';
$route['api/mentor/add-slot'] = 'api/api_mentor_dashboard/add_slot';
$route['api/mentor/delete-slot/(:num)'] = 'api/api_mentor_dashboard/delete_slot/$1';
$route['api/mentor/sessions'] = 'api/api_mentor_dashboard/sessions';
$route['api/mentor/confirm-session/(:num)'] = 'api/api_mentor_dashboard/confirm_session/$1';
$route['api/mentor/reject-session/(:num)'] = 'api/api_mentor_dashboard/reject_session/$1';
$route['api/mentor/complete-session/(:num)'] = 'api/api_mentor_dashboard/complete_session/$1';
$route['api/mentor/rate-user/(:num)'] = 'api/api_mentor_dashboard/rate_user/$1';

// --- Contact ---
$route['api/contact'] = 'api/api_contact/send';
$route['api/contact/history'] = 'api/api_contact/history';

// --- Reputations ---
$route['api/users/(:num)/reputation'] = 'api/api_reputations/user_reputation/$1';
$route['api/users/(:num)/reviews'] = 'api/api_reputations/user_reviews/$1';

// --- Admin API ---
$route['api/admin/dashboard'] = 'api/api_admin/dashboard';
$route['api/admin/users/(:num)/status'] = 'api/api_admin/update_user_status/$1';
$route['api/admin/users/(:num)/role'] = 'api/api_admin/update_user_role/$1';
$route['api/admin/users'] = 'api/api_admin/users';
$route['api/admin/courses/(:num)'] = 'api/api_admin/update_course/$1';
$route['api/admin/courses'] = 'api/api_admin/courses';
$route['api/admin/transactions/(:any)/status'] = 'api/api_admin/update_transaction_status/$1';
$route['api/admin/transactions'] = 'api/api_admin/transactions';
$route['api/admin/categories/(:num)'] = 'api/api_admin/update_category/$1';
$route['api/admin/categories'] = 'api/api_admin/create_category';
$route['api/admin/courses/(:num)/lessons'] = 'api/api_admin/create_lesson/$1';
$route['api/admin/lessons/(:num)'] = 'api/api_admin/update_lesson/$1';
$route['api/admin/settings'] = 'api/api_admin/settings';

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

// Admin Package Routes
$route['admin/packages'] = 'admin/packages';
$route['admin/packages/create'] = 'admin/create_package';
$route['admin/packages/edit/(:num)'] = 'admin/edit_package/$1';
$route['admin/packages/delete/(:num)'] = 'admin/delete_package/$1';

// Payment gateway routes
$route['checkout/confirm/(:any)'] = 'checkout/confirm/$1';
$route['checkout/initiate/(:any)/(:num)'] = 'checkout/initiate/$1/$2';
$route['checkout/initiate/(:any)/(:num)/(:num)'] = 'checkout/initiate/$1/$2/$3';
$route['checkout/pay_cart/(:any)'] = 'checkout/pay_cart/$1';
$route['checkout/choose_method/(:any)'] = 'checkout/choose_method/$1';
$route['checkout/apply_coupon_cart/(:any)'] = 'checkout/apply_coupon_cart/$1';
$route['checkout/remove_coupon_cart/(:any)'] = 'checkout/remove_coupon_cart/$1';
$route['checkout/midtrans_snap/(:any)'] = 'checkout/midtrans_snap/$1';
$route['checkout/midtrans_callback'] = 'checkout/midtrans_callback';
$route['checkout/pay/(:any)'] = 'checkout/pay/$1';
$route['checkout/pakasir_check/(:any)'] = 'checkout/pakasir_check/$1';
$route['checkout/pakasir_webhook'] = 'checkout/pakasir_webhook';

// Referral redirect
$route['ref/(:any)'] = 'referral/index/$1';

// Course detail by slug (clean URLs — no numeric ID exposed)
$route['courses/mine'] = 'courses/mine';
$route['courses/detail/(:any)'] = 'courses/detail/$1';
$route['courses/buy/(:any)'] = 'courses/buy/$1';
$route['courses/review/(:any)'] = 'courses/review/$1';
$route['courses/complete_lesson/(:any)/(:any)'] = 'courses/complete_lesson/$1/$2';

// Seminar routes (use encoded IDs)
$route['seminars/mine'] = 'seminars/mine';
$route['seminars/detail/(:any)'] = 'seminars/detail/$1';
$route['seminars/register/(:any)'] = 'seminars/register/$1';

// Teacher Routes
$route['teacher'] = 'teacher/dashboard';
$route['teacher/dashboard'] = 'teacher/dashboard';
$route['teacher/courses'] = 'teacher/courses';
$route['teacher/create_course'] = 'teacher/create_course';
$route['teacher/edit_course/(:num)'] = 'teacher/edit_course/$1';
$route['teacher/delete_course/(:num)'] = 'teacher/delete_course/$1';
$route['teacher/lessons/(:num)'] = 'teacher/lessons/$1';
$route['teacher/create_lesson/(:num)'] = 'teacher/create_lesson/$1';
$route['teacher/edit_lesson/(:num)'] = 'teacher/edit_lesson/$1';
$route['teacher/delete_lesson/(:num)'] = 'teacher/delete_lesson/$1';
$route['teacher/seminars'] = 'teacher/seminars';
$route['teacher/create_seminar'] = 'teacher/create_seminar';
$route['teacher/edit_seminar/(:num)'] = 'teacher/edit_seminar/$1';
$route['teacher/delete_seminar/(:num)'] = 'teacher/delete_seminar/$1';
$route['teacher/submissions'] = 'teacher/submissions';
$route['teacher/grade_submission/(:num)'] = 'teacher/grade_submission/$1';
$route['teacher/return_submission/(:num)'] = 'teacher/return_submission/$1';
$route['teacher/assignments/(:num)'] = 'teacher/assignments/$1';
$route['teacher/create_assignment/(:num)'] = 'teacher/create_assignment/$1';
$route['teacher/delete_assignment/(:num)'] = 'teacher/delete_assignment/$1';
$route['teacher/grade_essays/(:num)'] = 'teacher/grade_essays/$1';
$route['teacher/save_essay_grade/(:num)/(:num)'] = 'teacher/save_essay_grade/$1/$2';

// Learning Paths
$route['learning_paths/mine'] = 'learning_paths/mine';
$route['learning_paths/enroll/(:any)'] = 'learning_paths/enroll/$1';

// Subscription Routes
$route['subscription'] = 'subscription/index';
$route['subscription/detail/(:any)'] = 'subscription/detail/$1';
$route['subscription/buy/(:any)'] = 'subscription/buy/$1';
$route['subscription/buy/(:any)/(:num)'] = 'subscription/buy/$1/$2';
$route['subscription/my'] = 'subscription/my';

// Forum (use encoded IDs)
$route['forum'] = 'forum/index';
$route['forum/index/(:any)'] = 'forum/index/$1';
$route['forum/view/(:any)'] = 'forum/view/$1';
$route['forum/create/(:any)'] = 'forum/create/$1';
$route['forum/reply/(:any)'] = 'forum/reply/$1';
$route['forum/mark_best/(:any)'] = 'forum/mark_best/$1';

// Wishlist
$route['wishlist'] = 'wishlist/index';
$route['wishlist/toggle/(:any)'] = 'wishlist/toggle/$1';

// Transactions (already UUID-based)
$route['transactions/history'] = 'transactions/history';
$route['transactions/history_data'] = 'transactions/history_data';
$route['transactions/detail/(:any)'] = 'transactions/detail/$1';

// Certificates (use code, not ID)
$route['certificate/view/(:any)'] = 'certificate/view/$1';
$route['certificate/verify/(:any)'] = 'certificate/verify/$1';
$route['certificate/download/(:any)'] = 'certificate/download/$1';
$route['certificate/my'] = 'certificate/my';

// Auth routes
$route['auth/google'] = 'auth/google';
$route['auth/google_callback'] = 'auth/google_callback';

// Admin documents
$route['admin/documents'] = 'admin/documents';
$route['admin/document/view/(:any)'] = 'admin/document_view/$1';

// Quiz & Assignments (use encoded IDs)
$route['quiz/start/(:any)'] = 'quiz/start/$1';
$route['quiz/take/(:any)'] = 'quiz/take/$1';
$route['quiz/submit/(:any)'] = 'quiz/submit/$1';
$route['quiz/result/(:any)'] = 'quiz/result/$1';
$route['quiz/admin_quizzes/(:num)'] = 'quiz/admin_quizzes/$1';
$route['assignment/view/(:any)'] = 'assignment/view/$1';
$route['assignment/submit/(:any)'] = 'assignment/submit/$1';

// Profile (no numeric ID — only own profile)
$route['profile'] = 'profile/index';
$route['profile/edit'] = 'profile/edit';

// Mentoring Routes (use encoded IDs)
$route['mentoring'] = 'mentoring/index';
$route['mentoring/packages'] = 'mentoring/packages';
$route['mentoring/buy-package/(:any)'] = 'mentoring/buy_package/$1';
$route['mentoring/detail/(:any)'] = 'mentoring/detail/$1';
$route['mentoring/book/(:any)'] = 'mentoring/book/$1';
$route['mentoring/confirm-booking'] = 'mentoring/confirm_booking';
$route['mentoring/my-sessions'] = 'mentoring/my_sessions';
$route['mentoring/cancel/(:any)'] = 'mentoring/cancel/$1';
$route['mentoring/approve-booking/(:any)'] = 'mentoring/approve_booking/$1';
$route['mentoring/review/(:any)'] = 'mentoring/review/$1';
$route['mentoring/toggle-favorite/(:any)'] = 'mentoring/toggle_favorite/$1';
$route['mentoring/slots/(:any)'] = 'mentoring/get_slots_json/$1';

// Mentor Dashboard Routes (use encoded IDs)
$route['mentor/create-profile'] = 'mentor_dashboard/create_profile';
$route['mentor'] = 'mentor_dashboard/index';
$route['mentor/availability'] = 'mentor_dashboard/availability';
$route['mentor/add-slot'] = 'mentor_dashboard/add_slot';
$route['mentor/delete-slot/(:any)'] = 'mentor_dashboard/delete_slot/$1';
$route['mentor/sessions'] = 'mentor_dashboard/sessions';
$route['mentor/confirm-session/(:any)'] = 'mentor_dashboard/confirm_session/$1';
$route['mentor/reject-session/(:any)'] = 'mentor_dashboard/reject_session/$1';
$route['mentor/complete-session/(:any)'] = 'mentor_dashboard/complete_session/$1';
$route['mentor/rate-user/(:any)'] = 'mentor_dashboard/rate_user/$1';
$route['mentor/update-schedule/(:num)'] = 'mentor_dashboard/update_schedule/$1';
