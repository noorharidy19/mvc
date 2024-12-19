<?php
include 'DB.php';
requireonce(_ROOT__ . "models/UserModel.php");

?>
<?php
Class Patient extends User{
  public function __construct($id) {
    parent::__construct($id);
  }
}

?>