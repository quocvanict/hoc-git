<?php

// require_once 'HTTP/Request2.php';

class VuforiaComponent extends Component {

    public $components = array('SignatureBuilder');


    public $access_key;
    public $secret_key;

    //private $targetId 		= "eda03583982f41cdbe9ca7f50734b9a1";
    public $url = "https://vws.vuforia.com";
    public $requestPath = "/targets";
    public $_request;       // the HTTP_Request2 object
    public $jsonRequestObject;

    public $targetName;
    public $imageLocation;
	
	// public function __construct($var){
		// $Configuration = ClassRegistry::init('Configuration');
		
		 
		// $results = $Configuration->find('first');
		
		// print"<pre>";
		// print_r('results');
		// die;
		
		
        // $results = Set::extract('/Configuration/.', $results);
		
		
	// }
	
	public function __construct() {
		$this->Configuration = ClassRegistry::init('Configuration');
		$results = $this->Configuration->find('first');
 
		$this->access_key = $results['Configuration']['server_access_key'] ; 
		$this->secret_key = $results['Configuration']['server_secret_key'] ; 
	}
	
    public function execGetAllTargets()
    {


        $this->_request = new HTTP_Request2();
        $this->_request->setMethod(HTTP_Request2::METHOD_GET);

        $this->_request->setConfig(array(
            'ssl_verify_peer' => false
        ));

        $this->_request->setURL($this->url . $this->requestPath);


        // Define the Date and Authentication headers
        $sb = $this->SignatureBuilder;
        $date = new DateTime("now", new DateTimeZone("GMT"));

        // Define the Date field using the proper GMT format
        $this->_request->setHeader('Date', $date->format("D, d M Y H:i:s") . " GMT");
        // Generate the Auth field value by concatenating the public server access key w/ the private query signature for this request
        $this->_request->setHeader("Authorization", "VWS " . $this->access_key . ":" . $sb->tmsSignature($this->_request, $this->secret_key));
        $json_return = '';

        try {

            $response = $this->_request->send();

            if (200 == $response->getStatus()) {


                $json_return = $response->getBody();
            } else {
                $json_return = $response->getStatus() . ' ' .
                    $response->getReasonPhrase() . ' ' . $response->getBody();
            }
        } catch (HTTP_Request2_Exception $e) {
            $json_return = 'Error: ' . $e->getMessage();
        }
        return $json_return;

    }
    public function execPostNewTarget()
    {

        $this->_request = new HTTP_Request2();
        $this->_request->setMethod(HTTP_Request2::METHOD_POST);
        $this->_request->setBody($this->jsonRequestObject);

        $this->_request->setConfig(array(
            'ssl_verify_peer' => false
        ));

        $this->_request->setURL($this->url . $this->requestPath);

        // Define the Date and Authentication headers
        $sb = $this->SignatureBuilder;
        $date = new DateTime("now", new DateTimeZone("GMT"));

        // Define the Date field using the proper GMT format
        $this->_request->setHeader('Date', $date->format("D, d M Y H:i:s") . " GMT");

        $this->_request->setHeader("Content-Type", "application/json");
        // Generate the Auth field value by concatenating the public server access key w/ the private query signature for this request
        $this->_request->setHeader("Authorization", "VWS " . $this->access_key . ":" . $sb->tmsSignature($this->_request, $this->secret_key));


        $json_return = '';

        try {

            $response = $this->_request->send();

            if (200 == $response->getStatus() || 201 == $response->getStatus()) {
                $json_return = $response->getBody();

            } else {
                $json_return = $response->getBody();


            }
        } catch (HTTP_Request2_Exception $e) {
            $json_return = $e->getMessage().'xx';
        }

        return $json_return;

    }

