<?php
require_once ('../models/AdminModel.php');

class AdminController {
    public function index() {
        $adminModel = new Admin(5);
        $users = $adminModel->getUser(); // Fetch users properly
        return $users;
        // include(__DIR__ . '/../views/Admin.php'); // Pass data to the view
    }
} 
        ?>