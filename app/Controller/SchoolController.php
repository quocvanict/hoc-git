<?php
/**
 * Home Controller
 *
 */
class SchoolController extends AppController
{
    var $components = array("Session");
    var $helpers = array("Html","Session");
    //Server Keys



    public function beforeFilter()
    {
        $this->loadModel('School');
        if (AuthComponent::user('level') != 1) {
            $this->Session->setFlash(__('Not permission to access'), 'default', array(), 'success');
            $this->redirect("/error");
        }
    }


    public function delete($id = null)
    {



        $data = $this->School->read(null,$id);
        if(!empty($data)){



            $this->School->delete($id);
            $this->Session->setFlash(__('Delete success'), 'default', array(), 'success');
            $this->redirect("/school/index");
        }

        $this->redirect("/school/index");
    }


    public function edit($id = null)
    {
//        if (!$id && empty($this->data)) {
//
//            $this->redirect("/school/index");
//        }

        if (empty($this->data)) {
            $this->data = $this->School->findBySchoolId($id);
        } else{
            $this->School->set($this->data);
            if($this->School->validate()){
                $this->School->save();
                $this->Session->setFlash(__('Save success'), 'default', array(), 'success');
                $this->redirect("/school/index");
            }
        }
    }

	public function index() {

        $data = $this->School->find("all");
        $this->set("data",$data);
	}

}
