<?php

// App::uses('AppController', 'Controller');




/**
 * Home Controller
 *
 */
class VuforiaController extends AppController
{
    var $components = array("Session", 'SignatureBuilder', "Upload", "Vuforia","Acl");
    var $helpers = array("Html","Session");
    //Server Keys



    public function beforeFilter()
    {
        $this->loadModel('VuforiaTarget');
    }


    // tạo ARO group
    public function someAction() {
        $aro = $this->Acl->Aro;

        // gỉa sử bạn nhận được từ trên giao diện một mảng các group nhập từ người dùng

        $groups = array(
            0 => array(
                'alias' => 'admin'
            ),
            1 => array(
                'alias' => 'user'
            ),
            2 => array(
                'alias' => 'guest'
            )
        );

        // lặp và dùng hàm create() của ARO để tạo ra các đối tượng ARO group
        foreach ($groups as $group) {
            $aro->create();
            $aro->save($group);
        }
    }

    function get_target($target_id){

        $this->requestPath = $this->requestPath . '/' . $target_id;

        $this->execGetTarget();

        die;
    }




//    function update($target_id){
//
//        $this->requestPath = $this->requestPath . '/' . $target_id;
//
//        $helloBase64 = base64_encode("hello world!");
//
//        $this->jsonBody = json_encode( array( 'name' => 'directupdate' , 'image'=> $this->getImageAsBase64('/Applications/XAMPP/xamppfiles/htdocs/vr/demo.jpg') ) );
//
//        $this->Vuforia->execUpdateTarget();
//
//    }

    public function delete($id = null)
    {
        App::uses('File', 'Utility');



        $data = $this->VuforiaTarget->read(null,$id);
        if(!empty($data)){

            $repon_exe = json_decode( $this->Vuforia->execDeleteTarget($data['VuforiaTarget']['target_id']));


            if( $repon_exe->result_code == 'TargetStatusProcessing'){
                $this->Session->setFlash(__('Cloud: Please wait a few minutes'), 'default', array(), 'success');
                $this->redirect("/vuforia/datalist");

            }else{
                if($this->VuforiaTarget->delete($id)){

                    $file = new File(WWW_ROOT .'uploads/media/'.$data['VuforiaTarget']['target_image'], false, 0777);
                    $file->delete();

                    $file = new File(WWW_ROOT .'uploads/media/'.$data['VuforiaTarget']['media_output'], false, 0777);
                    $file->delete();

                }
                $this->Session->setFlash('Delete success', 'default', array(), 'success');
                if( $repon_exe->result_code == 'UnknownTarget'){
                    $this->Session->setFlash(__('Cloud message: Unknown target'), 'default', array(), 'success');
                }
            }
        }
        $this->redirect("/vuforia/datalist");
    }





    public function datalist() {


        $data = array();
        $this->paginate = array(
            'limit' => 20,// mỗi page có 4 record
            'order' => array('VuforiaTarget.id' => 'desc'),//giảm dần theo id
            'recursive' => 2,

        );
        $this->data = $data;
        $data = $this->paginate("VuforiaTarget");
        $this->set("data",$data);

    }

