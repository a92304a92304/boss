<?php session_start(); ?>
<?php include('connection.php'); ?>
<?php $page_name="刪除訂單"?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <?php include('style.php') ?>
  <title><?php echo  $page_name. ' - ' .title_name ?></title>
</head>

<body>
  <?php include('nav.php'); ?>
  <div class="container my-3">
    <div class="row" >
      <div class="col-12 text-center ">
        <?php
          $CartID = $_GET['CartID'];
          $OrderID = $_GET['OrderID'];
          $sql = "DELETE FROM CART_RECORD
                  WHERE ID='".$CartID."'";
          $conn->query($sql);
          $sql = "DELETE FROM CART
                  WHERE ID='".$CartID."'";
          $conn->query($sql);
          $sql = "DELETE FROM ORDER_LIST_RECORD
                  WHERE OID='".$OrderID."'";
          $conn->query($sql);
          $sql = "DELETE FROM ORDER_LIST
                  WHERE ID='".$OrderID."'";
          $conn->query($sql);
        ?>
      </div>
    </div>
  </div>
  <?php include('footer.php') ?>
</body>
<?php include('js.php') ?>
<script language="Javascript">
  setTimeout(function(){location.href='index.php';}, 100);
</script>
</html>
