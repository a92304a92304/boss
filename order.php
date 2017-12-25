<?php session_start(); ?>
<?php include('connection.php'); ?>
<?php $page_name="訂單確認"?>

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
        <?php include('echo_alert.php') ?>
        <h2 class="d-inline-block my-3" style="border-bottom:5px #333 solid;">訂單確認</h2>
        <table class="table table-bordered my-3">
          <thead class="thead-dark text-center">
            <tr>
              <th scope="col" class="text-center" style="width:8rem;"></th>
              <th scope="col">商品名稱</th>
              <th scope="col">單價</th>
              <th scope="col">數量</th>
              <th scope="col">小計</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $CartID = $_GET['CartID'];
              $Total = 0;
              $SelectCount = 0;
              $Fare = 60;
              // 資料庫指令
              $sql = "SELECT P.PID PID, P.PImg PIMG, P.PName PName, P.PPrice PPrice,
                      CR.Quantity CRQ, P.PPriceDiscount PPriceD, P.DID PDID, P.DEvent PDEvent
                      FROM CART C
                      JOIN CART_RECORD CR ON C.ID = CR.ID
                      JOIN PRODUCT_VIEW P ON CR.PID = P.PID
                      WHERE C.ID='".$CartID."'";
              $result = $conn->query($sql);
              if(mysqli_num_rows($result) == 0) {
                $Fare = 0;
                echo'
                  <tr>
                    <td colspan="6">您尚未選購產品</td>
                  </tr>';
              }
              else if(mysqli_num_rows($result) > 0){
                while($rows = mysqli_fetch_array($result)){
                  $CountQuantity = 0;
                  $cost = 0;
                  if($rows['PDID'] == 3){
                    if($rows['CRQ'] % 2 == 0) $CountQuantity = $rows['CRQ'] / 2;
                    else $CountQuantity = floor($rows['CRQ'] / 2) + 1;
                  }
                  else $CountQuantity = $rows['CRQ'];
                  if($rows['PPriceD'] != ''){ //有折扣
                    $cost = round($rows['PPriceD']);
                  }
                  else{
                    $cost = $rows['PPrice'];
                  }
                  echo '<tr class="text-lg-center" >
                          <th>
                            <img src="'.$rows['PIMG'].'" class="img-fluid " style="max-height:5rem;">
                          </th>
                          <th scope="row" class="text-left align-middle">'.$rows['PName'].'</br>'.$rows['PDEvent'].'</th>
                          <th class="align-middle">NT$ '.number_format($cost).'</th>
                          <th class="align-middle">'.$rows['CRQ'].'</th>
                          <th class="align-middle">NT$ '.number_format($cost * $CountQuantity).'</th>
                        </tr>';
                  $Total += $cost * $CountQuantity;
                  $SelectCount += $rows['CRQ'];
                }
              }
            ?>
            <tr class="text-right">
              <td colspan="6">
                <?php echo '共<strong>'.$SelectCount.'</strong>件商品　商品金額：<strong>NT$ '.number_format($Total).'</strong></br>';
                if($Total<1000) $Total += $Fare;
                else $Fare = 0;
                echo '運費小計：<strong>NT$ '.$Fare.'</strong></br>';
                echo '<font size="+2">總金額：NT$ <strong>'.number_format($Total).'</strong></font>'; ?>
              </td>
            </tr>
          </tbody>
        </table>
        <?php
          if($Total > 0){
            echo'<a class="btn btn-outline-dark" href="order_submit.php?CartID='.$CartID.'&&Total='.$Total.'"><i class="material-icons">提交訂單</i></a>';
            echo'<a class="btn btn-outline-dark" href="order_del.php?CartID='.$CartID.'"><i class="material-icons">取消訂單</i></a>';
          }
        ?>
      </div>
    </div>
  </div>
  <?php include('footer.php') ?>
</body>
<?php include('js.php') ?>
<script language="Javascript">
  // 返回上一頁
  //setTimeout("history.back()", 10);
</script>
</html>
