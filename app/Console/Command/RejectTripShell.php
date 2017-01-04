<?php

App::uses('TripApiController', 'Api');
App::uses('Xmpp', 'Lib');

class RejectTripShell extends Shell {

    public $uses = array('User', 'Transaction', 'Travel', 'Trip', 'DriverPayment');

    public function main() {
        try {
            $trip_api = new TripApiController();
            $this->out('-----------------Start reject trip---------------------- ');
            $id_trip = '';
            $pre_date = date('Y-m-d H:i:s', strtotime("-1 days"));
            $conditions = array(
                "conditions" => array(
                    "Travel.state" => TRAVEL_STATE_APPROVED,
                    "Travel.updated_datetime <= '{$pre_date}'"
                )
            );
            $data_check = $this->Travel->find("all", $conditions);
            if ($data_check) {
                foreach ($data_check as $key => $value) {
                    $arr_save = array(
                        'id' => $value['Travel']['id'],
                        'state' => TRAVEL_STATE_MATCHED
                    );
                    if ($this->Travel->save($arr_save)) {
                        $id_trip = $id_trip . ',' . $value['Travel']['id'];
                        $driver_trip = $this->Trip->find('first', array(
                            'conditions' => array(
                                'id' => $value['Travel']['driver_trip_id'],
                                'trip_status' => TRIP_STATUS_ON_PROCESSING
                            )
                        ));
                        $passenger_trip = $this->Trip->find('first', array(
                            'conditions' => array(
                                'id' => $value['Travel']['passenger_trip_id'],
                                'trip_status' => TRIP_STATUS_ON_PROCESSING
                            )
                        ));
                        if (!empty($driver_trip) && !empty($passenger_trip)) {
                            $sender['trip_id'] = $passenger_trip['Trip']['id'];
                            $sender['user_type'] = PASSENGER;
                            $receiver['trip_id'] = $driver_trip['Trip']['id'];
                            $receiver['user_type'] = DRIVER;
                            $travel_id = $value['Travel']['id'];
                            $travel_state = TRAVEL_STATE_MATCHED;
                            $msg = 'マッチング後24時間以内に同乗者からのお支払いがなかったため、この相乗りはキャンセルされました。別の同乗者を探してみましょう。';
                            $trip_api->push($driver_trip['Trip']['user_id'], $sender, $receiver, $travel_id, $travel_state, $msg, $passenger_trip['Trip']['user_id']);
                            $msg = 'マッチング後24時間以内にお支払い登録がなかったため、この相乗りはキャンセルされました。';
                            $trip_api->push($passenger_trip['Trip']['user_id'], $receiver, $sender, $travel_id, $travel_state, $msg, $driver_trip['Trip']['user_id']);
                        }
                    }
                    $this->Travel->clear();
                }
            }
            $this->out('Trip was rejected :' . $id_trip);
            $this->out('-----------------End reject trip---------------------- ');
        } catch (Exception $exc) {
            $this->out($exc->getMessage());
        }
    }

}
