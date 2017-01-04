<?php    
class UploadComponent extends Component {
	
    public function start_upload($file_Details) {
		//echo "<pre>@@@";

		$extension = explode("/", $file_Details['type']);
		$filename = uniqid().'.'.$extension[1];
		$file_path =   WWW_ROOT  . 'uploads/media/'.$filename;
		move_uploaded_file($file_Details['tmp_name'],$file_path);
		return $filename;
	}
	
	
} 
?>