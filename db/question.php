<?php
  // 投稿に関するdb処理を記述するファイル

  // 現在の関数
    // 投稿詳細: detailQuestion
    // 閲覧数の追加: questionViewAdd
    // 質問検索用: searchQuestionWithWord
    // 質問投稿用: insertQuestion
    // ログインユーザーの最新の投稿ID取得用: latestUserQuestion

  function selectMyQuestion($user_id) {
    // コネクションの挿入
    include dirname(__FILE__).'/userConnetcion.php';
    try {
      // sql分の構築
      $sql = "select q.question_id,q.question_title,q.question_detail,q.question_created,q.question_bestanswer,COUNT(ans.answer_id) as answer_count from question as q
      left outer join(select * from answer where user_id not in (select user_id from users where delete_flag = 1)) as ans on q.question_id = ans.question_id
      where q.delete_flag = 0 and q.question_created >= (NOW() - INTERVAL 7 DAY) and q.user_id = :id
      group by q.question_id, q.question_title, q.question_detail, q.question_created, q.question_bestanswer
      order by q.question_created desc";

      // pdoのインスタンス化
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
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

  function selectRecommendedQuestion() {
    // コネクションの挿入
    include dirname(__FILE__).'/userConnetcion.php';
    try {
      // sql分の構築
      $sql = "select q.question_id,q.question_title,q.question_detail,q.question_created,q.question_bestanswer,COUNT(ans.answer_id) as answer_count from question as q
      left outer join(select * from answer where user_id not in (select user_id from users where delete_flag = 1)) as ans on q.question_id = ans.question_id
      where q.delete_flag = 0 and q.question_created >= (NOW() - INTERVAL 7 DAY) 
      group by q.question_id, q.question_title, q.question_detail, q.question_created, q.question_bestanswer
      order by q.question_view desc, answer_count desc
      limit 10";

      // pdoのインスタンス化
      $stmt = $pdo->prepare($sql);
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

  function detailQuestion($question_id) {
    // コネクションの挿入
    include dirname(__FILE__).'/userConnetcion.php';
    try {
      // sql分の構築
      $sql = <<<EOF
select (select count(*) from answer WHERE question_id = :id1) as ans_cnt, q.question_id, q.question_title, q.question_detail, q.question_created, q.question_update, q.question_view, question_bestanswer, 
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
((q_a.user_id is not null or (select count(*) from answer WHERE question_id = :id2) = 0) or q.question_bestanswer = a.answer_id) and
q.question_id = :id3 and
q.delete_flag = 0 and
q_u.user_id is not null
order by a.answer_id = q.question_bestanswer desc, a.answer_date   
EOF ;

      // pdoのインスタンス化
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':id1', $question_id, PDO::PARAM_INT);
      $stmt->bindValue(':id2', $question_id, PDO::PARAM_INT);
      $stmt->bindValue(':id3', $question_id, PDO::PARAM_INT);
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
      $sql = "UPDATE question SET question_view = question_view + 1 WHERE question_id = :id";

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
      $sql = "select q.question_id,q.question_title,q.question_detail,q.question_created,q.question_bestanswer,COUNT(ans.answer_id) as answer_count from question as q
      left outer join(select * from answer where user_id not in (select user_id from users where delete_flag = 1)) as ans on q.question_id = ans.question_id
      where ( q.question_title like :keyword1 or q.question_detail like :keyword2 ) and q.delete_flag = 0
      group by q.question_id, q.question_title, q.question_detail, q.question_created, q.question_bestanswer;";

      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':keyword1','%'.$search_word.'%', PDO::PARAM_STR);
      $stmt->bindValue(':keyword2','%'.$search_word.'%', PDO::PARAM_STR);

      $stmt->execute();
      $result = $stmt->fetchall(PDO::FETCH_ASSOC);
      return $result;

    } catch(PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
      echo "dbの実行に失敗しました。管理者への連絡をお願いします。";
    }
  }

  // 質問投稿処理
  function insertQuestion($userId, $title, $detail) {
    // コネクションの挿入
    include dirname(__FILE__).'/userConnetcion.php';
    try {
      // sql分の構築
      $sql = "INSERT INTO question(user_id, question_title, question_detail) VALUES(:userId, :title, :detail)"; 

      // pdoのインスタンス化
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
      $stmt->bindValue(':title', $title, PDO::PARAM_STR);
      $stmt->bindValue(':detail', $detail, PDO::PARAM_STR);
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

  // ユーザーの最新の投稿を取得
  function latestUserQuestion($userId) {
    // コネクションの挿入
    include dirname(__FILE__).'/userConnetcion.php';
    try {
      // sql分の構築
      $sql = "SELECT max(question_id) FROM question WHERE user_id = :id"; 

      // pdoのインスタンス化
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
      // 実行
      $res = $stmt->execute();
      // 実行結果の取り出し
      $result = $stmt->fetchall(PDO::FETCH_ASSOC);
      if (count($result) != 1) {
        return 0;
      } else {
        return $result[0]["max(question_id)"];
      }
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
      echo "dbの実行に失敗しました。管理者への連絡をお願いします。";
    }
  }
