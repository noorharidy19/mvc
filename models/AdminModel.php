
<?php 
require_once(__DIR__ . '/../models/UsersModel.php');
Class Admin extends User{
    private $db;
    
  public function __construct($id) {
    parent::__construct($id);
   
  }
  public static function addUser($name, $email, $password, $phone, $address, $userType, $DOb, $gender) {
        

    // Prepare the SQL statement
    $sql = "INSERT INTO users (Name, phone, Email, Password, gender, Address, UserType, DOB) 
            VALUES ('$name', '$phone', '$email', '$password', '$gender', '$address', '$userType', '$DOb')";
  
    // Execute the query
    if (mysqli_query($GLOBALS['conn'], $sql)) {
        return true; // User added successfully
    } else {
        // Debugging: Print error message
        error_log("Failed to execute query: " . mysqli_error($GLOBALS['conn']));
        return false; // Failed to add user
    }
  }
  public static function getUser() {
    $sql = "SELECT * FROM users";
    $result = mysqli_query($GLOBALS['conn'], $sql);

    $users = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }
    return $users;
}
}

?>