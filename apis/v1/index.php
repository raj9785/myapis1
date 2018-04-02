<?php

//error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('gd.jpeg_ignore_warning', true);

//require_once '../include/DbHandler.php';
require_once '../include/MainController.php';
require_once '../include/PassHash.php';
require_once '../include/config.php';
require '../lib/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// User id from db - Global Variable
$user_id = NULL;
$application_id = NULL;
date_default_timezone_set('Asia/Kolkata');
$validate_array = array(
    'email' => array(
        "validate" => FILTER_VALIDATE_EMAIL,
        'error_code' => INVALID_EMAIL,
        'message' => 'Email address is not valid'
    )
);

$apis_handler = array(
    'LoginForm' => 'login',
    'RegisterForm' => 'login',
    'OtpSend' => 'send_otp',
    'CategoryList' => 'get_listing',
    'SubCategoryList' => 'get_listing'
);



/**
 * Api Calls
 * url - /api_calls
 * Full_url-/apis/v1/api_calls
 * method - POST
 * params - 
 */
$app->post('/api_calls', 'authenticate', function() use ($app) {
    global $apis_handler, $application_id;
    $post_data = $app->request->getBody();
    //print_r($post_data);exit;
    $response = array();
    $mainct = new MainController();
    $json_data = $post_data;
    $post_data = json_decode($post_data, true);
    $form_data = @$post_data['json_data'];
    $requiredParams = array();
    $request_type = @$post_data['request_type'];
    if (!empty($form_data)) {
       
        foreach ($form_data as $data) {
            if (@$data['required'] == 1) {
                if ($data['value'] == "" || $data['value'] == null) {
                    $requiredParams[] = $data['name'];
                } else {
                    validateFields($data['name'], $data['value'], $request_type);
                }
            }
        }
    }
    if (!empty($requiredParams)) {
        verifyRequiredParams($requiredParams, $request_type);
    }
    if (isset($apis_handler[$request_type])) {
        $res = $mainct->{$apis_handler[$request_type]}($post_data, $application_id);
    }else{
        $res['request_type'] = $request_type;
        $res['status'] = 0;
        $res['error'] = true;
        $res['error_code'] = "";
        $res['data'] = array();
        $res['message'] = "Wrong Function Calls";
    }
    echoRespnse(200, $res);
});



/**
 * Api
 * url - /taxi_booking_api
 * Full_url-/lead_apis/v1/search
 * method - POST
 * params - 
 */
//$app->post('/get_listing', function() use ($app) {
//    $post_data = $app->request->getBody();
//    //print_r($post_data);exit;
//    $response = array();
//    $mainct = new MainController();
//
//    $res = $mainct->get_listing($post_data);
//    echoRespnse(200, $res);
//});

/**
 * Verifying required params posted or not
 */
function verifyRequiredParams($required_fields, $request_type) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
// Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
// Required field(s) are missing or empty
// echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error_code"] = REQUIRED_FIELDS;
        $response["request_type"] = $request_type;
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * Validating fields
 */
function validateFields($field, $value, $request_type) {
    global $validate_array;
    $app = \Slim\Slim::getInstance();
    if (array_key_exists($field, $validate_array)) {
        //echo $validate_array[$field]['validate'];exit;
        if (!filter_var($value, $validate_array[$field]['validate'])) {
            $response["error_code"] = $validate_array[$field]['error_code'];
            $response["error"] = true;
            $response["request_type"] = $request_type;
            $response["message"] = $validate_array[$field]['message'];
            echoRespnse(400, $response);
            $app->stop();
        }
    }
}

/**
 * Echoing json response to client
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
// Http response code
    $app->status($status_code);

// setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

/**
 * Adding Middle Layer to authenticate every request
 * Checking if the request has valid api key in the 'Authorization' header
 */
function authenticate(\Slim\Route $route) {
    $app = \Slim\Slim::getInstance();
    $realm = 'Protected APIS';

    $req = $app->request();
    $post_data = $app->request->getBody();
    $res = $app->response();

    $post_data = json_decode($post_data, true);
    $application_code = @$post_data['application_code'];

    $username = $req->headers('PHP_AUTH_USER');
    $password = $req->headers('PHP_AUTH_PW');

    if ($application_code) {
        $mainct = new MainController();
        if ($app_id = $mainct->check_valid_application($application_code)) {
            if (!empty($app_id)) {
                global $application_id;
                $application_id = $app_id;
                return true;
            } else {
                $res->header('WWW-Authenticate', sprintf('Basic realm="%s"', $realm));
                $res = $app->response();
                $res->status(401);
                $app->stop();
            }
        } else {
            $res->header('WWW-Authenticate', sprintf('Basic realm="%s"', $realm));
            $res = $app->response();
            $res->status(401);
            $app->stop();
        }
    } else {
        $res->header('WWW-Authenticate', sprintf('Basic realm="%s"', $realm));
        $res = $app->response();
        $res->status(401);
        $app->stop();
    }
}

$app->run();
?>
