<?php
  // 投稿に関するdb処理を記述するファイル

  // 現在の関数
    // 投稿詳細: detailQuestion

  function detailQuestion($question_id) {
    function insertUserSql($sql) {
      // 管理者用のコネクションの挿入
      include dirname(__FILE__).'/userConnection.php';
      try {
        // sql分の構築
        $sql = <<<eof
select q.question_id, q.question_title, q.question_detail, q.question_created, q.question_update, q.question_view,
q_u.user_id, q_u.student_name,
q_a.user_id, q_a.student_name,
a.answer_detail, a.answer_date, a.answer_update
from question as q
left outer join users as q_u on q.user_id = q_u.user_id
left outer join answer as a on a.question_id = q.question_id
left outer join (
    select * from users where delete_flag = 0
  ) as q_a on q_a.user_id = a.user_id
where 
(q_a.user_id is not null or q.question_bestanswer = a.answer_id) and
q.question_id = 1 and
q.delete_flag = 0 and
q_u.user_id is not null
order by a.answer_id = q.question_bestanswer desc, a.answer_date

eof

        // pdoのインスタンス化
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $question_id, PDO::PARAM_INT);
        // 実行
        $res = $stmt->execute();
        // 実行結果の取り出し
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
      } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        echo "<br>アカウントの作成に失敗しました。csvファイルの確認をお願いします";
      }
    }
  }
