<?php
require_once(__DIR__ . "/../models/UsersModel.php");


Class Patient extends User{
  public function __construct($id) {
    parent::__construct($id);

  }

  public function signup() {
    global $conn;

    // Start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Check if email already exists
    $emailCheckQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($emailCheckQuery);
    $stmt->bind_param("s", $this->getEmail());
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already exists
        $_SESSION['error'] = "Email already exists. Please use a different email.";
        return false;
    }

    // Hash the password
    $hashedPassword = password_hash($this->getPassword(), PASSWORD_DEFAULT);

    // Insert the user into the database
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone, address, userType, DOb) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $this->getName(), $this->getEmail(), $hashedPassword, $this->getPhone(), $this->getAddress(), $this->getUserType(), $this->getDOb());

    if ($stmt->execute()) {
        // Set the user ID for the newly created user
        $this->ID = $stmt->insert_id;
        $_SESSION['user_id'] = $this->ID; // Set session for the logged-in user
        return true;
    } else {
        error_log("Database Error: " . $stmt->error);
        return false;
    }
}

}




?>



