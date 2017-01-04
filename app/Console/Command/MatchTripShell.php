<?php

App::uses('TripApiController', 'Api');
App::uses('Xmpp', 'Lib');
require_once APP . '/Lib/Geo.php';
require_once APP . '/Lib/gmo/config.php';
require_once APP . '/Lib/gmo/common/ErrorMessageHandler.php';

class MatchTripShell extends Shell {

    public $uses = array('Trip', 'Travel');

    public function main() {
        $trip_api = new TripApiController();
        try {
            $this->out('------------------------Start match trip------------------------');
            $trip_data = $this->Trip->find('all', array(
                'conditions' => array(
                    'trip_status' => TRIP_STATUS_ON_PROCESSING,
                    'state' => TRIP_STATE_UNMATCHED
                )
            ));
            $list_trip = '';
            if (!$trip_data) {
                $this->out('Done');
            } else {
                $travel_state = TRAVEL_STATE_MATCHED;

                foreach ($trip_data as $key => $trip) {
                    $conditions['departure_datetime'] = $trip['Trip']['departure_datetime'];
                    $conditions['user_id'] = $trip['Trip']['user_id'];
                    $flag = 0;
                    if ($trip['Trip']['trip_type'] == PASSENGER) {
                        $driver_trips = $this->Trip->get_be_able_matching_driver_trips($conditions);
                        if (empty($driver_trips)) {
                            $this->out('No matching');
                        } else {
                            $msg = "マッチングしました。ステップ②より同乗者を承認してください。";
                            $receiver['user_type'] = DRIVER;
                            $sender['user_type'] = PASSENGER;
                            foreach ($driver_trips as $driver_trip) {
                                if ($this->match_using_overview_polyline($trip['Trip']['source_coordinate'], $trip['Trip']['destination_coordinate'], $driver_trip['Trip']['steps'])) {
                                    $this->Travel->save(array('driver_trip_id' => $driver_trip['Trip']['id'], 'passenger_trip_id' => $trip['Trip']['id'], 'state' => TRAVEL_STATE_MATCHED));
                                    $this->Travel->clear();

                                    $receiver['trip_id'] = $driver_trip['Trip']['id'];
                                    $sender['trip_id'] = $trip['Trip']['id'];
                                    $travel_id = $this->Travel->getInsertID();
                                    $trip_api->push($driver_trip['Trip']['user_id'], $sender, $receiver, $travel_id, $travel_state, $msg, $trip['Trip']['user_id']);
                                    $flag = 1;
                                    $last_user_id = $driver_trip['Trip']['user_id'];
                                    $last_trip_id = $driver_trip['Trip']['id'];
                                    $this->Trip->clear();
                                    $this->Trip->save(array('id' => $driver_trip['Trip']['id'], 'matching_popup' => 0));
                                    $this->out('Has matching: ' . $trip['Trip']['id']);
                                }
                            }
                            if ($flag == 1) {
                                $msg = "マッチングしました。ドライバーに承認されるまでお待ち下さい。";
                                $receiver['trip_id'] = $trip['Trip']['id'];
                                $receiver['user_type'] = PASSENGER;
                                $sender['trip_id'] = $last_trip_id;
                                $sender['user_type'] = DRIVER;
                                $sender_id = $last_user_id;
                            }
                        }
                    } elseif ($trip['Trip']['trip_type'] == DRIVER) {
                        $passenger_trips = $this->Trip->get_be_able_matching_passenger_trips($conditions);
                        if (empty($passenger_trips)) {
                            $this->out('No matching');
                        } else {
                            $msg = "マッチングしました。ドライバーに承認されるまでお待ち下さい。";
                            $sender['user_type'] = DRIVER;
                            $receiver['user_type'] = PASSENGER;
                            foreach ($passenger_trips as $passenger_trip) {
                                if ($this->match_using_overview_polyline($passenger_trip['Trip']['source_coordinate'], $passenger_trip['Trip']['destination_coordinate'], $trip['Trip']['steps'])) {
                                    $this->Travel->save(array('driver_trip_id' => $trip['Trip']['id'], 'passenger_trip_id' => $passenger_trip['Trip']['id'], 'state' => TRAVEL_STATE_MATCHED));
                                    $this->Travel->clear();
                                    $receiver['trip_id'] = $passenger_trip['Trip']['id'];
                                    $sender['trip_id'] = $trip['Trip']['id'];
                                    $travel_id = $this->Travel->getInsertID();
                                    $trip_api->push($passenger_trip['Trip']['user_id'], $sender, $receiver, $travel_id, $travel_state, $msg, $trip['Trip']['user_id']);

                                    $flag = 1;
                                    $last_user_id = $passenger_trip['Trip']['user_id'];
                                    $last_trip_id = $passenger_trip['Trip']['id'];
                                    $this->Trip->clear();
                                    $this->Trip->save(array('id' => $trip['Trip']['id'], 'matching_popup' => 0));
                                    $this->out('Has matching: ' . $trip['Trip']['id']);
                                }
                            }
                            if ($flag == 1) {
                                $msg = "マッチングしました。ステップ②より同乗者を承認してください。";
                                $receiver['trip_id'] = $trip['Trip']['id'];
                                $receiver['user_type'] = DRIVER;
                                $sender['trip_id'] = $last_trip_id;
                                $sender['user_type'] = PASSENGER;
                                $sender_id = $last_user_id;
                            }
                        }
                    }
                    $this->Trip->clear();
                    $this->Trip->save(array('id' => $trip['Trip']['id'], 'state' => TRIP_STATE_MATCHED));

                    if ($flag == 1) {
                        $trip_api->push($trip['Trip']['user_id'], $sender, $receiver, $travel_id, $travel_state, $msg, $sender_id);
                    }
                    $list_trip = $list_trip . ',' . $trip['Trip']['id'];
                }
            }
            $this->out('Id trip match :' . $list_trip);
            $this->out('------------------------End match trip------------------------');
        } catch (Exception $exc) {
            echo $exc->getMessage();
            die;
        }
    }

