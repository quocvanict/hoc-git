<?php

App::uses('AppController', 'Controller');

/**
 * Auth Controller
 *
 */
class AuthController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        require_once dirname(APP) . '/vendor/autoload.php';
        $this->Auth->allow('logout');
    }

    public function login() {
        if ($this->request->is('post')) {
            // _debug($this->Auth);
            if ($this->Auth->login()) { // login susscess
                // update last login
                //      	$this->User->id = $this->Auth->user('id');
                // $this->User->saveField('last_login_datetime', date('Y-m-d H:i:s'));
                $this->redirect('/vuforia/datalist');
//                $this->redirect($this->Auth->redirect());
            }

            $this->Session->setFlash(__('Email or password is incorrect'), 'default', null, 'auth');
        } else {
            if ($this->Auth->User()) {
                $this->redirect('/vuforia/datalist');
            }
            $this->set('title_for_layout', 'ログイン');
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

}
