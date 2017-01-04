<?php

// App::uses('AppController', 'Controller');


// require_once 'HTTP/Request2.php';


/**
 * Home Controller
 *
 */
class DevController extends AppController {
	 
	 
	public $layout = false; 
	
	function beforeRender() {
		$this->layout = false;
		
	}
	
	
	public function beforeFilter() {
		$this->loadModel('VuforiaTarget');
		$this->Auth->allow();
	}
	
	
	
	
    public function get_by_target_id($target_id) {
		$this->layout = false; 
		$res_target = $this->VuforiaTarget->find('first', array(
				'conditions' => array(
					'VuforiaTarget.target_id' => $target_id,
				)
			));
			
		echo json_encode($res_target);		
		exit;
		 	
	}
    public function index() {
		$this->layout = false; 
		
		phpinfo();
		die;
		
    }
 

}
