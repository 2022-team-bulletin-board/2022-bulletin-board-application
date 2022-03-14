<?php
  // 投稿に関するdb処理を記述するファイル

  // 現在の関数
    // 投稿詳細: detailQuestion
    // 閲覧数の追加: questionViewAdd

  function detailQuestion($question_id) {
    // コネクションの挿入
    include dirname(__FILE__).'/userConnetcion.php';
    try {
      // sql分の構築
      $sql = <<<EOF
select q.question_id, q.question_title, q.question_detail, q.question_created, q.question_update, q.question_view, question_bestanswer, 
q_u.user_id as qu_id, q_u.student_name as qu_name,
q_a.user_id as qa_id, q_a.student_name as qa_name,
a.answer_detail, a.answer_date, a.answer_update, a.answer_id
from question as q
left outer join users as q_u on q.user_id = q_u.user_id
left outer join answer as a on a.question_id = q.question_id
left outer join (
    select * from users where delete_flag = 0
  ) as q_a on q_a.user_id = a.user_id
where 
(q_a.user_id is not null or q.question_bestanswer = a.answer_id) and
q.question_id = :id and
q.delete_flag = 0 and
q_u.user_id is not null
order by a.answer_id = q.question_bestanswer desc, a.answer_date
EOF ;

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
      echo "dbの実行に失敗しました。管理者への連絡をお願いします。";
    }
  }

  // 詳細ページの閲覧数の追加
  function questionViewAdd($question_id) {
    include dirname(__FILE__).'/userConnetcion.php';
    try {
      // sql分の構築
      $sql = "update question set question_view = question_view + 1 where question_id = :id";

      // pdoのインスタンス化
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':id', $question_id, PDO::PARAM_INT);
      // 実行
      $res = $stmt->execute();
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
      echo "dbの実行に失敗しました。管理者への連絡をお願いします。";
    }
  }
  
  // 質問検索用
  function searchQuestionWithWord($search_word) {
    include dirname(__FILE__).'/userConnetcion.php';

    try {
      //sql文作成
      $sql = "select q.question_id,q.question_title,q.question_detail,q.question_created,q.question_bestanswer,COUNT(ans.answer_id) as answer_count FROM question as q
      left outer join answer as ans on q.question_id = ans.question_id
      where ( q.question_title like :keyword or q.question_detail like :keyword ) and q.delete_flag = 0
      group by q.question_id, question_title, question_detail, question_created, question_bestanswer;";

      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':keyword','%'.$search_word.'%', PDO::PARAM_STR);

      $stmt->execute();
      $result = $stmt->fetchall(PDO::FETCH_ASSOC);
      return $result;

    } catch(PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
      echo "dbの実行に失敗しました。管理者への連絡をお願いします。";
    }
  }
