<?php

include 'XMPPHP/XMPP.php';

class Xmpp {

    public $conn;

    public function __construct($username, $password) {
        $host = Configure::read('openfire.server');
        if($host == '52.197.181.196'){
            $host = 'localhost';
        }
        $this->conn = new XMPPHP_XMPP($host, Configure::read('openfire.port'), $username, $password, 'admincp');
    }

    public function connect() {
        try {
            $this->conn->connect();
            $this->conn->processUntil('session_start');
            return TRUE;
        } catch (XMPPHP_Exception $e) {
            return FALSE;
        }
    }

    public function send_message($to, $data) {
        try {
            $to = $to . '@' . Configure::read('openfire.server');
            $this->conn->message($to, $data);
            return TRUE;
        } catch (XMPPHP_Exception $e) {
            return FALSE;
        }
    }

    public function disconnect() {
        $this->conn->disconnect();
    }

}