    public function execUpdateTarget($jsonBody = null , $target_id = null){



        $this->_request = new HTTP_Request2();
        $this->_request->setMethod( HTTP_Request2::METHOD_PUT );
        $this->_request->setBody( $jsonBody );

        $this->_request->setConfig(array(
            'ssl_verify_peer' => false
        ));

        $this->_request->setURL( $this->url . $this->requestPath . '/' . $target_id);
        $json_return = '';

        // Define the Date and Authentication headers
        $sb = $this->SignatureBuilder;
        $date = new DateTime("now", new DateTimeZone("GMT"));

        // Define the Date field using the proper GMT format
        $this->_request->setHeader('Date', $date->format("D, d M Y H:i:s") . " GMT" );
        $this->_request->setHeader("Content-Type", "application/json" );
        // Generate the Auth field value by concatenating the public server access key w/ the private query signature for this request
        $this->_request->setHeader("Authorization" , "VWS " . $this->access_key . ":" . $sb->tmsSignature( $this->_request , $this->secret_key ));


        try {

            $response = $this->_request->send();

            if (200 == $response->getStatus()) {

                $json_return = $response->getBody();
            } else {
                $json_return =  $response->getStatus() . ' ' .
                    $response->getReasonPhrase(). ' ' . $response->getBody();
            }
        } catch (HTTP_Request2_Exception $e) {
            $json_return = 'Error: ' . $e->getMessage();
        }
        return $json_return;

    }


    private function execGetTarget(){

        $this->_request = new HTTP_Request2();
        $this->_request->setMethod( HTTP_Request2::METHOD_GET );

        $this->_request->setConfig(array(
            'ssl_verify_peer' => false
        ));

        $this->_request->setURL( $this->url . $this->requestPath );

        // Define the Date and Authentication headers
        $sb = $this->SignatureBuilder;
        $date = new DateTime("now", new DateTimeZone("GMT"));

        // Define the Date field using the proper GMT format
        $this->_request->setHeader('Date', $date->format("D, d M Y H:i:s") . " GMT" );
        // Generate the Auth field value by concatenating the public server access key w/ the private query signature for this request
        $this->_request->setHeader("Authorization" , "VWS " . $this->access_key . ":" . $sb->tmsSignature( $this->_request , $this->secret_key ));



        try {

            $response = $this->_request->send();

            if (200 == $response->getStatus()) {
                echo $response->getBody();
            } else {
                echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                    $response->getReasonPhrase(). ' ' . $response->getBody();
            }
        } catch (HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }


    }

    public function execDeleteTarget($target_id = null)
    {


        $this->_request = new HTTP_Request2();
        $this->_request->setMethod(HTTP_Request2::METHOD_DELETE);

        $this->_request->setConfig(array(
            'ssl_verify_peer' => false
        ));


        $this->_request->setURL($this->url . $this->requestPath . '/' . $target_id);


        // Define the Date and Authentication headers
        $sb = $this->SignatureBuilder;
        $date = new DateTime("now", new DateTimeZone("GMT"));

        // Define the Date field using the proper GMT format
        $this->_request->setHeader('Date', $date->format("D, d M Y H:i:s") . " GMT");
        // Generate the Auth field value by concatenating the public server access key w/ the private query signature for this request
        $this->_request->setHeader("Authorization", "VWS " . $this->access_key . ":" . $sb->tmsSignature($this->_request, $this->secret_key));


        try {

            $response = $this->_request->send();

            if (200 == $response->getStatus()) {
                $json_return = $response->getBody();
            } else {
                $json_return = $response->getBody();
            }
        } catch (HTTP_Request2_Exception $e) {
            $json_return = $e->getMessage();
        }
        return $json_return;

    }


    function PostNewTarget($target_width, $targetName, $imageFile)
    {


        $this->jsonRequestObject = json_encode(array('width' => $target_width, 'name' => $targetName, 'image' => $this->getImageAsBase64($imageFile), 'application_metadata' => base64_encode("Vuforia test metadata"), 'active_flag' => 1));

        return $this->execPostNewTarget();

    }

    function getImageAsBase64($imageFile)
    {


        $file = file_get_contents($imageFile);

        if ($file) {

            $file = base64_encode($file);
            return $file;
        }else{

            return false;
        }


    }

    function mapTargetData($collection)
    {
        $new_arr = array();

        foreach($collection as $key => $_target){
            $res_target = $this->VuforiaTarget->find('first', array(
                'conditions' => array(
                    'VuforiaTarget.target_id' => $_target,
                )
            ));
            $new_arr[$key] = array('target_cloud'=>$_target,'target_relationship'=>$res_target);

        }
        return $new_arr;
    }

} 
?>