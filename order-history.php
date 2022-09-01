<?php
session_start();
include('config/database_connection.php');

$page_title="Account overview";
include 'layout_header.php';

$errors = [];

if(isset($_SESSION['user_id']))
{

// 'OrderHistory' object
class OrderHistory{

  // read all order history's
function read($from_record_num, $records_per_page){

  include('config/database_connection.php');

  // select all products query
  $query = "SELECT order_date, order_number,order_history FROM order_history WHERE register_user_id=:id ORDER BY order_date
            DESC LIMIT :from_record_num, :records_per_page";

  // prepare query statement
  $stmt = $connect->prepare($query);

  // bind limit clause variables
$stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->bindParam(':from_record_num', $from_record_num, PDO::PARAM_INT);
$stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);

  // execute query
  $stmt->execute();

  // return values
  return $stmt;
}

// used for paging products
public function count(){

  include('config/database_connection.php');

  // query to count all product records
  $query = "SELECT count(*) FROM order_history";

  // prepare query statement
  $stmt = $connect->prepare($query);

  // execute query
  $stmt->execute();

  // get row value
  $rows = $stmt->fetch(PDO::FETCH_NUM);

  // return count
  return $rows[0];
}

}

// initialize objects
$order_history_list = new OrderHistory($connect);

// to prevent undefined index notice
$action = isset($_GET['action']) ? $_GET['action'] : "";

// for pagination purposes
$page = isset($_GET['page']) ? $_GET['page'] : 1; // page is the current page, if there's nothing set, default is page 1
$records_per_page = 3; // set records or rows of data per page
$from_record_num = ($records_per_page * $page) - $records_per_page; // calculate for the query LIMIT clause

// read all products in the database
$stmt=$order_history_list->read($from_record_num, $records_per_page);

// count number of retrieved products
$num = $stmt->rowCount();

// if products retrieved were more than zero
if($num>0){
  // needed for paging
  $page_url="order-history.php?";
  $total_rows=$order_history_list->count();
}
if($num==0){
$total_rows = 0;
}
?>

<div class="container">
</br>
  <div id="response"></div>
<div class="row">
<div class="col-md-3 accountlist">
<div class="list-group ">
<a href="account-overview.php" class="list-group-item list-group-item-action">Account</a>
<a href="changepassword.php" class="list-group-item list-group-item-action">Change password</a>
<a href="changepassword.php" class="list-group-item list-group-item-action active">Order history</a>
</div>
</div>

<div class="col-md-9" style="margin-bottom:50px;">
<div class="card">
<div class="card-body">
<div class="row">
<div class="col-md-12">
<h4>Order history</h4>
<hr>
</div>
</div>
<div class="row">
<div class="col-md-12">
<?php include('messages.php'); ?>
<form id="form" method="post">
<?php
// tell the user if there's no products in the database
if($num == 0){
  echo "<div class='col-md-12'>";
      echo "<div class='alert alert-danger'>No order history found.</div>";
  echo "</div>";
}
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    extract($row);

    echo "<b>Order number: </b>".$order_number;
    echo "<br><br>";
    echo "<b>Order date: </b>".$order_date;
    echo "<br><br>";
        $decoded_order_history = base64_decode($order_history);
        $decoded_order_history = str_replace("table width='180%'", "table width='100%'", $decoded_order_history);
        $decoded_order_history = substr($decoded_order_history,0);
        echo $decoded_order_history;
        echo "<br><br>";
}

 ?>
</form>
<?php include_once('pagingOrderHistory.php'); ?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php }
else {
echo $message = "<label class='text-danger dangertext'>You need to login to watch your account</label>";
} ?>

<?php include 'layout_footer.php'; ?>
