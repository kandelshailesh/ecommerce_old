<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
<?php include 'require.php' ?>
</head>
<body style="overflow-x: hidden;">
<?php include 'navbar.php'?>
<?php if($_SESSION['count']==0)
{?>
  <div  style=" width:50%; margin-top:50px; padding:5px; height:40px; margin-left: 300px;" class="jumbotron text-center">
  <p>No any items in the cart</p>
<?php } else{?>
    <div style=" margin-left:120px; max-height: 450px; max-width: 100%;" class="row">
      <div style="overflow-x:hidden; overflow-y: auto;" class="col-md-9">
<table class="table table-hover">
    <thead style="background-color:gold;">
      <tr>
        <th  style="text-align:center;" class="col-md-auto">Items</th>
        <th class="col-md-auto">Quantity</th>
        <th class="col-md-auto">Unit price</th>
        <th class="col-md-auto">Subtotal</th>
        
      </tr>
    </thead>
   <tbody>
<?php 
$conn = mysqli_connect("localhost", "root", "", "pizzastores");
$time=$_SESSION['time'];
$date=$_SESSION['date'];
$orderid=$_SESSION['orders'];
  
$sessionorderresult= mysqli_query($conn,"SELECT * from `SESSIONORDER` where `OrderID`='$orderid'");

$ordercount= mysqli_num_rows($sessionorderresult);
$sessionresult3 = mysqli_query($conn,"SELECT DISTINCT P.Pizzaname,sum(SOD.Quantity) as Quantity ,P.Price,P.Picture from `SESSIONORDER_DETAILS` as SOD JOIN `SESSIONORDER` as SO using (OrderID) JOIN `PIZZA` as P on SOD.PizzaID = P.PizzaID where SO.OrderID='$orderid' and  SO.OrderDate >='$date' and SO.OrderTime >= '$time' GROUP BY P.Price,P.Pizzaname,P.Picture");
if (!$sessionresult3) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}

  $sessionresult4= mysqli_query($conn,"SELECT DISTINCT S.SauceName,sum(SOD.Quantity),S.SauceCost,S.SaucePic from `SESSIONORDER` as SO INNER JOIN `SESSIONORDER_DETAILS` as SOD on SO.OrderID=SOD.OrderID INNER JOIN `SAUCE` as S on SOD.SauceID = S.SauceID where  SO.OrderDate >='$date' and SO.OrderTime >= '$time' and SO.OrderID='$orderid' GROUP BY S.SauceName,S.SauceCost,S.SaucePic");
    $sum=0;
    while ($sessionrow3 = mysqli_fetch_array($sessionresult3)) {?>
     <tr>
      <td align="center" class="col-md-auto"><img src="<?php echo "pizzas/".$sessionrow3[3];?>" width="140" height="100"><?php echo "<h4>".$sessionrow3[0]."</h4>"; ?></td>
        <td class="col-md-auto"><br/><br/><?php echo $sessionrow3[1]/$ordercount; ?></td>
        <td class="col-md-auto"><br/><br/><?php echo "$".$sessionrow3[2]; ?></td>
        <td class="col-md-auto"><br/><br/><?php echo "$".($sessionrow3[1]/$ordercount)*$sessionrow3[2]; ?></td>
          <?php 
          $sum=$sum+($sessionrow3[1]/$ordercount)*$sessionrow3[2];?>
     </tr>

     <?php }?>
     <?php 
     while ($sessionrow4 = mysqli_fetch_array($sessionresult4)) 
      { 
        ?>
     <tr>
      <td align="center" class="col-md-auto"><img src="<?php echo "pizzas/".$sessionrow4[3];?>" width="140" height="100"><?php echo "<h4>".$sessionrow4[0]."</h4>"; ?></td>
        <td class="col-md-auto"><br/><br/><?php echo $sessionrow4[1]/$ordercount; ?></td>
        <td class="col-md-auto"><br/><br/><?php echo "$".$sessionrow4[2]; ?></td>
        <td class="col-md-auto"><br/><br/><?php echo "$".($sessionrow4[1]/$ordercount)*$sessionrow4[2]; ?></td>
        <?php 
          $sum=$sum+($sessionrow4[1]/$ordercount)*$sessionrow4[2];?>
     </tr>
     
      <?php }?>
    
   </tbody>
  </table>
  
</div>

</div>

<br><br>
<div class="row">
<label style="margin-left:100px; font-size:30px; text-align:right;" class="col-sm-5" >Total <span id="sum"> <?php echo "$".$sum; ?></span></label>
<div class="col-sm-3"></div>
<button style="margin-left: -230px;" class="col-md-auto btn btn-primary" onclick="window.location.href='shoppingpage.php'">Buy Another Pizza</button>
<button  onclick="window.location.href='checkout.php'"  style="margin-left: 20px;"class="btn btn-success col-md-auto "> Checkout</button>
</div>

 
<?php } ?>
 
</body>
</html>