<?php
App::uses('AppModel', 'Model');

/**
 * User Model
 *
 * @property Image $Image
 */
class VuforiaTarget extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'vuforia_targets';
	public $primaryKey = 'id';

    public $belongsTo = array(

        'Admin' => array(
            'className' => 'Admin',
            'foreignKey' => 'admin_id',

        )


    );

    public function beforeFind($queryData) {
      
        // Force all finds to only find stuff which is live
        if(AuthComponent::user('level') == 2){
             $queryData['conditions'][$this->alias.'.admin_id'] = AuthComponent::user('id') ;
        }

        return $queryData;
    }
}