<?php
require_once ('../models/PatientModel.php');

class PatientController {
 public static function save(){
$patientClass = new User(NULL);
global $conn;

$error = "";
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $address = htmlspecialchars($_POST["address"]);
    $dob = htmlspecialchars($_POST["dob"]);
    $gender= htmlspecialchars($_POST["gender"]);   

    $userType = 'patient'; // Default user type

    // Function to check if email exists
    function emailExists($email, $conn) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0; // Returns true if email exists
    }

    // Check if email already exists
    if (emailExists($email, $conn)) {
        $_SESSION['error'] = "Email already exists. Please use a different email.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL insert statement
    $sql = "INSERT INTO users (name, email, password, phone, address, userType, DOb) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $name, $email, $hashedPassword, $phone, $address, $userType, $dob);
    
    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Sign-up failed. Please try again.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

 }
 

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