<?php
require_once(__DIR__ . '/../models/UsersModel.php');
?>
<?php
class Doctor extends User {
    private $timeSlots = [];

    public function __construct($id) {
        parent::__construct($id);
    }

    public function addTimeSlot($startTime, $endTime) {
        $this->timeSlots[] = ['startTime' => $startTime, 'endTime' => $endTime];
    }

    public function getTimeSlots() {
        return $this->timeSlots;
    }

    public static function addSlot($doctorId, $day, $startTime, $endTime) {
        // Ensure user is a doctor
        $stmt = $GLOBALS['conn']->prepare("SELECT UserType FROM users WHERE ID = ?");
        $stmt->bind_param("i", $doctorId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user['UserType'] !== 'Doctor') {
            return false;
        }
        $currentDate = date("Y-m-d"); // Get today's date in YYYY-MM-DD format
        if ($day < $currentDate) {
            // Set a session error message for a past date
            $_SESSION['error'] = "You cannot add a slot for a past day. Please choose a future date.";
            return false; // Return false to indicate the error
        }
    

        // Prepare the SQL statement
        $sql = "INSERT INTO doctor (doctor_id, day, start_time, end_time) 
                VALUES ('$doctorId', '$day', '$startTime', '$endTime')";

        // Execute the query
        if (mysqli_query($GLOBALS['conn'], $sql)) {
            return true; // Slot added successfully
        } else {
            // Debugging: Print error message
            error_log("Failed to execute query: " . mysqli_error($GLOBALS['conn']));
            return false; // Failed to add slot
        }
    }

    
    public function getSlots() {
        $sql = "SELECT * FROM doctor WHERE doctor_id = ?";
        $stmt = $GLOBALS['conn']->prepare($sql);
        $doctorId = $this->getID();
        $stmt->bind_param("i", $doctorId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $slots = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $slots[] = $row;
            }
        }
        return $slots;
    }
}
?>