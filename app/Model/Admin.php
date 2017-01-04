<?php

App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

/**
 * User Model
 *
 * @property Image $Image
 */
class Admin extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'admins';
    public $primaryKey = 'id';
    public $belongsTo = array(

        'School' => array(
            'className' => 'School',
            'foreignKey' => 'school_id',

        )


    );
    // auto encrypt password before save
    // auto add value plainPassword, creationDate, modificationDate // for openfire
    public function beforeSave($options = array()) {
        parent::beforeSave($options);

        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new SimplePasswordHasher(array('hashType' => 'md5'));
            $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
        }
        return true;
    }

    public function afterSave($created, $options = array()) {

    }

    public function afterDelete() {

    }

    // create encrypt password from plain password
    public function encryptPassword($password) {
        $passwordHasher = new SimplePasswordHasher(array('hashType' => 'md5'));
        return $passwordHasher->hash($password);
    }

    function validate(){
        $this->validate = array(

            "level"=>array(
                "rule" => "notBlank",
                "message" => __("Not blank"),
            ),


        );
        if($this->validates($this->validate))
            return TRUE;
        else
            return FALSE;
    }


}
