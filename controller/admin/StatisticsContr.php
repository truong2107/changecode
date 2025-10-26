<?php


require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/admin/StatisticsClass.php"; 

class StatisticsContr extends StatisticsClass {

    public function __construct() {
        // Constructor rỗng
    }

    public function showTopCustomersReport($fromDate, $toDate) {
        $reportData = $this->getTopCustomersByDateRange($fromDate, $toDate);
        return $reportData;
    }
}
?>