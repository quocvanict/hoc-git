<?php
class CheckExpiredTripsShell extends AppShell {
  public function main() {
    require_once dirname(APP) . '/vendor/autoload.php';
    $this->loadModel('Trip');
    $trips = $this->Trip->find('all', ['conditions' =>
      ['trip_status' => TRIP_STATUS_ON_PROCESSING]
    ]);

    $ids = [];
    foreach($trips as $trip){
      $date = new DateTime($trip['Trip']['departure_datetime']);
      $today = new DateTime(date('Y-m-d'));
      $valid = $date->getTimestamp() < $today->getTimestamp();
      if($valid){
        $ids[] = $trip['Trip']['id'];
      }
    }
    $this->Trip->updateAll(
      ['trip_status' => TRIP_STATUS_EXPIRED],
      ['id' => $ids]
    );
    return $this->out('Task completed: CheckExpiredTripsShell.');
  }
}