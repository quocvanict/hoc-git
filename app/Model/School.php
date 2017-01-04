<?php
App::uses('AppModel', 'Model');

/**
 * User Model
 *
 * @property Image $Image
 */
class School extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'schools';
	public $primaryKey = 'school_id';


    function validate(){
        $this->validate = array(

            "name"=>array(
                "rule" => "notBlank",
                "message" => "Not blank",
            ),


        );
        if($this->validates($this->validate))
            return TRUE;
        else
            return FALSE;
    }


}