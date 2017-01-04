<?php
App::uses('AppController', 'Controller');

/**
 * Home Controller
 *
 */
class HomeController extends AppController {
	public $uses = array();

    public function index() {
    	$this->set('title_for_layout', 'Hello admincp');
         $this->set('title_for_menu', '');
	}

  public function inputValidator(){
    $i = $this->request->data;
    switch($this->request->query('source')){
      case 'admin':
        $this->loadModel('Admin');
        $con = [
          'email' => $i['email']
        ];
        if(!empty($i['id'])){
          $con[] = 'id != '.$i['id'];
        }

        $a = $this->Admin->find('first', [
          'conditions' => $con
        ]);
        if($a){
          return $this->toJson([
            'status' => false,
            'message' => 'This email is already exists'
          ]);
        }
        return $this->toJson([
          'status' => true
        ]);
      case 'user.email':
        $this->loadModel('User');
        $con = [
          'email' => $i['email']
        ];
        if(!empty($i['id'])){
          $con[] = 'id != '.$i['id'];
        }

        $a = $this->User->find('first', [
          'conditions' => $con
        ]);
        if($a){
          return $this->toJson([
            'status' => false,
            'message' => 'This email is already exists'
          ]);
        }
        return $this->toJson([
          'status' => true
        ]);
      break;
      case 'user.phone':
      $this->loadModel('User');
        $con = [
          'phone_number' => $i['phone_number']
        ];
        if(!empty($i['id'])){
          $con[] = 'id != '.$i['id'];
        }

        $a = $this->User->find('first', [
          'conditions' => $con
        ]);
        if($a){
          return $this->toJson([
            'status' => false,
            'message' => 'This Phone Number is already exists'
          ]);
        }
        return $this->toJson([
          'status' => true
        ]);


      default:
      break;
    }
  }
}
