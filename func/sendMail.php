<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  $current_dir = dirname(__FILE__);
  require($current_dir . '/PHPMailer-6.1.5/src/Exception.php');
  require($current_dir . '/PHPMailer-6.1.5/src/PHPMailer.php');
  require($current_dir . '/PHPMailer-6.1.5/src/SMTP.php');

  date_default_timezone_set('Asia/Tokyo');
  mb_language('japanese');
  mb_internal_encoding('utf-8');

  function initialMail($mailToUser, $pw, $userName){
    $mail = new PHPMailer();

    // ＜SMTPで送信する場合＞
    // Enable SMTP debugging (デバッグ出力させない場合は 0)
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;

    // 文字コードの設定
    $mail->CharSet = 'utf-8';

    // SMTP
    $mail->isSMTP();

    // hostname
    $mail->Host = 'smtp.gmail.com';

    // SMTP port (587)
    $mail->Port = 587;

    // 暗号化 (ssl|tls)
    $mail->SMTPSecure = 'tls';

    // SMTP認証
    $mail->SMTPAuth = true;

    // ユーザー名
    $mail->Username = 'pythonexample1234@gmail.com';

    // パスワード
    $mail->Password = 'y20010410';

    // オプション
    $mail->SMTPOptions = [
    	'ssl' => [
    		'verify_peer' => false
    		,'verify_peer_name' => false
    		,'allow_self_signed' => true
    	]
    ];
    // ＜/ SMTPで送信する場合＞

    // From address
    $mail->setFrom('pythonexample1234@gmail.com', '津嶋勇輝');

    // Reply-to address
    $mail->addReplyTo('pythonexample1234@gmail.com', '津嶋勇輝');

    // To address
    $mail->addAddress($mailToUser, $userName);

    // 件名
    $mail->Subject = 'BBAからアカウント登録完了のお知らせです';

    // 本文 HTMLを無効 (PLAINのみ)
    $mail->isHTML(FALSE);
    $mail->Body = 'ログイン情報の送信です' . "\n" . 'id: ' . $mailToUser . " \npw: " . $pw . " \nログインできないとうございましたら管理者まで連絡お願いします。";

    // X-Mailer を非表示にする
    $mail->XMailer = null;

    // 送信
    if ( ! $mail->send()) {
    	echo "Mailer Error: " . $mail->ErrorInfo;
      // あまり意味がない？
      // 送信者のメールに送信できなかったメールが届くのでそこで確認する方式でいきたい
      echo "<br>以下のメールアドレスに送信できませんでした。確認お願いします。<br>" . $mailToUser . "<br>";
    }
  }

  // initialMail("y.tsushima.sys20@morijyobi.ac.jp", "y20010410", "津嶋勇輝");
  
