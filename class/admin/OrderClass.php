<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";

class OrderClass extends DataBaseClass {

    protected function getAllOrders() {
        $conn = $this->connect();
        $sql = "SELECT * FROM hoadon ORDER BY IdHoaDon DESC";
        return $conn->query($sql);
    }

    protected function checkOrdersLength() {
        $conn = $this->connect();
        $sql = "SELECT COUNT(*) AS totalOrders FROM hoadon";
        $result = $conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return (int)$row['totalOrders'];
        }
        return 0;
    }

    protected function getDistinctDistricts() {
        $conn = $this->connect();
        $sql = "SELECT DISTINCT quan_huyen FROM hoadon ORDER BY (quan_huyen REGEXP 'Quận [0-9]+') DESC, CAST(SUBSTRING_INDEX(quan_huyen, ' ', -1) AS UNSIGNED)";
        return $conn->query($sql);
    }

    protected function getDistinctWards($district) {
        $conn = $this->connect();
        $safe_district = $conn->real_escape_string($district);
        $sql = "SELECT DISTINCT phuong_xa FROM hoadon WHERE quan_huyen = '$safe_district'";
        return $conn->query($sql);
    }

    protected function filterOrders($status, $district, $ward, $start_date, $end_date) {
        $conn = $this->connect();
        $sql = "SELECT * FROM hoadon";
        $conditions = [];

        if (!empty($status) && $status != 'all') {
            $conditions[] = "TrangThai = '$status'";
        }
        if (!empty($district) && $district != 'all') {
            $conditions[] = "quan_huyen = '$district'";
        }
        if (!empty($ward) && $ward != 'all') {
            $conditions[] = "phuong_xa = '$ward'";
        }
        if (!empty($start_date)) {
            if (strpos($start_date, ':') === false) $start_date .= " 00:00:00";
            $conditions[] = "NgayDatHang >= '$start_date'";
        }
        if (!empty($end_date)) {
            if (strpos($end_date, ':') === false) $end_date .= " 23:59:59";
            $conditions[] = "NgayDatHang <= '$end_date'";
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY IdHoaDon DESC";
        return $conn->query($sql);
    }

    protected function getDistrictsByDate($start_date, $end_date) {
        $conn = $this->connect();

        $conditions = [];
        if (!empty($start_date)) {
            if (strpos($start_date, ':') === false) $start_date .= " 00:00:00";
            $conditions[] = "NgayDatHang >= '$start_date'";
        }
        if (!empty($end_date)) {
            if (strpos($end_date, ':') === false) $end_date .= " 23:59:59";
            $conditions[] = "NgayDatHang <= '$end_date'";
        }

        $sql = "SELECT DISTINCT quan_huyen FROM hoadon";
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $sql .= " ORDER BY (quan_huyen REGEXP 'Quận [0-9]+') DESC, CAST(SUBSTRING_INDEX(quan_huyen, ' ', -1) AS UNSIGNED)";

        return $conn->query($sql);
    }
}
?>
