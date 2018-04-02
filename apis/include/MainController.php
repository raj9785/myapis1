<?php

require_once dirname(__FILE__) . '/DbHandler.php';
$db = new DbHandler();

class MainController {

    public $UserUniques = array(
        'mobile' => array('code' => 'MOBILE_EXISTS', 'message' => 'Mobile already available'),
        'email' => array('code' => 'EMAIL_EXISTS', 'message' => 'Email already available'),
        'username' => array('code' => 'USERNAME_EXISTS', 'message' => 'Email already available'),
    );
    public $unique_fields = array(
        "WRONG_MOBILE" => WRONG_MOBILE,
        "WRONG_EMAIL" => WRONG_EMAIL,
        "WRONG_USER_NAME" => WRONG_MOBILE,
    );

    function response($request_type, $status = 0, $error_code, $response_data = array(), $msg, $error = false) {
        $returnArr['request_type'] = $request_type;
        $returnArr['status'] = $status;
        $returnArr['error'] = $error;
        $returnArr['error_code'] = $error_code;
        $returnArr['data'] = $response_data;
        $returnArr['message'] = $msg;
        return $returnArr;
    }

    function check_uniques($form_data, $application_id) {
        global $db;
        foreach ($form_data as $FData) {
            if (array_key_exists($FData['name'], $this->UserUniques)) {
                $field = $FData['name'];
                $fieldValue = $FData['value'];
                $table = "users";
                $cond = "application_id=$application_id and $field = ?";
                if ($db->get_counts($table, $cond, $fieldValue) > 0) {
                    return $this->UserUniques[$FData['name']];
                }
            }
        }
        return array();
    }

    function insert_table_array($form_data, $post_data, $request_type = '', $application_id = '', $table = '') {
        $returnArr = array();
        $i = 0;
        if ($request_type == "RegisterForm") {
            $returnArr[$table]['names'][$i] = 'device_type';
            $returnArr[$table]['values'][$i] = $post_data['device_type'];
            $returnArr[$table]['data_types'][$i] = 's';
            $returnArr[$table]['data_placeholder'][$i] = '?';
            $i++;

            $returnArr[$table]['names'][$i] = 'source_type';
            $returnArr[$table]['values'][$i] = $post_data['source_type'];
            $returnArr[$table]['data_types'][$i] = 's';
            $returnArr[$table]['data_placeholder'][$i] = '?';
            $i++;

            $returnArr[$table]['names'][$i] = 'device_id';
            $returnArr[$table]['values'][$i] = $post_data['device_id'];
            $returnArr[$table]['data_types'][$i] = 's';
            $returnArr[$table]['data_placeholder'][$i] = '?';
            $i++;
            $returnArr[$table]['names'][$i] = 'application_id';
            $returnArr[$table]['values'][$i] = $application_id;
            $returnArr[$table]['data_types'][$i] = 'i';
            $returnArr[$table]['data_placeholder'][$i] = '?';
            $i++;
            if ($post_data['social_login_id']) {
                $returnArr[$table]['names'][$i] = 'social_login_id';
                $returnArr[$table]['values'][$i] = $post_data['social_login_id'];
                $returnArr[$table]['data_types'][$i] = 's';
                $returnArr[$table]['data_placeholder'][$i] = '?';
                $i++;
            }
        }


        $created_on = date("Y-m-d H:i:s");
        $returnArr[$table]['names'][$i] = 'created_on';
        $returnArr[$table]['values'][$i] = $created_on;
        $returnArr[$table]['data_types'][$i] = 's';
        $returnArr[$table]['data_placeholder'][$i] = '?';
        $i++;

        if ($request_type == "OtpSend") {
            $returnArr[$table]['names'][$i] = 'application_id';
            $returnArr[$table]['values'][$i] = $application_id;
            $returnArr[$table]['data_types'][$i] = 'i';
            $returnArr[$table]['data_placeholder'][$i] = '?';
            $i++;
            $returnArr[$table]['names'][$i] = 'otp';
            $returnArr[$table]['values'][$i] = rand(1000, 9999);
            $returnArr[$table]['data_types'][$i] = 's';
            $returnArr[$table]['data_placeholder'][$i] = '?';
            $i++;
            $expire_time = date('Y-m-d H:i:s', strtotime('+15 minutes', strtotime($created_on)));
            $returnArr[$table]['names'][$i] = 'expired_on';
            $returnArr[$table]['values'][$i] = $expire_time;
            $returnArr[$table]['data_types'][$i] = 's';
            $returnArr[$table]['data_placeholder'][$i] = '?';
            $i++;
        }

        foreach ($form_data as $FData) {
            if ($FData['name'] == 'password') {
                $HasReturn = $this->hash_generator($FData['value']);
                $returnArr[$FData['table_name']]['names'][$i] = $FData['name'];
                $returnArr[$FData['table_name']]['values'][$i] = $HasReturn['password'];
                $returnArr[$FData['table_name']]['data_types'][$i] = $FData['data_type'];
                $returnArr[$FData['table_name']]['data_placeholder'][$i] = '?';
                $i++;

                $returnArr[$FData['table_name']]['names'][$i] = 'user_salt';
                $returnArr[$FData['table_name']]['values'][$i] = $HasReturn['random_salt'];
                $returnArr[$FData['table_name']]['data_types'][$i] = 's';
                $returnArr[$FData['table_name']]['data_placeholder'][$i] = '?';
                $i++;
            } else {
                if ($FData['value']) {
                    $returnArr[$FData['table_name']]['names'][$i] = $FData['name'];
                    $returnArr[$FData['table_name']]['values'][$i] = $FData['value'];
                    $returnArr[$FData['table_name']]['data_types'][$i] = $FData['data_type'];
                    $returnArr[$FData['table_name']]['data_placeholder'][$i] = '?';
                    $i++;
                }
            }
        }
        return $returnArr;
    }

