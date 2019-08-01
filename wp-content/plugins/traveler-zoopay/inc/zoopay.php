<?php
/**
 * Created by PhpStorm.
 * User: Kyaw Wanna
 * Date: 12/15/2015
 * Time: 3:19 PM
 */


if (!class_exists('ST_Zoopay_Payment_Gateway')) {
    class ST_Zoopay_Payment_Gateway extends STAbstactPaymentGateway
    {
        static private $_ints;
        private $default_status = true;
        private $_gatewayObject = null;
        private $_gateway_id = 'st_zoopay';

        private $url;
        private $userId;
        private $password;
        private $secure_secret;

        function __construct()
        {
            add_filter('st_payment_gateway_st_zoopay_name', array($this, 'get_name'));
            try {
                $this->_gatewayObject = '';

            } catch (Exception $e) {
                $this->default_status = false;
            }
        }


        function get_option_fields()
        {
            return array(
                array(
                    'id' => 'zoopay_creditcard_url',
                    'label' => __('URL', 'traveler-zoopay'),
                    'type' => 'text',
                    'section' => 'option_pmgateway',
                    'desc' => esc_html__( "Information connect or Environment test. Url for real: https://test.oppwa.com/v1/checkouts Url for test: ttps://test.oppwa.com/v1/checkouts", 'traveler-zoopay' ),
                    'condition' => 'pm_gway_st_zoopay_enable:is(on)'
                ),
                array(
                    'id' => 'zoopay_creditcard_userId',
                    'label' => __('Merchant ID', 'traveler-zoopay'),
                    'type' => 'text',
                    'section' => 'option_pmgateway',
                    'desc' => __('Merchant ID', 'traveler-zoopay'),
                    'condition' => 'pm_gway_st_zoopay_enable:is(on)'
                ),
                array(
                    'id' => 'zoopay_creditcard_password',
                    'label' => __('Merchant Access Code', 'traveler-zoopay'),
                    'type' => 'text',
                    'section' => 'option_pmgateway',
                    'desc' => __('Merchant Access Code', 'traveler-zoopay'),
                    'condition' => 'pm_gway_st_zoopay_enable:is(on)'
                ),
                array(
                    'id' => 'zoopay_creditcard_secure_secret',
                    'label' => __('Security Secret', 'traveler-zoopay'),
                    'type' => 'text',
                    'section' => 'option_pmgateway',
                    'desc' => __('Security Secret', 'traveler-zoopay'),
                    'condition' => 'pm_gway_st_zoopay_enable:is(on)'
                ),
                array(
                    'id' => 'zoopay_creditcard_currency',
                    'label' => __('Default Currency', 'traveler-zoopay'),
                    'type' => 'text',
                    'section' => 'option_pmgateway',
                    'desc' => __('Default Currency', 'traveler-zoopay'),
                    'condition' => 'pm_gway_st_zoopay_enable:is(on)'
                ),
            );
        }

        public function setDefaultParam()
        {
            $this->url = st()->get_option('zoopay_creditcard_url', '');
            $this->userId = st()->get_option('zoopay_creditcard_userId', '');
            $this->password = st()->get_option('zoopay_creditcard_password', '');
            $this->secure_secret = st()->get_option('zoopay_creditcard_secure_secret', '');
            $this->currency = st()->get_option('zoopay_creditcard_currency', '');
        }

        function _pre_checkout_validate()
        {
            if (TravelHelper::get_current_currency('name') != 'THB') {
                STTemplate::set_message(__('This payment only supports THB currency', 'traveler-zoopay'));
                return false;
            }

            return true;
        }

        function do_checkout($order_id)
        {
            if (!$this->is_available()) {
                return
                    [
                        'status' => 0,
                        'complete_purchase' => 0,
                        'error_type' => 'card_validate',
                        'error_fields' => '',
                    ];
            }

            $this->setDefaultParam();
            $lang = get_bloginfo("language"); // get current language of website
          
            if ($lang == "en") {
                $vpc_Locale = "en";
            } else $vpc_Locale = "en";

            $total = get_post_meta($order_id, 'total_price', true);
            $total = round((float)$total, 2);
            $total = number_format(1 * $total, 2, '.', '');
            $total = round($total, 2);

            /*
            $op_var = array(
                'userId' => $this->userId,
                'password' => $this->password,
                'vpc_MerchTxnRef' => date('YmdHis') . rand(),
                'vpc_OrderInfo' => $order_id,
                'vpc_Amount' => $total * 100,
                'vpc_ReturnURL' => $this->get_return_url($order_id),
                'vpc_TicketNo' => $_SERVER["REMOTE_ADDR"]
            );
            */



            
            $op_var = array(

                'AgainLink' => 'zoopay.com',
                'Title' => 'zoopay.com',
                'entityId' => $this->userId,
                'amount' => $total,
                'currency' => $this->currency,
                //'vpc_MerchTxnRef' => date('YmdHis') . rand(),
                'paymentType' => 'DB',
                'orderInfo' => $order_id
                /*
                ,
                'vpc_ReturnURL' => $this->get_return_url($order_id),
                'vpc_TicketNo' => $_SERVER["REMOTE_ADDR"]
                */
            );

            /*

            function request() {
	$url = "https://test.oppwa.com/v1/checkouts";
	$data = "entityId=8a8294174e735d0c014e86d5e0db2177" .
                "&amount=92.00" .
                "&currency=EUR" .
                "&paymentType=DB";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                   'Authorization:Bearer OGE4Mjk0MTc0ZTczNWQwYzAxNGU4NmQ1ZTBlZTIxN2J8NzRucmZiZWo4YQ=='));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$responseData = curl_exec($ch);
	if(curl_errno($ch)) {
		return curl_error($ch);
	}
	curl_close($ch);
	return $responseData;
}
$responseData = request();

            */

            $zoopay_url = $this->url;
            $stringHashData = "";
            ksort($op_var);
            $appendAmp = 0;
            $params = "";

            foreach ($op_var as $key => $value) {

                if (strlen($value) > 0) {
                    if ($appendAmp == 0) {
                        $params .= urlencode($key) . '=' . urlencode($value);
                        $appendAmp = 1;
                    } else {
                        $params .= '&' . urlencode($key) . "=" . urlencode($value);
                    }

                    /*
                    if ((strlen($value) > 0) && ((substr($key, 0, 4) == "vpc_") || (substr($key, 0, 5) == "user_"))) {
                        $stringHashData .= $key . "=" . $value . "&";

                    }
                    */
                }
            }



            $stringHashData = rtrim($stringHashData, "&");
            if (strlen($this->secure_secret) > 0) {
                //$zoopay_url .= "&vpc_SecureHash=" . strtoupper(hash_hmac('SHA256', $stringHashData, pack('H*', $this->secure_secret)));
                /*
                $zoopay_url .= "&entityId=" . $this->entityId;
                $zoopay_url .= "&amount=" . ($total * 100);
                $zoopay_url .= "&paymentType=" . 'DB';
                $zoopay_url .= "&currency=EUR";
                */
            }


            //---- Curl Testing ----- 
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $zoopay_url .'?'.$params ); //Url together with parameters
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization:Bearer OGE4Mjk0MTc0ZTczNWQwYzAxNGU4NmQ1ZTBlZTIxN2J8NzRucmZiZWo4YQ=='));
            //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 7); //Timeout after 7 seconds
            curl_setopt($ch, CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
            curl_setopt($ch, CURLOPT_HEADER, 0); 
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);

            return ['status' => true, 'redirect' => $responseData];

        }


        function complete_purchase($order_id)
        {
            return true;
        }

        function check_complete_purchase($order_id)
        {
            $this->setDefaultParam();
            $vpc_Txn_Secure_Hash = $_GET ["vpc_SecureHash"];
            unset ($_GET ["vpc_SecureHash"]);
            $errorExists = false;

            if (strlen($this->secure_secret) > 0 && $_GET ["vpc_TxnResponseCode"] != "7" && $_GET ["vpc_TxnResponseCode"] != "No Value Returned") {
                ksort($_GET);
                $stringHashData = "";

                foreach ($_GET as $key => $value) {
                    if ($key != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key, 0, 4) == "vpc_") || (substr($key, 0, 5) == "user_"))) {
                        $stringHashData .= $key . "=" . $value . "&";
                    }
                }
                $stringHashData = rtrim($stringHashData, "&");

                if (strtoupper($vpc_Txn_Secure_Hash) == strtoupper(hash_hmac('SHA256', $stringHashData, pack('H*', $this->secure_secret)))) {
                    $hashValidated = "CORRECT";
                } else {
                    $hashValidated = "INVALID HASH";
                }
            } else {
                $hashValidated = "INVALID HASH";
            }

            $amount = $this->null2unknown($_GET ["amount"]);
            $orderInfo = $this->null2unknown($_GET ["orderInfo"]);
            $txnResponseCode = $this->null2unknown($_GET ["vpc_TxnResponseCode"]);

            $tranDesc = $this->getResponseDescription($txnResponseCode);

            if ($hashValidated == "CORRECT" && $txnResponseCode == "0") {
                return ['status' => true, 'message' => $tranDesc];

            } elseif ($txnResponseCode != "0") {
                return ['status' => false, 'message' => $tranDesc];
            } elseif ($hashValidated == "INVALID HASH") {
                return ['status' => false, 'message' => $tranDesc];
            }

        }

        function getResponseDescription($responseCode)
        {

            switch ($responseCode) {
                case "200" :
                    $result = "Transaction Successful";
                    break;
                case "307" :
                    $result = "Temporary redirect";
                    break;
                case "400" :
                    $result = "bad request. This might either point to e.g. invalid parameters or values sent. It's also returned if the payment failed e.g. because the acquirer declined.";
                    break;
                case "401" :
                    $result = "invalid authorization header provided";
                    break;
                case "403" :
                    $result = "invalid access token provided";
                    break;
                case "404" :
                    $result = "requested resource or endpoint is not found";
                    break;
                case "5" :
                    $result = "Insufficient funds";
                    break;
                case "6" :
                    $result = "Error Communicating with Bank";
                    break;
                case "7" :
                    $result = "Payment Server System Error";
                    break;
                case "8" :
                    $result = "Transaction Type Not Supported";
                    break;
                case "9" :
                    $result = "Bank declined transaction (Do not contact Bank)";
                    break;
                case "F" :
                    $result = "3D Secure Authentication failed";
                    break;
                case "B" :
                    $result = "Cannot authenticated by 3D-Secure Program. Please contact Issuer Bank.";
                    break;
                case "Z" :
                    $result = "Transaction was block by OFD";
                    break;
                case "99" :
                    $result = "User Cancel";
                    break;
                default  :
                    $result = "Payment fail";
            }

            return $result;

        }

        private function null2unknown($data)
        {
            if ($data == "") {
                return "No Value Returned";
            } else {
                return $data;
            }
        }

        function html()
        {
            echo Traveler_zoopay_Payment::get_inst()->loadTemplate('zoopay');
        }

        function get_name()
        {
            return __('Zoopay', 'traveler-zoopay');
        }

        function get_default_status()
        {
            return $this->default_status;
        }

        function is_available($item_id = false)
        {
            if (st()->get_option('pm_gway_st_zoopay_enable') == 'off') {
                return false;
            } else {
                if (!st()->get_option('zoopay_creditcard_userId')) {
                    return false;
                }
            }

            if ($item_id) {
                $meta = get_post_meta($item_id, 'is_meta_payment_gateway_st_zoopay', true);
                if ($meta == 'off') {
                    return false;
                }
            }

            return true;
        }

        function getGatewayId()
        {
            return $this->_gateway_id;
        }

        function is_check_complete_required()
        {
            return true;
        }

        function get_logo()
        {
            return Traveler_zoopay_Payment::get_inst()->pluginUrl . 'assets/img/zoopay.png';
        }

        static function instance()
        {
            if (!self::$_ints) {
                self::$_ints = new self();
            }

            return self::$_ints;
        }

        static function add_payment($payment)
        {
            $payment['st_zoopay'] = self::instance();

            return $payment;
        }
    }

    add_filter('st_payment_gateways', array('ST_Zoopay_Payment_Gateway', 'add_payment'));
}