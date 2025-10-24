<?php
// File: /web/controller/admin/StatisticsContr.php

require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/admin/StatisticsClass.php"; 

class StatisticsContr extends StatisticsClass {

    public function __construct() {
        // Constructor rỗng
    }

    /**
     * Phương thức công khai để View gọi và lấy báo cáo.
     * @param string $fromDate
     * @param string $toDate
     * @return array Dữ liệu báo cáo.
     */
    public function showTopCustomersReport($fromDate, $toDate) {
        $reportData = $this->getTopCustomersByDateRange($fromDate, $toDate);
        return $reportData;
    }
}
?>