<?php

class CheckEventShell extends AppShell {

    public function main() {
        $this->out('Start check Event');
        $this->loadModel('Event');
        $event_data = $this->Event->find('all', array(
            'conditions' => array(
                'Event.status' => 1,
            )
        ));
        $current_time = date('Y-m-d H:i:s');
        foreach ($event_data as $key => $value) {
            $held_time = $value['Event']['held_time'];
            $held_time = json_decode($held_time, true);
            $check = 0;
            foreach ($held_time as $key1 => $value1) {
                $check_time = date('Y-m-d H:i:s', strtotime($value1['end_time']));
                if ($current_time < $check_time) {
                    $check = 1;
                }
            }
            if (!$check) {
                $data_update = array(
                    'id' => $value['Event']['id'],
                    'expired' => 1
                );
                $this->Event->save($data_update);
                $this->Event->clear();
            }
        }
        $this->out('End check Event');
    }
}
