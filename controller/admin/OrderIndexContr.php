<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/admin/OrderClass.php"; 

class OrderIndexContr extends OrderClass{
    public function getAllOrders(){
        $result = parent::getAllOrders();
        $orders = [];

        if($result && $result->num_rows > 0){
            while($row = $result->fetch_assoc())
                $orders[] = $row;
        }else{
            return 0;
        }
        return $orders;       
    }

    public function checkOrdersLength(){
        return parent::checkOrdersLength();
    }

    public function getDistricts() {
        return parent::getDistinctDistricts();
    }

    public function getWards($district) {
        return parent::getDistinctWards($district);
    }

    public function filterOrders($status, $district, $ward, $start_date, $end_date) {
        $result = parent::filterOrders($status, $district, $ward, $start_date, $end_date);
        if (!$result || $result->num_rows === 0) return [];
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDistrictsByDate($start_date, $end_date) {
        return parent::getDistrictsByDate($start_date, $end_date);
    }
}

?>