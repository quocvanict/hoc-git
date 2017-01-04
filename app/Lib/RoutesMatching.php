<?php
/**
 * Find matching routes
*
* @usage
*
* $class = new RoutesMatching;
* $class->setStart('a polyline string');
* $class->setEnd('a polyline string');
* $result = $class->find();
*
*/

class RoutesMatching{

	/**
	 * @var string
	 */
	protected $start = null;

	/**
	 * @var string
	 */
	protected $end = null;

	/**
	 * @param array $options
	 */
	public function __construct($options = array()){
		//
	}

	/**
	 * @param string $polyline
	 * @return RoutesMatching
	 */
	public function setStart($polyline){
		$this->start = $polyline;
		return $this;
	}

  /**
	 * @param string $polyline
	 * @return RoutesMatching
	 */
	public function setEnd($polyline){
		$this->end = $polyline;
		return $this;
	}

	/**
	 * @return void
	 */
	public function find(){
		// action
	}
}