    protected function match_using_overview_polyline($source_coordinate, $destination_coordinate, $overview_polylines) {
        $trip_api = new TripApiController();
        if (!$source_coordinate || !$destination_coordinate || !$overview_polylines) {
            return false;
        }
        // if($source_coordinate == $destination_coordinate) return 0;
        $trip_api->__coordinateToArray($source_coordinate);
        $trip_api->__coordinateToArray($destination_coordinate);
        $accept_source = 0;
        $accept_destination = 0;
        $overview_polylines = split('@', $overview_polylines);
        foreach ($overview_polylines as $overview_polyline) {
            $overview_polyline = json_decode($overview_polyline, true);
            $count = count($overview_polyline);
            if ($count < 2)
                continue;
            for ($i = 0; $i < $count - 1; $i++) {
                if (!empty($overview_polyline[$i + 1])) {
                    $first_point = ['lat' => (float) $overview_polyline[$i]['lat'], 'lng' => (float) $overview_polyline[$i]['lng']];
                    $second_point = ['lat' => (float) $overview_polyline[$i + 1]['lat'], 'lng' => (float) $overview_polyline[$i + 1]['lng']];
                    if ($accept_source == 0) {
                        $g_source = new Geo($source_coordinate, $first_point, $second_point);
                        $distance_from_source = $g_source->calculate() * 1000;
                        if ($distance_from_source < MAX_DISTANCE) {
                            $accept_source = 1;
                            $g_destination = new Geo($destination_coordinate, $first_point, $second_point);
                            $distance_from_destination = $g_destination->calculate() * 1000;

                            if ($distance_from_destination < MAX_DISTANCE) {
                                $check = $g_source->checkPointD($destination_coordinate);
                                if ($check == 1) {
                                    $accept_destination = 1;
                                    break;
                                } else {
                                    break;
                                }
                            }
                        }
                    } else if ($accept_destination == 0) {
                        $g_destination = new Geo($destination_coordinate, $first_point, $second_point);
                        $distance_from_destination = $g_destination->calculate() * 1000;

                        if ($distance_from_destination < MAX_DISTANCE) {
                            $accept_destination = 1;
                            break;
                        }
                    }
                }
            }
            if ($accept_source == 1 && $accept_destination == 1)
                return 1;
        }
        return 0;
    }

}
