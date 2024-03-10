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
           $allcars = mysqli_query($db_conn, "SELECT * FROM cars");

            if (mysqli_num_rows($allcars) > 0) {
                while ($row = mysqli_fetch_array($allcars)) {
                    $json_array["cardata"][] = array(
                        'number' => $row['number'],
                        'model' => $row['model'],
                        'rent' => $row['rent'],
                        'seating' => $row['capacity']
                    );
                }

                echo json_encode($json_array["cardata"]);
                return;
            } else {
                echo json_encode(["result" => "No cars found"]);
                return;
            }
        
     case "POST":
    $userpostdata = json_decode(file_get_contents("php://input"));    
         
               $name = $userpostdata->model;
  $number = $userpostdata->vehicleNumber;
   $rent = $userpostdata->rentPerDay;
    $seating = $userpostdata->seatingCapacity;

// Add debug log

   $result = mysqli_query($db_conn, "INSERT INTO cars (number, model, rent, capacity) VALUES('$number','$name',$rent,$seating)");

if ($result) {
    echo json_encode(["success" => "car Added"]);
} else {
    echo json_encode(["failed" => "car failed"]);
}

break;
}
?>