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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller']    = 'store/index';
$route['translate_uri_dashes']  = TRUE;
$route['admin']                 = 'admin/users/login';
$route['admin/(.+)']            = 'admin/$1';
$route['logout']            = 'store/logout';

$route['404_override'] 			= ''; //'error404';
 $route['checkout']='store/checkout';
 $route['(:any)/(:num)']         = 'store/category/$1/$2';
$route['categories']='store/categories';
$route['revieworder']='store/review_order';
$route['login'] = 'store/login';
$route['register']='store/register';
$route['myorders']='accounts/myorders';
$route['wishlists']='accounts/wishlists';
$route['member-tree']='accounts/member_tree';
$route['changepassword']='accounts/changepassword';
$route['affiliate']='accounts/affiliate';
$route['refer-earn']='accounts/refer_earn';
$route['trans-history']='accounts/trans_history';
$route['gift-reward']='accounts/gift_reward';
$route['products/(:any)/(:num)']= 'store/product_details/$1/$2';
//$route['allproducts/(:num)']= 'store/allproduct/$1';
$route['about'] 			= 'store/page/about-us';
$route['privacy-policy'] 			= 'store/page/privacy-policy';
$route['terms-and-conditions'] 			= 'store/page/terms-of-use';
$route['faqs'] 			= 'store/page/faq';
$route['members-tree'] = 'accounts/member_tree';
$route['members-tree/(:num)'] = 'accounts/member_tree/$1';
$route['featured-products'] = 'store/featured_product';
//$route['categories/(:num)'] = 'store/category/$1';
$route['contact'] = 'store/contact';
$route['forgot-password'] = 'store/forgot_password';
$route['verification'] = 'store/verify';

