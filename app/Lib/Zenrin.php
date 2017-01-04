<?php

class Zenrin {

    public $curl;
    public $staticUrl = 'http://api.its-mo.com/cgi/jsapi/';
    public $params = '?id=JSZ811bed519fca&encode=EUC&request=';
    public function __construct() {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_HEADER, 0);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
            'Referer:http://'.$_SERVER['HTTP_HOST']
        ));
    }

    public function getPoiByLatLon($request) {
        $url = $this->staticUrl. 'poi/latlon'. $this->params. json_encode($request);
        curl_setopt($this->curl, CURLOPT_URL, $url);
        $html = curl_exec($this->curl);
        curl_close ($this->curl);
        $data = json_decode($html,true);
        return $data;
    }

}
