<?php
  // 回答を持ってくるphp

  if (isset($_POST["answerId"]) && $_POST["answerId"] !== "") {
    include dirname(__FILE__).'/userConnetcion.php';
    try {
      // sql文の構築
      $sql = 'SELECT a.answer_id, concat("回答者:", u.student_name), concat("回答日時: ", a.answer_date), ifnull(concat("更新日時: ", a.answer_update), "更新日時: "), concat("回答: ", a.answer_detail) 
FROM answer as a
inner join (select * from users where delete_flag = 0) as u on u.user_id = a.user_id
WHERE answer_id > :id
order by answer_id';
      // インスタンス化
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':id', $_POST["answerId"], PDO::PARAM_INT);
      // 実行
      $res = $stmt->execute();

      $result = $stmt->fetchall(PDO::FETCH_ASSOC);

      // 取得結果をjson形式で送信
      echo json_encode($result);

    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
      echo "dbの実行に失敗しました。管理者への連絡をお願いします。";
    }
  }
