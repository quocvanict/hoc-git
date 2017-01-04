<?php

App::uses('AppController', 'Controller');

class AdminController extends AppController
{

    public function beforeFilter()
    {
        require_once dirname(APP) . '/vendor/autoload.php';
        $this->loadModel('Admin');
        parent::beforeFilter();




        $this->loadModel('VuforiaTarget');
        $this->loadModel('School');
        if (AuthComponent::user('level') != 1) {
            $this->Session->setFlash(__('Not permission to access'), 'default', array(), 'success');
            $this->redirect("/error");
        }
    }

    public function index()
    {


        if ($this->request->isPost()) {
            $ids = $this->request->data('ids');
            $ids = explode(',', $ids);
            $this->Admin->deleteAll(['id' => $ids], false);
            return $this->redirect(array(
                'controller' => 'admin',
                'action' => 'index'
            ));
        }
        $list = $this->Admin->find('all');
        $this->set('list', $list);
    }

    public function edit($id = null)
    {

        if (empty($this->data)) {
            $this->data = $this->Admin->findById($id);
            $school_list = $this->School->find('list', array('fields' => array('School.school_id', 'School.school_name'),));
            $school_list = array(''=>'') + $school_list;
            $this->set('school_list',$school_list);

        } else{
            $data = $this->data;
            if (strlen($data['Admin']['password']) < 1) {
                unset($data['Admin']['password']);
            }
            $check_exist = $this->Admin->findByEmail($data['Admin']['email']);

            if(!empty($check_exist) && $id == null) {
                $this->Session->setFlash('Email exist', 'default', array(), 'success');
                $this->redirect("/admin/index");
            }else{
                $this->Admin->set($data);
                if($this->Admin->validate()){
                    $this->Admin->save();
                    $this->Session->setFlash(__('Save success'), 'default', array(), 'success');
                    $this->redirect("/admin/index");
                }
            }
        }
    }


    function delete($id)
    {


        if (isset($id) && is_numeric($id)) {
            if (AuthComponent::user('id') == $id) {

                $this->Session->setFlash(__('Cannot delete current user'), 'default', array(), 'error');

                $this->redirect("/admin/");
            }


            $data = $this->Admin->read(null, $id);
            if (!empty($data)) {
                $this->Admin->delete($id);
                $this->Session->setFlash(__("Deleted"));
            } else {
                $this->Session->setFlash(__("Username not exist"));
            }
        } else {
            $this->Session->setFlash(__("Username not exist"));
        }
        $this->redirect("/admin/");
    }

}
