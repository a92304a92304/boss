<?php session_start(); ?>
<?php include('connection.php'); ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- 引入CSS等樣式內容 -->
  <?php include('style.php') ?>
  <title>BOSS商店</title>
</head>

<body>
  <!-- 引入導覽列 -->
  <?php include('nav.php') ?>
  <div class="container">
    <!-- ~~STUFF -->
    <?php include('page.php') ?>
  </div>

</body>
<!-- 引入JS -->
<?php include('js.php') ?>

</html>
