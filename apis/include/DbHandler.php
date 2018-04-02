<?php

class DbHandler {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        //require_once dirname(__FILE__) . '/class.phpmailer.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    function get_application_id($application_code) {
        $query = "SELECT id from applications WHERE application_code=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $application_code);
        if ($stmt->execute()) {
            $stmt->bind_result($application_id);
            $stmt->store_result();
            $stmt->fetch();
            if ($stmt->num_rows > 0) {
                $stmt->close();
                return $application_id;
            }
        } else {
            return array();
        }
    }

    function get_counts($table, $cond, $fieldValue) {
        $q = "SELECT id from $table WHERE $cond";
        $stmt = $this->conn->prepare($q);
        $stmt->bind_param("s", $fieldValue);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows;
    }

    public function GetRecordByID($id, $table, $SelectArr = array()) {
        if (!empty($SelectArr)) {
            $select = implode(",", $SelectArr);
        } else {
            $select = "*";
        }
        $stmt = $this->conn->prepare("SELECT $select FROM $table WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $records = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $records;
        } else {
            return NULL;
        }
    }

    public function GetRecordByField($form_data, $application_id, $SelectArr = array()) {
        if (!empty($form_data)) {
            $select = !empty($SelectArr) ? implode(",", $SelectArr) : "*";
            $table = $form_data['table_name'];
            $name = $form_data['name'];
            $data_type = $form_data['data_type'];
            $value = $form_data['value'];
            $stmt = $this->conn->prepare("SELECT $select FROM $table WHERE application_id=$application_id and $name = ?");
            $stmt->bind_param("$data_type", $value);
            if ($stmt->execute()) {
                $records = $stmt->get_result()->fetch_assoc();
                $stmt->close();
                return $records;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    function UpdateLoginDetails($device_id, $device_type, $source_type, $id) {
        $last_login = date("Y-m-d H:i:s");
        $is_online = 1;
        $stmt = $this->conn->prepare("UPDATE users set device_id = ?, device_type = ?, source_type = ?, last_login = ?, is_online = ? where id = ?");
        $stmt->bind_param("ssssii", $device_id, $device_type, $source_type, $last_login, $is_online, $id);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function register($Data, $table, $application_id) {
        //print_r($Data);
        $field_name = implode(",", $Data[$table]['names']);
        $data_placeholder = implode(",", $Data[$table]['data_placeholder']);
        $data_types = implode("", $Data[$table]['data_types']);
        $values_arr = $Data[$table]['values'];
        $q = "INSERT INTO $table ($field_name) VALUES($data_placeholder)";
        $stmt = $this->conn->prepare($q);
        $bind_names[] = $data_types;
        for ($i = 0; $i < count($Data[$table]['names']); $i++) {
            $bind_name = $Data[$table]['names'][$i];
            $$bind_name = $Data[$table]['values'][$i];
            $bind_names[] = &$$bind_name;
        }
        call_user_func_array(array($stmt, 'bind_param'), $bind_names);
        $result = $stmt->execute();
        $insert_id = $stmt->insert_id;
        $stmt->close();
        return $this->GetRecordByID($insert_id, $table, $SelectArr = array());
    }

    public function send_otp($mobile, $application_id) {
        $q1 = "delete from otps where mobile_number='$mobile'";
        $re1 = mysqli_query($this->conn, $q1);
        $ctime = date("Y-m-d H:i:s ", time());
        $expire_time = date('Y-m-d H:i:s', strtotime('+15 minutes', strtotime(date("Y-m-d H:i:s ", time()))));
        $otp = rand(100000, 999999);

        $stmt = $this->conn->prepare("INSERT INTO otps (mobile, otp, created_on, expired_on,application_id) VALUES(?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $mobile, $otp, $ctime, $expire_time, $application_id);
        $result = $stmt->execute();
        $insert_id = $stmt->insert_id;
        $stmt->close();
        if ($insert_id) {
            $phone_no = $mobile;
            $msg = "Your Verification Code is " . $otp . ". This code is applicable for 15 minutes only";
            $this->send_msg($phone_no, $msg, 1);
            return "SUCCESS";
        }
    }

    function get_listing($table, $select_fields = array(), $cond = null, $orders = null, $offset = null, $limit = null,$joins=array()) {
        $q1 = "SELECT ";
        if (!empty($select_fields)) {
            $q1.=" " . implode(",", $select_fields);
        } else {
            $q1 .= " " . $table . ".* ";
        }
        $q1 .= " FROM $table ";
        if(!empty($joins)){
            foreach($joins as $index=>$jn){
               $q1 .= " ".$jn; 
            }
        }
        
        if ($cond) {
            $q1 .= " where " . $cond;
        }
        if ($orders) {
            $q1.=" order by " . $orders;
        }
        if ($offset && $limit) {
            $q1.=" LIMIT $offset,$limit";
        }
        if (($offset == "" || $offset == null) && $limit) {
            $q1.=" LIMIT $limit";
        }
 
        $re1 = mysqli_query($this->conn, $q1);
        if (mysqli_num_rows($re1) > 0) {
            $i = 0;
            while ($array = mysqli_fetch_array($re1)) {
                foreach ($array as $key => $value) {
                    if (is_numeric($key))
                        unset($array[$key]);
                }
                $return[$i] = $array;
                $i++;
            }
            return $return;
        } else {
            return false;
        }
    }

    public function sendnotification_android($message, $device_token, $booking_id = null) {

        $i = 0;
        $registrationIds = $device_token;
        $registrationIds = array($registrationIds);
        $title = 'Hi!';
        $msg = array(
            'message' => $message,
            'title' => $title,
            'booking_id' => $booking_id,
            //'tickerText' => $message,
            'vibrate' => 1,
            'sound' => 1
        );

        $fields = array(
            'registration_ids' => $registrationIds,
            'data' => $msg
        );

        $headers = array(
            'Authorization: key=AIzaSyAqZ5q9r0f16irv5LmnKkFSZLyOL6iN9Zs',
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        // let's check the response
        $data = json_decode($result);
        //print_r($data);
        if ($data->success == 1) {
            $i = 1;
        } else if ($data->failure == 1) {
            //$return = 'FAILURE';
        }
        // return $return;

        if ($i == 1) {
            return 'SUCCESS';
            exit;
        } else {
            return 'FAILURE';
            exit;
        }
    }

    public function sendnotification_iphone($message, $device_token, $booking_id = null) {

        //echo $user['devicetoken'];die;
        if (strlen($device_token) > 62) {
            $deviceToken = $device_token;
            //$deviceToken='dfd4c47ff22e518fa08a5274d8095af82aeb52104ffae370325110ac0d702b61';
            $ctx = stream_context_create();
            stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
            stream_context_set_option($ctx, 'ssl', 'passphrase', '1234');
            // Open a connection to the APNS server
            $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

            if (!$fp)
                exit("Failed to connect: $err $errstr" . PHP_EOL);

            // echo 'Connected to APNS' . PHP_EOL;
            // Create the payload body
            $body['aps'] = array(
                'alert' => 'Hi',
                'data' => $message,
                'booking_id' => $booking_id,
                'sound' => 'default',
            );
//pr($body);die;
            // Encode the payload as JSON
            $payload = json_encode($body);

            // Build the binary notification
            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

            // Send it to the server
            $result = fwrite($fp, $msg, strlen($msg)); //pr($result);die;
            // Close the connection to the server
            fclose($fp);

            if ($result) {
                return 'SUCCESS';
            } else {
                return 'FAILURE';
            }
        }
    }

    public function SendPushNotification($deviceToken = '', $API_KEY = '', $msg) {


        $fields = array();
        //$API_KEY = 'AIzaSyD6qtUxHZfVIwHkzry0Rjuxs1P4-PFj0So';			
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' => array($deviceToken),
            'data' => array("message" => $msg)
        );
        $fields = json_encode($fields);

        $headers = array('Authorization: key=' . $API_KEY, 'Content-Type: application/json');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec($ch);
        //print_r($result); exit;
        curl_close($ch);

        //return $result;
        return true;
    }

    public function send_msg($phone_no, $msg, $no_response = '') {
        //return true;
        //echo $phone_no; exit;
        if ($phone_no) {
            $msg = urlencode($msg);
            $url = "http://www.onextelbulksms.in/shn/api/pushsms.php?usr=621708&key=010Bs0BM003kiGZBElNV40iLv9JhqD&sndr=ALERTS&ph=" . $phone_no . "&text=" . $msg . "&rpt=1";
            //echo $url; exit; 

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, true);
            $data = curl_exec($ch);
            if ($no_response == 1) {
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            }
            //print_r($data);exit;
            if ($data)
                return true;
            else
                return false;
        }else {
            return false;
        }
    }

    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function SendInventoryPushNotification($deviceToken = '', $API_KEY = '', $message) {
        $fields = array();
        //$API_KEY = 'AIzaSyD6qtUxHZfVIwHkzry0Rjuxs1P4-PFj0So';			
        $url = 'https://fcm.googleapis.com/fcm/send';
        $msg = array(
            'message' => $message,
            'title' => 'inventory'
        );
        $registrationIds = array($deviceToken);
        $fields = array(
            'registration_ids' => $registrationIds,
            'data' => $msg
        );
        $fields = json_encode($fields);
        $headers = array('Authorization: key=' . $API_KEY, 'Content-Type: application/json');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec($ch);
        //print_r($result); exit;
        curl_close($ch);
        return $result;
    }

}
?>
	 


