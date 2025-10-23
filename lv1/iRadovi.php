<?php
interface iRadovi {
    public function create();
    public function save($conn);
    public function read($conn);
}
?>