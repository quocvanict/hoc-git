<?php

class PaymentShell extends Shell {

    public $uses = array('User', 'Transaction', 'Travel', 'DriverPayment');

    public function main() {
        try {
            $this->out('start payment');
            //get date in previous
            $pre_month = date("Y-m-d", strtotime("-1 month"));
//            $pre_month = date("Y-m-d");
            $ex = explode('-', $pre_month);
            $month = $ex[1];
            $day = cal_days_in_month(CAL_GREGORIAN, $month, $ex[0]);
            $start_date = $ex[0] . '-' . $ex[1] . "-1 00:00:00";
            $end_date = $ex[0] . '-' . $ex[1] . '-' . $day . " 00:00:00";
            //condition 
            $conditions = array();
            $conditions[1] = "Transaction.created_datetime <= '{$end_date}'";
            $conditions[2] = "Transaction.created_datetime > '{$start_date}'";
            $cond = array(
                'fields' => array("DISTINCT Transaction.driver_id", "User.*"),
                'conditions' => $conditions,
                'joins' => array(
                    array(
                        'table' => 'users',
                        'alias' => 'User',
                        'type' => 'inner',
                        'conditions' => array(
                            "User.id=Transaction.driver_id"
                        )
                    ),
                ),
                'order' => array('Transaction.id' => 'Desc')
            );
            $dataSource = $this->Transaction->getDataSource();
            $list_driver = $this->Transaction->find('all', $cond);
            $list_user = '';
            foreach ($list_driver as $key => $value) {
                $driver_id = $value['Transaction']['driver_id'];
                $this->out($driver_id);
                $conditions[3] = "Transaction.driver_id = {$driver_id}";
                $sum = $this->Transaction->find('all', array(
                    'conditions' => $conditions,
                    'fields' => 'sum(Transaction.price*(100-Transaction.tax)*0.01) as total_sum',
                    'joins' => array(
                        array(
                            'table' => 'travels',
                            'alias' => 'Travel',
                            'type' => 'inner',
                            'conditions' => array(
                                "Travel.id=Transaction.travel_id AND Travel.state=6"
                            )
                        ),
                    ),
                ));
                $sum = floor($sum[0][0]['total_sum']);
                // save data in table driver_payments
                //check exist payment in driver payment
                $cond_check_pay = array(
                    'conditions' => array(
                        'DriverPayment.driver_id' => $driver_id,
                        'DriverPayment.month' => $month,
                        'DriverPayment.year' => $ex[0],
                    )
                );
                if (!$this->DriverPayment->find('all', $cond_check_pay)) {
                    $data_save = array(
                        'month' => $month,
                        'year' => $ex[0],
                        'driver_id' => $driver_id,
                        'estimated_amount' => $sum,
//                        'transferred_amount' => $sum,
                        'status' => 0,
                        'updated_datetime' => date('Y-m-d H:i:s'),
                    );
                    $this->DriverPayment->clear();
                    if ($this->DriverPayment->save($data_save)) {
                        $list_user = $list_user . ',' . $value['User']['name'];
                    }
                }
                $dataSource->commit();
            }
            $this->out("Calculate payment for driver : " . $list_user);
            $this->out('Done');
        } catch (Exception $exc) {
            $dataSource->rollback();
        }
    }

}
