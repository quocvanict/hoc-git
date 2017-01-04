<?php

// App::uses('AppController', 'Controller');


// require_once 'HTTP/Request2.php';


/**
 * Home Controller
 *
 */
class ApiController extends AppController {
	 
	 
	public $layout = false; 
	
	function beforeRender() {
		$this->layout = false;
	}
	
	
	public function beforeFilter() {
		$this->loadModel('VuforiaTarget');
		$this->loadModel('School');
		$this->loadModel('User');
		$this->loadModel('Device');
		$this->Auth->allow();
        header('Content-Type: application/json');
	}

    public function get_school_list(){
        $results = $this->School->find('all',
            array(
                'fields' => array('School.school_id', 'School.school_name')
            ));
        $results = Set::extract('/School/.', $results);
	     $json_respon = array(
	         'data'=>$results,
             'error_code'=>'',
             'message'=>'',
         );
        echo json_encode((object)$json_respon);
        exit;
    }

    public function test(){
        $check_token = $this->Device->find('first', array(
            'conditions' => array(
                'user_id' => $this->request->data('user_id'),
                'token' => $this->request->data('token'),


            )));


    }
    public function target(){
        $results = $this->VuforiaTarget->find('all', array('recursive' => 3));
        print"<pre>";
        print_r($results);
        die;
    }

    public function form(){
        $results = $this->School->find('all',
            array(
                'fields' => array('School.school_id', 'School.school_name')
            ));

        $this->set('school_list', $results);


        // list user
        $results_user = $this->User->find('all');
        $this->set('results_user', $results_user);

        // list Device
        $results_device = $this->Device->find('all');
        $this->set('results_device', $results_device);





    }

    public function login(){
        $this->autoRender = false;
        $email = $this->request->data('email');
        $password = $this->request->data('password');
        $check_user = $this->User->find('first', array(
            'conditions' => array(
                'email'=>$email,
                'password'=>md5($password),
                'status'=> 1,
            ),
        ));



        $rep_data=array(
            'data'=>array(
                'info'=>'',

            ),
            'error_code'=>'',
            'message'=>'',
        );
        if(!empty($check_user)){

            $check_token = $this->Device->find('first', array(
                'conditions' => array(
                    'user_id'=>$check_user['User']['user_id'],
                ),
            ));

            $device_info = array(
                'user_id' => $check_user['User']['user_id']
            );
            if(!empty($check_token)){
                $device_info['id'] = $check_token['Device']['id'];
                $login_token = $check_token['Device']['token'];
            }else{
                $login_token = uniqid() . time();
            }
            $device_info['token'] =  $login_token;

            $this->Device->set($device_info);
            if ($this->Device->save($device_info)) {
                $rep_data['data']['info'] = $check_user['User'];
                $rep_data['data']['school'] = $check_user['School'];
                $rep_data['error_code'] = 0;
                $rep_data['message'] = 'Success';
                $rep_data['data']['token'] = $login_token;
            } else {
                $rep_data['error_code'] = 2;
                $rep_data['message'] = 'Failure';
                $rep_data['data']['info'] = $check_user;
            }
//
        }else {
            $rep_data['error_code']=1;
            $rep_data['message']='Email or password is incorrect';
        }


        echo json_encode($rep_data, JSON_UNESCAPED_UNICODE);die;
    }

    public function logout()
    {
        $this->autoRender = false;
        $this->loadModel('Device');
        $rep_data = array(
            'data' => '',
            'error_code' => '',
            'message' => '',

        );
        $check_token = $this->Device->find('first', array(
            'conditions' => array(
                'user_id' => $this->request->data('user_id'),
                'token' => $this->request->data('token'),


            )));

        if ($check_token) {
            $this->Device->set($check_token);

            if ($this->Device->delete())  {
//            if (1 == 1) {
                $rep_data['data'] = Set::extract('/Device/.', $check_token);
                $rep_data['error_code'] = 0;
                $rep_data['message'] = 'Success';

            } else {
                $rep_data['error_code'] = 2;
                $rep_data['message'] = 'Failure';
            }
            echo json_encode($rep_data);

        }else{
            $rep_data['error_code'] = 2;
            $rep_data['message'] = 'Failure';
            echo json_encode($rep_data);
        }

    }

    public function register(){
        $this->autoRender = false;
        $this->loadModel('Profile');
        $this->loadModel('User');
        $rep_data=array(
            'data'=>'',
            'error_code'=>'',
            'message'=>'',

        );
        $data = $this->request->data;
//        print"<pre>";
//        print_r($data);
//        die;



        if ($this->request->is('post')) {
            if((!empty($data['email']))&&(!empty($data['name']))&&(!empty($data['password']))&&(!empty($data['school_id'])) && $data['school_id'] !='' ) {

                $user_info = array(
                    'email' => $data['email'],
                    'name' => $data['name'],
                    'password' => md5($data['password']),
                    'school_id' => $data['school_id'],
                    'dob' => $data['dob'],
                    'status' => 1,
                );
                $check_exist = $this->User->findByEmail($data['email']);
                if(empty($check_exist)){
                    $this->User->set($user_info);
                    if ($this->User->save()) {
                        $rep_data['error_code'] = 0;
                        $rep_data['message'] = 'Success';
                    } else {
                        $rep_data['error_code'] = 2;
                        $rep_data['message'] = 'Failure';
                    }
                }else{
                    $rep_data['error_code'] = 2;
                    $rep_data['message'] = 'Email exist';
                }
            }else{
                $rep_data['error_code'] = 2;
                $rep_data['message'] = 'Failure';
            }
        }
        echo json_encode($rep_data);die;
    }

    public function get_by_target_id($target_id = null) {


        header('Content-Type: application/json');



	    if(!empty($target_id)) {
            $this->layout = false;
            $res_target = $this->VuforiaTarget->find('first', array(
                'conditions' => array(
                    'VuforiaTarget.target_id' => $target_id,
                )
            ));
            if(!empty($res_target)) {


                $json_respon['data'] = $res_target['VuforiaTarget'];
                $link_media_output = Router::url('/', true) . 'uploads/media/' . $res_target['VuforiaTarget']['media_output'];
                $json_respon['data']['media_output'] = $link_media_output;
                $json_respon['error_code'] = 0;
                $json_respon['message'] = "";

                json_encode((object)$json_respon);


                echo json_encode((object)$json_respon);
                exit;
            }else{
                $json_respon['error_code'] = 2;
                $json_respon['message'] = "An error occured, please try again!";


                echo json_encode((object)$json_respon);
            }
            exit;
        }else{

            $json_respon['error_code'] = 2;
            $json_respon['message'] = "An error occured, please try again!";
            echo json_encode((object)$json_respon);
            exit;
        }
	}
    public function index() {
		$this->layout = false; 
		die;
		
		
    }
    public function info() {
        //phpinfo();
        die;

    }
 

}