    public function upload($target_id = null)
    {
        echo AuthComponent::user('id');


        try {
            $this->set('input_target_id_respon', null);
            $this->set('target_id', null);

            if (!empty($this->data)) {

                $post_data = $this->data;

                if (array_key_exists('target_image', $post_data['VuforiaTarget'])) {
                    $imageFile = $post_data['VuforiaTarget']['target_image']['tmp_name'];
                    if( $post_data['VuforiaTarget']['target_name'] != ''){
                        $targetName = $post_data['VuforiaTarget']['target_name'];
                    }else{
                        $targetName = base64_encode(rand());
                    }

                    $target_width = 320.0;
                    if($post_data['VuforiaTarget']['target_width'] !='') {
                        $target_width = (float) $post_data['VuforiaTarget']['target_width'];
                    }

                    $json_return = $this->Vuforia->PostNewTarget((float) $target_width, $targetName, $imageFile);
                    $obj_respon = json_decode($json_return);


                    if(!empty($obj_respon) && $obj_respon->result_code == 'TargetCreated') {


                        $file_name_target_image = $this->Upload->start_upload($post_data['VuforiaTarget']['target_image']);




                        $dataVuforia = array(
                            'VuforiaTarget' => array(
                                'target_id' => $obj_respon->target_id,
                                'target_image' => $file_name_target_image,
                                'target_name' => $targetName,
                                'target_width' => $target_width,
                                'admin_id' => AuthComponent::user('id'),
                            )
                        );


                        if ($post_data['VuforiaTarget']['media_output']['size'] > 0) {
                            $file_name_media_output = $this->Upload->start_upload($post_data['VuforiaTarget']['media_output']);
                            $dataVuforia['VuforiaTarget']['media_output'] = $file_name_media_output;
                            $dataVuforia['VuforiaTarget']['media_type'] = $post_data['VuforiaTarget']['media_output']['type'];



                        }
                        $this->VuforiaTarget->set($dataVuforia);
                        $this->VuforiaTarget->save();


                        $last_insert_id = $this->VuforiaTarget->getInsertID();

                        $this->Session->setFlash(__('Upload success'), 'default', array(), 'success');
                        $this->redirect("/vuforia/edit/" . $last_insert_id);


                    }else if(!empty($obj_respon) && $obj_respon->result_code == 'TargetNameExist'){
                        $this->Session->setFlash(__('Target name exist'), 'default', array(), 'error');
                        $this->redirect("/vuforia/upload/");

                    }else{
                        $this->Session->setFlash(__('Upload faild'), 'default', array(), 'error');
                        $this->redirect("/vuforia/upload/");
                    }
                }
            }
        } catch (Exception $e) {
            $this->Session->setFlash(__('Upload faild'), 'default', array(), 'error');
        }
    }

    public function edit($id)
    {
        App::uses('File', 'Utility');

        if (!$id && empty($this->data)) {
            $this->redirect("/vuforia/datalist");
        }
        if (empty($this->data)) {
            $this->data = $this->VuforiaTarget->findById($id);
        } else{
            $post_data = $this->data;
            $before_edit = $this->VuforiaTarget->findById($id);
            $old_media_output = $before_edit['VuforiaTarget']['media_output'];
            try {
                $var_jsonBody = array() ;
                $target_width = 320.0;
                $flag_edit_target_image = false;
                if($post_data['VuforiaTarget']['target_width'] !='') {

                    $target_width = (float) $post_data['VuforiaTarget']['target_width'];
                    $var_jsonBody['width'] = $target_width;
                    $before_edit['VuforiaTarget']['target_width'] = $target_width;
                }
                $target_id = $before_edit['VuforiaTarget']['target_id'];
                if( $post_data['VuforiaTarget']['target_name'] != ''){
                    $targetName = $post_data['VuforiaTarget']['target_name'];
                }else{
                    $targetName = base64_encode(rand());
                }
                $var_jsonBody['name'] = $targetName;
                $before_edit['VuforiaTarget']['target_name'] = $targetName;
                if ($post_data['VuforiaTarget']['media_output']['size'] > 0) {



                    $file_name_media_output = $this->Upload->start_upload($post_data['VuforiaTarget']['media_output']);




                    $before_edit['VuforiaTarget']['media_output'] = $file_name_media_output;
                    $before_edit['VuforiaTarget']['media_type'] = $post_data['VuforiaTarget']['media_output']['type'];

                }
                $jsonBody = json_encode($var_jsonBody);
                $respon_update = json_decode($this->Vuforia->execUpdateTarget($jsonBody, $target_id));
                $this->VuforiaTarget->set($before_edit);

                if($this->VuforiaTarget->save()){

                    $file = new File(WWW_ROOT .'uploads/media/'.$old_media_output, false, 0777);
                    $file->delete();
                }
                $this->Session->setFlash(__('Upload success'), 'default', array(), 'success');
                $this->redirect(Controller::referer());

            } catch (Exception $e) {
                $this->Session->setFlash('Upload faild', 'default', array(), 'failure');
                $this->redirect(Controller::referer());
            }
        }


    }

	public function target_list() {
		$this->requestPath = $this->requestPath;
		$json_retrieve = json_decode($this->Vuforia->execGetAllTargets());
		$arr_result = $json_retrieve->results ;
		$collection =$this->Vuforia->mapTargetData( $arr_result );
		$this->set( 'json_retrieve',$collection );
	}
}
