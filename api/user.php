<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');

$db_conn = mysqli_connect("localhost", "root", "", "react-users");

if ($db_conn === false) {
    die("ERROR: Could Not Connect" . mysqli_connect_error());
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "GET":
       
            $alluser = mysqli_query($db_conn, "SELECT * FROM users");
            if (mysqli_num_rows($alluser) > 0) {
                while ($row = mysqli_fetch_array($alluser)) {
                    $json_array["userdata"][] = array("id" => $row['number'], 'name' => $row['name'], 'email' => $row['email'], 'password' => $row['password']);
                }

                echo json_encode($json_array["userdata"]);
                return;
            } else {
                echo json_encode(["result" => "please check the data"]);
                return;
            }
       
           
        break;

   case "POST":
    $userpostdata = json_decode(file_get_contents("php://input"));

    
        // Handle user data
      $name = $userpostdata->name;
$number = $userpostdata->number;
$email = $userpostdata->email;
$password = $userpostdata->password;

// Add debug log

$result = mysqli_query($db_conn, "INSERT INTO users (number, name, email, password) VALUES($number,'$name','$email','$password')");

if ($result) {
    echo json_encode(["success" => "user Added"]);
} else {
    echo json_encode(["failed" => "user failed"]);
}

   
        // Handle car data
      
    break;

}
?>
