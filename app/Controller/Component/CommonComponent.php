<?php

App::uses('Component', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class CommonComponent extends Component {

//called before Controller::beforeFilter()
    public function initialize(Controller $controller) {
        
    }

    public function convert_phone_number($phone) {
        if ($phone[3] == '0') {
            $phone = substr_replace($phone, '', 3, 1);
        }
        return $phone;
    }


}
?>