    function check_valid_application($application_code) {
        $db = new DbHandler();
        if ($application_id = $db->get_application_id($application_code)) {
            return $application_id;
        } else {
            return false;
        }
    }

    function login($post_data, $application_id) {
        $db = new DbHandler();
        $request_type = @$post_data['request_type'];
        $status = 0;
        $response_data = array();
        $error_code = "";
        $msg = "";
        if (!empty($post_data)) {

            $form_data = $post_data['json_data'];
            if ($request_type == "LoginForm") {
                $res = $db->GetRecordByField(@$form_data[0], $application_id);
                if (!empty($res)) {
                    //print_r($res);
                    //exit;
                    $password = hash('sha512', @$form_data[1]['value'] . $res['user_salt']);
                    if ($password == $res['password']) {
                        if ($res['is_verified'] == 1) {
                            if ($res['status'] == 1) {
                                $device_id = $post_data['device_id'];
                                $device_type = $post_data['device_type'];
                                $source_type = $post_data['source_type'];
                                if ($db->UpdateLoginDetails($device_id, $device_type, $source_type, $res['id'])) {
                                    $response_data = $res;
                                    $status = 1;
                                    $msg = "Login successfully";
                                } else {
                                    $error_code = ACTION_FAILED;
                                    $msg = "Action failed";
                                }
                            } else {
                                $error_code = ACCOUNT_DEACTIVATED;
                                $msg = "Your account is deactivated by admin";
                            }
                        } else {
                            $error_code = ACCOUNT_NOT_VERIFIED;
                            $msg = "Please verify your " . @$form_data[0]['name'];
                        }
                    } else {
                        $error_code = WRONG_PASSWORD;
                        $msg = "Wrong " . @$form_data[1]['name'];
                    }
                } else {
                    $error_code = @$this->unique_fields["WRONG_" . strtoupper(@$form_data[0]['name'])];
                    $msg = "Please enter correct " . @$form_data[0]['name'];
                }
            } else if ($request_type == "RegisterForm") {
                if (!empty($form_data)) {
                    $CheckResponse = $this->check_uniques($form_data, $application_id);
                    if (!empty($CheckResponse)) {
                        $error_code = $CheckResponse['code'];
                        $msg = $CheckResponse['message'];
                    } else {
                        $Data = $this->insert_table_array($form_data, $post_data, $request_type, $application_id, 'users');
                        $res = $db->register($Data, 'users', $application_id);
                        $response_data = $res;
                        $status = 1;
                        $msg = "Registered successfully";
                    }
                } else {
                    $error_code = NO_DATA_POSTED;
                    $msg = "No Data Posted";
                }
            }
        } else {
            $error_code = NO_DATA_POSTED;
            $msg = "No Data Posted";
        }

        return $this->response($request_type, $status, $error_code, $response_data, $msg);
    }

