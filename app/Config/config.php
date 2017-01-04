<?php

include 'ip.php';
$config['project_title'] = "AR";
$config['version'] = '1.0';
$base_folder = '@' . str_replace(APP_DIR . '/' . WEBROOT_DIR . '/' . 'index.php', '', $_SERVER['PHP_SELF']);
$base_folder = str_replace('@/', '', $base_folder);
define('BASE_URL', Router::url('/', true) . $base_folder);

// upload config dir
$config['image_dir'] = WWW_ROOT . 'uploads/images/';
$config['banner_dir'] = WWW_ROOT . 'uploads/images/banner/';
$config['campaign_image_dir'] = WWW_ROOT . 'uploads/images/campaign_image/';
$config['campaign_default'] = 'assets/img/norina-default.jpg';
$config['image_url'] = 'uploads/images/';
$config['image_default'] = BASE_URL . 'uploads/images/default.jpg';

//openfire
$config['openfire']['server'] = openfire_ip;
$config['openfire']['port'] = 5222;
$config['openfire']['admin_id'] = '0';

$config['support_email'] = array(
    'forget_password' => 'support@norina.jp',
    'cancel_trip' => 'support@norina.jp',
    'qa' => 'support@norina.jp');

define('LOGIN_EXPIRED', 60 * 60 * 24 * 30); //30 days
define('CODE_EXPIRED', 1800);
define('PASSENGER', 1);
define('DRIVER', 2);
define('SEX_MALE', 0);
define('SEX_FEMALE', 1);

$config['left_menu'] = array(

    array(
        'icon' => 'fa fa-user',
        'title' => __('Administrator'),
        'url' => 'admin/index',
        'childrens' => '',
        'rule'=>array(1),

    ),
	array(
        'icon' => 'fa fa-gear',
        'title' => __('Configuration'),
        'url' => 'configuration/index',
        'childrens' => '',
        'rule'=>array(1),

    ),
	
	array(
        'icon' => 'fa fa-cloud-upload  ',
        'title' => __('AR management'),
        'url' => 'vuforia/datalist',
        'rule'=>array(1,2),
        'childrens' => array(
            array(
                'title' => __('List'),
                'url' => 'vuforia/datalist',
                'childrens' => false
            ),array(
                'title' => __('Add'),
                'url' => 'vuforia/upload',
                'childrens' => false
            ),


        )
    ),
    array(
        'icon' => 'fa fa-book',
        'title' => __('School'),
        'url' => 'school/index',
        'childrens' => '',
        'rule'=>array(1),
    ),
    array(
        'icon' => 'fa fa-user',
        'title' => __('User management'),
        'url' => 'user/index',
        'childrens' =>  '',
        'rule'=>array(1,2),

    ),




);
$config['gg_maps_api'] = [
    'language' => 'ja',
    'region' => 'JP',
    'alternatives' => 'true',
    'secret_key' => 'AIzaSyAxTY741XPmx0nCXaU74nOm5U5VFsp84mY',
    'url' => 'https://maps.googleapis.com/maps/api/directions/json'
];

define('TRIP_STATUS_ON_PROCESSING', 0);
define('TRIP_STATUS_DEPARTED', 1);
define('TRIP_STATUS_ARRIVED', 2);
define('TRIP_STATUS_DELETE', 3);
define('TRIP_STATUS_EXPIRED', 4);

define('TRIP_STATE_UNMATCHED', 0);
define('TRIP_STATE_MATCHED', 1);

define('TRAVEL_STATE_MATCHED', 1);
define('TRAVEL_STATE_APPROVED', 2);
define('TRAVEL_STATE_PAID', 3);
define('TRAVEL_STATE_DEPARTED', 4);
define('TRAVEL_STATE_GETON', 5);
define('TRAVEL_STATE_ARRIVED', 6);
define('TRAVEL_STATE_CANCEL', 7);
define('TRAVEL_STATE_TRANSACTION_CANCEL', 8);

define('TRANSACTION_STATE_PAID', 1);
define('TRANSACTION_STATE_CANCEL', 2);

define('DTIME_VALID', 86400); //delay departure time between 2 trip
define('MAX_TRIPS', 100);
define('TRIP_HAS_SAME_DDATE', 100); // trip num has same departure date
define('MAX_DISTANCE', 2000);
define('MAX_ANGLE', 5);

define('CAMPAIGN_STATUS_ACTIVE', 1);
define('CAMPAIGN_STATUS_INACTIVE', 0);

define('GOT_TRIP_NUM', 50); //num of trips per get
define('GOT_REVIEW_NUM', 20); //num of comment per get
define('GOT_CONVERSATION_NUM', 20); //num of conversations per get
define('GOT_MESSAGE_NUM', 50); // num of message per get

define('AVATAR_IMAGE', 1);
define('LICENSE_IMAGE', 2);
define('IDENTIFY_IMAGE', 3);
define('COVER_IMAGE', 4);

define('MESS_TYPE_PUSH_STATE', 'push_state');
define('MESS_TYPE_PUSH_COUPON', 'coupon');
define('MESS_TYPE_NOTICE', 'notice');

define('COUPON_PERCENT', 1);
define('COUPON_VALUE', 2);

define('PAY_DRIVER', 1);
define('NOT_PAY_DRIVER', 0);

define('ACTIVE', 1);
define('INACTIVE', 0);

define('CANCEL_STATE_REQUEST', 1);
define('CANCEL_STATE_PROCESSING', 2);
define('CANCEL_STATE_ACCEPT', 3);
define('CANCEL_STATE_REJECT', 4);

define('PASSENGER_REVIEW_DRIVER', 1);
define('DRIVER_REVIEW_PASSENGER', 2);

define('PAYMENT_NONE', 0);
define('PAYMENT_STEP_1', 1);
define('PAYMENT_STEP_2', 2);
define('PAYMENT_SUCCESS', 3);
define('PAYMENT_FAIL', 4);








