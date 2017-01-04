<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

	public function beforeSave($options = array())
	{
		if ( ( ! $this->id) && ( empty($this->data[$this->alias][$this->primaryKey])) ) {	// insert
	    	$this->data[$this->alias]['created_datetime'] = date('Y-m-d H:i:s',time());
	    	$this->data[$this->alias]['updated_datetime'] = date('Y-m-d H:i:s',time());
	  	} else {	// edit
	    	$this->data[$this->alias]['updated_datetime'] = date('Y-m-d H:i:s',time());
	  	}
		return true;
	}

	public function lastQuery()
	{
		$dbo = $this->getDatasource();
  		return $logs = $dbo->getLog();
	}
}