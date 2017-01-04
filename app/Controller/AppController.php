<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    // public $uses = array('User');
    public $helpers = array("Session", "Html", "Form");
    public $components = array(
        'Session',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'auth',
                'action' => 'login'
            ),
            'loginRedirect' => array(
                'controller' => 'trip',
                'action' => 'index'
            ),
            'authError' => 'You must be logged in to view this page!!!',
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'Admin',
                    'fields' => array('username' => 'email'),
                    'passwordHasher' => array(
                        'className' => 'Simple',
                        'hashType' => 'md5'
                    ),
                    'scope' => array('status' => 1)
                )
            )
        )
    );

    // call when data user changed
    // when change password, profile
    function refreshAuthData() {
        $user_data = $this->Admin->findById($this->Auth->Admin('id'));
        if ($user_data) {
            $auth_data = $user_data['Admin'];
            $this->Session->write('Auth.Admin', $auth_data);
        } else {  // logout
            $this->redirect($this->Auth->logout());
        }
    }

    function beforeRender() {
        // auto detect layout
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
        } else {
            $this->layout = 'sakama';
        }

        // for auth login
        if (strpos($this->request->controller, 'auth') !== false && $this->action == 'login') {
            $this->layout = 'sakama_simple';
        }
//        $this->loadModel('Setting');
//        $page = $this->Setting->find('first', array('conditions' => array('Setting.name' => 'line_per_page')));
//        $my_file = './assets/constant.txt';
//        $handle = fopen($my_file, 'r');
//        $line = fread($handle, filesize($my_file));
//        $this->Session->write('line_per_page', $page['Setting']['value']);
//        $check = $this->Session->read('line_per_page');
//        if (!isset($check)) {
//            $this->Session->write('line_per_page', $line);
//        }


        $this->set('user_level', AuthComponent::user('level'));

    }

    // for AJAX
    function responseApi($code = 'OK', $message = '', $data = array(), $header_type = 'json') {
        if ($header_type == 'json') {
            header('Content-Type: application/json');
        } else {
            header('Content-Type: text/html');
        }
        echo json_encode(array(
            'code' => $code,
            'message' => $message,
            'data' => $data
                )
        );
        die;
    }

    public function toJson($body) {
        $this->autoRender = false;
        $this->response->type('json');
        $this->response->body(json_encode($body));
        return $this->response;
    }

}