    function send_otp($post_data, $application_id) {
        $error_code = "";
        $db = new DbHandler();
        $request_type = @$post_data['request_type'];
        $response_data = array();
        $mobpattrn = "/^[789][0-9]{9}$/";
        $form_data = @$post_data['json_data'];
        $mobile = @$form_data[0]['value'];
        if (preg_match($mobpattrn, $mobile)) {
            //$Data = $this->insert_table_array($form_data, $post_data, $request_type, $application_id, 'otps');
            $resp = $db->send_otp($mobile, $application_id);
            if ($resp == "SUCCESS") {
                $status = 1;
                $response_data = array('mobile' => $mobile);
                $msg = "OTP sent";
            }
            // print_r($Data);
            //exit;
        } else {
            $error_code = INVALID_MOBILE;
            $msg = "Invalid Mobile Number";
            $status = 0;
        }
        return $this->response($request_type, $status, $error_code, $response_data, $msg);
    }

    function hash_generator($password) {
        $random_salt = SALT; //hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $password = hash('sha512', $password . $random_salt); // hash the password with the unique salt.
        return array('random_salt' => $random_salt, 'password' => $password);
    }

    function get_request_information($post_data, $application_id) {
        $retArr = array();
        $request_type = @$post_data['request_type'];
        if ($request_type == "CategoryList") {
            $retArr['table'] = 'categories';
            $retArr['select_fields'] = array("categories.id", "categories.name", "categories.created_on");
            $retArr['conditions'] = "application_id = '$application_id'";
            $retArr['joins'] = array();
        } else if ($request_type == "SubCategoryList") {
            $retArr['table'] = 'sub_categories';
            $retArr['select_fields'] = array("sub_categories.id", "sub_categories.name", "sub_categories.created_on", "categories.name as parent_name");
            $conditions = "sub_categories.application_id = '$application_id'";
            $json_data = $post_data['json_data'];
            if (!empty($json_data)) {
                foreach ($json_data as $fdata) {
                    if ($fdata['name'] != "id") {
                        $conditions .= " and " . $fdata['name'] . " = " . $fdata['value'];
                    }
                }
            }
            $retArr['conditions'] = $conditions;
            $joins[0] = " inner join categories on categories.id=sub_categories.category_id";
            $retArr['joins'] = $joins;
        }
        return $retArr;
    }

    //put your code here
    function get_listing($post_data, $application_id) {
        $db = new DbHandler();
        $request_type = @$post_data['request_type'];
        $status = 0;
        $response_data = array();
        $error_code = "";
        $errors_msg = "";
        if (!empty($post_data)) {
            $application_code = @$post_data['application_code'];
            $retArr = $this->get_request_information($post_data, $application_id);
            $table = $retArr['table'];
            $select_fields = $retArr['select_fields'];
            $cond = $retArr['conditions'];
            $joins = $retArr['joins'];
            if ($arr = $db->get_listing($table, $select_fields, $cond, '', '', '', $joins)) {
                $status = 1;
                $response_data = $arr;
                $errors_msg = "Listing";
            } else {
                $error_code = NO_RECORDS;
                $errors_msg = "No record available";
            }
        } else {
            $error_code = NO_DATA_POSTED;
            $errors_msg = "No Data Posted";
        }


        return $this->response($request_type, $status, $error_code, $response_data, $errors_msg);
    }

}
