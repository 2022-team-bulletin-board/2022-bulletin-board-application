<?php
  session_start();
  // セッション情報を削除
  $_SESSION = array();
  header("Location:../index.php");
  exit();
?>
