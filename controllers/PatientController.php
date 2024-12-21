<?php
require_once(__DIR__ . '/../models/PatientModel.php');

class PatientController {
    public static function create() {

         $patient = new Patient(); 

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ID = 0;
            $patient->setName($_POST['name'] ?? '');
            $patient->setEmail($_POST['email'] ?? '');
            $patient->setPassword($_POST['password'] ?? '');
            $patient->setPhone($_POST['phone'] ?? '');
            $patient->setAddress($_POST['address'] ?? '');
            $patient->setUserType('Patient'); // Hardcoded 'Patient'
            $patient->setDob($_POST['dob'] ?? '');

            // Call the signup method
            if ($patient->signup()) {
                echo "Signup successful!";
                // Redirect to login page or patient dashboard
                header("Location: login.php");
                exit();
            } else {
                echo "Signup failed!";
            }
        }
    }
}
?>