<?php

session_start();

$pizzaid=$_POST['pizzaid'];
$sauceid= $_POST['sauceid'];
$quantity= $_POST['quantity'];
if (!isset($_SESSION['carts']))
  {
  	$_SESSION['carts']="Okay";
 	$_SESSION['count']=$_SESSION['count']+ 2*$quantity;
 }
 else
 {
 	$_SESSION['count']=$_SESSION['count']+ 2*$quantity;
 	
 }
 echo $_SESSION['count'];
 $conn = mysqli_connect("localhost", "root", "", "pizzastores");
 $orderid=$_SESSION['orders'];
 $date=date("Y-m-d");
$time=date("H:i:s");

$sessionresult1= mysqli_query($conn,"INSERT INTO `SESSIONORDER` (`OrderID`,`OrderDate`,`OrderTime`,`OrderStatus`) VALUES ($orderid,'$date','$time','Pending')");
$sessionresult2= mysqli_query($conn,"INSERT INTO `SESSIONORDER_DETAILS` (`OrderID`, `PizzaID`, `SauceID`, `Quantity`) VALUES
($orderid, '$pizzaid', '$sauceid', '$quantity')");


?>