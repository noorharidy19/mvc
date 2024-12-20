<?php
require_once(__DIR__ . '/../models/PatientModel.php');

class PatientController {
    public static function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Retrieve form inputs
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $userType = 'Patient'; // Assuming userType is 'Patient' for signup
            $dob = $_POST['dob'];

            // Create a new PatientModel instance
            $patient = new Patient($name, $email, $password, $phone, $address, $userType, $dob);

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