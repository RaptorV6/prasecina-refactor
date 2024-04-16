<?php
$connect = new PDO("mysql:host=localhost;dbname=testing", "root", "");
$message = '';
if(isset($_POST["email"]))
{
 sleep(5);
 $query = "
 INSERT INTO tbl_login 
 (first_name, last_name, gender, email, password, address, mobile_no) VALUES 
 (:first_name, :last_name, :gender, :email, :password, :address, :mobile_no)
 ";
 $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
 $user_data = array(
  ':first_name'  => $_POST["first_name"],
  ':last_name'  => $_POST["last_name"],
  ':gender'   => $_POST["gender"],
  ':email'   => $_POST["email"],
  ':password'   => $password_hash,
  ':address'   => $_POST["address"],
  ':mobile_no'  => $_POST["mobile_no"]
 );
 $statement = $connect->prepare($query);
 if($statement->execute($user_data))
 {
  $message = '
  <div class="alert alert-success">
  Registration Completed Successfully
  </div>
  ';
 }
 else
 {
  $message = '
  <div class="alert alert-success">
  There is an error in Registration
  </div>
  ';
 }
}
?>