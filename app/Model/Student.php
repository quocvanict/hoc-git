<?php
App::uses('AppModel', 'Model');

/**
 * User Model
 *
 * @property Image $Image
 */
class Student extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'students';
	public $primaryKey = 'id';

    public $belongsTo = array(
        'School' => array(
            'className' => 'School',
            'foreignKey' => 'school_id'

        ),


    );

    function validate(){
        $this->validate = array(

            "name"=>array(
                "rule" => "notBlank",
                "message" => "Not blank",
            ),
            "email"=>array(
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