<?php

  // このphpではユーザーに関する関数を纏めて管理したいです

  // 現在の関数
  // ・ランダムな文字列を生成する
  // ・ハッシュ化
    // ログイン処理を書く際にも使えるので使ってみてください

  include dirname(__FILE__).'/sendMail.php';

  // ランダムな文字列を生成する関数
  function randomStr() {
    return substr(base_convert(md5(uniqid()), 16, 36), 0, 20);
  }

  // ハッシュ化する関数
  function hash256($pw, $salt) {
    return hash('sha256', $pw.$salt);
  }
