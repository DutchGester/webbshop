<?php

if(isset($_SESSION['user_id']))
{
$sql = "
SELECT user_phonenumber,user_date,user_gender,user_country,user_email,user_firstname,user_lastname,
user_streetname,user_streetnumber,user_zipcode,user_city FROM register_user WHERE register_user_id= :id";

$statement = $connect->prepare($sql);
$statement->bindValue(':id', $_SESSION["user_id"]);
$success = $statement->execute();
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

$array = array();
foreach ($rows as $row) {
    $array[] = $row['user_phonenumber'];
    $array[] = $row['user_date'];
    $array[] = $row['user_gender'];
    $array[] = $row['user_country'];
    $array[] = $row['user_email'];
    $array[] = $row['user_firstname'];
    $array[] = $row['user_lastname'];
    $array[] = $row['user_streetname'];
    $array[] = $row['user_streetnumber'];
    $array[] = $row['user_zipcode'];
    $array[] = $row['user_city'];
}

$phonenumber = $array[0];
$date = $array[1];
$gender = $array[2];
$country = $array[3];
$email = $array[4];
$first_name = $array[5];
$last_name = $array[6];
$street_name = $array[7];
$street_number = $array[8];
$zip_code = $array[9];
$city = $array[10];
}
?>
