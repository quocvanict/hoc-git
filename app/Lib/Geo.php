<?php

class Geo {

    protected $config = [];
    protected $pi = 3.1415926;
    protected $earthRadius = 3958;
    protected $meters = 1.609344;

    public function __construct($point, $f, $s) {
        $this->config['point'] = $point;
        $this->config['f'] = $f;
        $this->config['s'] = $s;
    }

    public function getGeoDistancePointToPoint($lat1, $lon1, $lat2, $lon2) {
      return self::distance(['lat' => $lat1, 'lng' => $lon1], ['lat' => $lat2, 'lng' => $lon2]);
      // return ($this->earthRadius * $this->pi * sqrt(($lat2 - $lat1) * ($lat2 - $lat1) + cos($lat2 / 57.29578) * cos($lat1 / 57.29578) * ($lon2 - $lon1) * ($lon2 - $lon1)) / 180) * $this->meters;
    }

    //height from C to AB
    protected function getHeightFromBaseTriangle($ab, $ac, $bc) {
        $s = ($ab + $ac + $bc) / 2;
        $area = sqrt($s * ($s - $ab) * ($s - $ac) * ($s - $bc));
        $height = $area / (.5 * $ab);
        return $height;
    }

    protected function getAnglesFromSides($ab, $bc, $ac) {
        $a = $bc;
        $b = $ac;
        $c = $ab;
        @$angle['a'] = rad2deg(acos((pow($b, 2) + pow($c, 2) - pow($a, 2)) / (2 * $b * $c)));
        @$angle['b'] = rad2deg(acos((pow($c, 2) + pow($a, 2) - pow($b, 2)) / (2 * $c * $a)));
        @$angle['c'] = rad2deg(acos((pow($a, 2) + pow($b, 2) - pow($c, 2)) / (2 * $a * $b)));
        return $angle;
    }

    public function calculate() {
        $ab = $this->getGeoDistancePointToPoint($this->config['f']['lat'], $this->config['f']['lng'], $this->config['s']['lat'], $this->config['s']['lng']);
        $ac = $this->getGeoDistancePointToPoint($this->config['f']['lat'], $this->config['f']['lng'], $this->config['point']['lat'], $this->config['point']['lng']);
        $bc = $this->getGeoDistancePointToPoint($this->config['s']['lat'], $this->config['s']['lng'], $this->config['point']['lat'], $this->config['point']['lng']);
        if ($ac == 0 || $bc == 0)
            return 0; //A trung C hoac B trung C
        if ($ab == 0)
            return $ac; // A trung B
        $angle = $this->getAnglesFromSides($ab, $bc, $ac);
        if ($angle['a'] <= 90 && $angle['b'] <= 90) {
            return $this->getHeightFromBaseTriangle($ab, $ac, $bc);
        } else {
            return ($ac > $bc) ? $bc : $ac;
        }
    }

    //xet source C, destination D voi 1 step AB tren route. Neu ca C va D deu thoa man gan AB.
    //vay ta can xet C-> D co cung chieu voi A->B khong.
    //Goi H la chan duong cao ha tu C xuong AB. Vay ta se kiem tra goc DHA.
    //Neu DHA > 90. tuc C->D cung chieu A->B
    public function checkPointD($pointD) {
        $AB = $this->getGeoDistancePointToPoint($this->config['f']['lat'], $this->config['f']['lng'], $this->config['s']['lat'], $this->config['s']['lng']);
        $AC = $this->getGeoDistancePointToPoint($this->config['f']['lat'], $this->config['f']['lng'], $this->config['point']['lat'], $this->config['point']['lng']);
        $BC = $this->getGeoDistancePointToPoint($this->config['s']['lat'], $this->config['s']['lng'], $this->config['point']['lat'], $this->config['point']['lng']);
        $AD = $this->getGeoDistancePointToPoint($this->config['s']['lat'], $this->config['s']['lng'], $pointD['lat'], $pointD['lng']);
        $BD = $this->getGeoDistancePointToPoint($this->config['s']['lat'], $this->config['s']['lng'], $pointD['lat'], $pointD['lng']);
        $cosAngleCAB = ($AC == 0) ? -1 : (pow($AB, 2) + pow($AC, 2) - pow($BC, 2)) / (2 * $AB * $AC);
        $cosAngleDAB = ($AD == 0) ? 1 : (pow($AD, 2) + pow($AB, 2) - pow($BD, 2)) / (2 * $AD * $AB);
        if ($cosAngleDAB <= 0) {
            return 0;
        } else if ($cosAngleCAB <= 0 && $cosAngleDAB > 0) {
            return 1;
        } else {
            $cosAngleCBA = ($BC == 0) ? 1 : (pow($AB, 2) + pow($BC, 2) - pow($AC, 2)) / (2 * $AB * $BC);
            $cosAngleDBA = ($BD == 0) ? -1 : (pow($AB, 2) + pow($BD, 2) - pow($AD, 2)) / (2 * $AB * $BD);
            if ($cosAngleCBA <= 0) {
                return 0;
            } else if ($cosAngleCBA > 0 && $cosAngleDBA <= 0) {
                return 1;
            } else {
                $AH = $AC * $cosAngleCAB;
                $DH = sqrt(pow($AD, 2) + pow($AH, 2) - 2 * $AD * $AH * $cosAngleDAB);
                $cosAngleDHA = (pow($AH, 2) + pow($DH, 2) - pow($AD, 2)) / (2 * $AH * $DH);
                if ($cosAngleDHA <= 0) {
                    return 1;
                } else {
                    return 0;
                }
            }
        }
    }

    public static function getAngle($a, $b, $c) {
        $f = sqrt(pow($b['lat'] - $a['lat'], 2) + pow($b['lng'] - $a['lng'], 2));
        $s = sqrt(pow($b['lat'] - $c['lat'], 2) + pow($b['lng'] - $c['lng'], 2));
        $t = sqrt(pow($c['lat'] - $a['lat'], 2) + pow($c['lng'] - $a['lng'], 2));

        return rad2deg(acos(($s * $s + $f * $f - $t * $t) / (2 * $s * $f)));
    }

    public static function distance($p1, $p2, $unit = 'K') {
        $lat1 = $p1['lat'];
        $lon1 = $p1['lng'];

        $lat2 = $p2['lat'];
        $lon2 = $p2['lng'];

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

}
