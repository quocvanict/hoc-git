<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
require_once APP . '/Lib/PluginCsv.php';

/**
 * Home Controller
 *
 */
class UserController extends AppController {

    public $components = array('Paginator');

    public function beforeFilter() {
        require_once dirname(APP) . '/vendor/autoload.php';
        parent::beforeFilter();

    }



    public function index() {
        try{
            $data = array();
            $this->paginate = array(
                'limit' => 10,// mỗi page có 4 record
                'order' => array('User.user_id' => 'desc'),//giảm dần theo id

            );
            $this->data = $data;
            $data = $this->paginate("User");

            $this->set("data",$data);
        } catch (Exception $e) {
            $this->Session->setFlash(__('Not found item'), 'default', array(), 'success');
        }
    }

    public function delete($id = null)
    {

        $data = $this->User->read(null,$id);
        if(!empty($data)){
            $this->User->delete($id);
            $this->Session->setFlash(__('Delete success'), 'default', array(), 'success');
            $this->redirect("/user/index");
        }

        $this->redirect("/user/index");
    }

    public function approve($id = null)
    {
        try{
            $data = $this->User->read(null,$id);
            if(!empty($data)){
                if($data['User']['status'] == 1){
                    $data['User']['status'] = 0;
                }else{
                    $data['User']['status'] = 1;
                }



                $this->User->set($data);
                $this->User->save();
                $this->Session->setFlash(__('Approved'), 'default', array(), 'success');

            }

            $this->redirect(Controller::referer());
        } catch (Exception $e) {
            $this->Session->setFlash(__('Success'), 'default', array(), 'success');
        }

    }


}
