<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* instamojo payment API v1 library for CodeIgniter
*
* @license Creative Commons Attribution 3.0 <http://creativecommons.org/licenses/by/3.0/>
* @version 1.0
* @author Rajeev bbqq <https://github.com/rajeevbbqq>
* @copyright Copyright (c) 2017, Rajeev bbqq
*/

/*
|--------------------------------------------------------------------------
| Mode
|--------------------------------------------------------------------------
|
| $config['mojo_mode'] = 'sandbox'; for testing
| $config['mojo_mode'] = 'live'   ; for production
|
*/


$config['mojo_mode']  = 'sandbox' ;
//$config['mojo_mode']  = 'live' ;


/*
|--------------------------------------------------------------------------
| API_KEY
|--------------------------------------------------------------------------
| API_KEY are different for test and production !
| $config['mojo_apikey'] = '650f7eed3d900273d6fafd635a';
|
*/

//$config['mojo_apikey'] = '701e131db90a1e79de36da79022f92ca' ;
//$config['mojo_apikey'] = 'test_150e4309539ca4d39929a75d9c9' ;
$config['mojo_apikey'] = 'test_150e4309539ca4d39929a75d9c9' ;


/*
|--------------------------------------------------------------------------
| AUTH_TOKEN
|--------------------------------------------------------------------------
| AUTH_TOKEN are different for test and production !
| $config['mojo_token'] = '650f7eed3d900273d6fafd635a';
|
*/


//$config['mojo_token']  = '1a09231936846bb10961a70af53bc0eb' ;
//$config['mojo_token']  = 'test_30f30a79139226c3edcab45caaa';
$config['mojo_token']  = 'test_30f30a79139226c3edcab45caaa' ;


/*
|--------------------------------------------------------------------------
| REDIRECT_URL
|--------------------------------------------------------------------------
| Set redirect url !
| $config['mojo_url'] = 'https://github.com/Instamojo/instamojo-php';
|
*/

$config['mojo_url'] = site_url('payment/payment_status/');


/* End of file instamojo.php */
/* Location: ./application/config/instamojo.php */
