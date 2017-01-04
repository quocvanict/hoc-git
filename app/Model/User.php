<?php
App::uses('AppModel', 'Model');

/**
 * User Model
 *
 * @property Image $Image
 */
class User extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'users';
	public $primaryKey = 'user_id';

    public $belongsTo = array(

        'School' => array(
            'className' => 'School',
            'foreignKey' => 'school_id',

        )


    );

//    public function beforeFind($queryData = null) {
//        parent::beforeFind();
//        $queryData['conditions']['User.school_id'] = 2;
//        return $queryData;
//    }

    public function beforeFind($queryData) {


        // Force all finds to only find stuff which is live
        if(AuthComponent::user('level') != 1){
            if(AuthComponent::user('school_id') != 0)
                $queryData['conditions'][$this->alias.'.school_id'] = AuthComponent::user('school_id') ;
        }

        return $queryData;
    }


}