<?php

App::uses('AppController', 'Controller');

class ConfigurationController extends AppController
{
	var $components = array('SignatureBuilder', "Upload", "Vuforia","Acl");
    public function beforeFilter()
    {
        
        $this->loadModel('Configuration');
        
    }

    public function index()
    {
		if (empty($this->data)) {
			
            $this->data = $this->Configuration->read(null,1);
        } else{
			// print"<pre>";
			// print_r($this->data);
			// die;

			
            $this->Configuration->set($this->data);
            if($this->Configuration->save()){
              
                $this->Session->setFlash(__('Save success'), 'default', array(), 'success');
                $this->redirect("/configuration/index");
            }
        }
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
