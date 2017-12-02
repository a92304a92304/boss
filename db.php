<?php
/*
  執行此php即會執行'db.sql'腳本中所有指令，
  等於把db.sql全選貼入phpmyadmin的console中。
*/
$page_name = '執行SQL腳本'; // 本頁面名稱
require_once 'config.php';
require_once 'connection.php';

if($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']== '127.0.0.1'){
  // 若當前主機為localhost
  $file = file_get_contents('db.sql'); // 取得sql腳本檔
  $conn = new mysqli(db_host, db_username, db_password); // 建立mysql連接
}else{
  $file = file_get_contents('db_server.sql');
  $conn = new mysqli(db_host, db_username, db_password, db_name);
}

// 將讀入的腳本檔字串打散為Array，以';'分割，所以連註解的尾也要打';'
$arr = explode(';', $file);

?>

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
  <?php include('nav.php') ?>
  <div class="container">
    <div class="alert alert-primary text-center"><i class="material-icons">storage</i> 執行了以下查詢</div>
    <?php
      // 逐一執行mysql查詢
      foreach ($arr as $line) {
        if ($conn->query($line.';') == TRUE) {
          // 若正確
          if (!($rst = strpos($line, '--'))) { // 只印出非註解指令
            echo '<div class="alert alert-secondary" ><pre><code>'. $line . ';</code></pre></div>';
          }
        } else {
          // 若錯誤 印出錯誤資訊
          echo'<div class="alert alert-danger" ><i class="material-icons">warning</i> 錯誤 :<br><pre><code>'
              . $line . ';<br><strong></code></pre>'. $conn->error .'</strong></div>';
        }
      }
    ?>
  </div>
  <?php include('footer.php') ?>
</body>
<?php include('js.php') ?>
</html>
