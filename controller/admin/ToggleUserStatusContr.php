<?php


require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/admin/ToggleUserStatusClass.php"; 

class ToggleUserStatusContr extends ToggleUserStatusClass {
    private $id;
    private $currentStatus;

    public function __construct($id, $currentStatus) {
        $this->id = $id;
        $this->currentStatus = $currentStatus;
    }

    public function processStatusToggle() {
        $this->toggleStatus($this->id, $this->currentStatus);
    }
}
?>