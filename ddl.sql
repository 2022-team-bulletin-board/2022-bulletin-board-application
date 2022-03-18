CREATE DATABASE bba;

use bba;

-- ユーザーテーブルの作成
CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  student_name VARCHAR(50) NOT NULL,
  student_mail VARCHAR(255) NOT NULL UNIQUE,
  student_pass VARCHAR(64) NOT NULL,
  student_salt VARCHAR(19) NOT NULL,
  delete_flag boolean DEFAULT false,
  admin_flag boolean DEFAULT false
);
-- 管理者のアカウントのみ最初からいれる
INSERT INTO users VALUES(null, "admin", "sample@jp.com", "339ff53caac9a14a40f2e7cb7de73a00e6535a9caede80bd929bd6dc077c8506", "qwertyuisdfg", false, true);

-- 追加機能用に閲覧数・ベストアンサーをつけておく
create table question(
  question_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  question_title VARCHAR(100) NOT NULL,
  question_detail TEXT NOT NULL,
  question_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  question_update DATETIME DEFAULT NULL,
  delete_flag boolean DEFAULT false,
  question_bestanswer INT,
  question_view INT NOT NULL DEFAULT 0,
  FOREIGN KEY (user_id) REFERENCES users(user_id)
);

create table answer(
  answer_id INT auto_increment PRIMARY KEY,
  user_id INT NOT NULL,
  question_id INT NOT NULL,
  answer_detail TEXT,
  answer_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  answer_update DATETIME DEFAULT NULL,
  FOREIGN KEY (user_id) REFERENCES users(user_id),
  FOREIGN KEY (question_id) REFERENCES question(question_id)
);

ALTER TABLE question ADD FOREIGN KEY (question_bestanswer) REFERENCES answer(answer_id) ON DELETE CASCADE;

# 一般ユーザーの作成(select, insert, update, delete)
CREATE USER 'student'@'localhost' IDENTIFIED BY '@Morijyobi1921';
GRANT SELECT, INSERT, UPDATE, DELETE ON bba.answer to 'student'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON bba.question to 'student'@'localhost';
GRANT SELECT, UPDATE ON bba.users to 'student'@'localhost';

# 管理者の作成(select, insert, update, delete)
CREATE USER 'admin'@'localhost' IDENTIFIED BY '@Morijyobi1921';
GRANT SELECT, INSERT, UPDATE, DELETE ON bba.answer to 'admin'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON bba.question to 'admin'@'localhost';
GRANT SELECT, UPDATE, DELETE, INSERT ON bba.users to 'admin'@'localhost';

-- EXECUTE権限の追加
CREATE USER 'EXECUTE_USER'@'localhost' IDENTIFIED BY '@Morijyobi1921';
GRANT EXECUTE ON bba.* to 'EXECUTE_USER'@'localhost';

-- サンプルデータ挿入

-- user_idを現在登録されている中で最も新しいアカウントのidにする
insert into question(user_id, question_title, question_detail) values ( (select max(user_id) from users), "サンプル投稿１", "サンプル投稿の質問詳細" );

-- 最低でも4人のユーザーがいる想定の回答データ
insert into answer(user_id, question_id, answer_detail) values( (select max(user_id) - 1 from users), (select max(question_id) from question), "サンプルアンサーの詳細" );
insert into answer(user_id, question_id, answer_detail) values( (select max(user_id) - 2 from users), (select max(question_id) from question), "サンプルアンサーの詳細2" );
insert into answer(user_id, question_id, answer_detail) values( (select max(user_id) - 3 from users), (select max(question_id) from question), "サンプルアンサーの詳細3" );

-- 回答テーブルと質問テーブルのために新たに制約を追加
-- ALTER TABLE question Add FOREIGN KEY (question_bestanswer) REFERENCES answer(answer_id) ON DELETE CASCADE;

DELIMITER //
CREATE PROCEDURE answer_insert_func(IN question_id_ins int, IN user_id_ins int, IN answer_detail_ins TEXT)
BEGIN
   if (select count(*) from question where user_id = user_id_ins and question_id = question_id_ins) = 0 
	THEN insert into answer(question_id, user_id, answer_detail) values(question_id_ins, user_id_ins, answer_detail_ins);
   ELSE select "自分の投稿";
   END IF;
END 
//
DELIMITER ;

-- 実行例
-- call answer_insert_func(19, 2, "a");

select (select count(*) from answer WHERE question_id = 19) as ans_cnt, q.question_id, q.question_title, q.question_detail, q.question_created, q.question_update, q.question_view, question_bestanswer, 
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
((q_a.user_id is not null or (select count(*) from answer WHERE question_id = 19) = 0) or q.question_bestanswer = a.answer_id) and
q.question_id = 19 and
q.delete_flag = 0 and
q_u.user_id is not null
order by a.answer_id = q.question_bestanswer desc, a.answer_date 

DROP PROCEDURE IF EXISTS func;
