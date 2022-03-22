// urlを取得
const url = new URL(window.location.href)
// URLSearchParamsオブジェクトを取得
const params = url.searchParams;

// 正規表現のパターンの定義
const regex = /(`{3}\S+(\r\n|\n))|(`{3})/;

// コメントと追加していくdomの取得
const answerdiv = document.getElementById("answer-div");

window.addEventListener('DOMContentLoaded', () => {
  $(function () {

    const easyMDE = new EasyMDE({
      element: document.getElementById('Answer'),
      maxHeight: "200px"
    });

    const questionEditMDE = new EasyMDE({
      element: document.getElementById('questionEditArea')
    })


    const modal = document.getElementById('questionEditModal');
    document.getElementById('questionEdit').addEventListener('click', () => {
      openModal(modal);
    });

    document.getElementById('questionEditModalClose').addEventListener('click', () => {
      closeModal(modal);
    })

    function openModal($el) {
      $el.classList.add('is-active');
    }

    function closeModal($el) {
      $el.classList.remove('is-active');
    }

    document.addEventListener('keydown', (event) => {
      const e = event || window.event;

      if (e.keyCode === 27) {
        closeModal(modal);
      }
    })

    $('#ans_btn').on('click', () => {
      let value = easyMDE.value();
      console.log(value);
      // valueが空でないなら登録をする
      // 詳細はtextなので文字数を気にすることはない
      // console.log(value);
      // console.log(params.get("question_id"));
      if (value !== "") {
        $.ajax({
          url: 'db/answerInsert.php',
          type: 'POST',
          data: {
            answer_detail: value,
            question_id: params.get("question_id")
          },
          success: function (data) {
            if (data === "[]") {
              $("#answer-success").text("回答完了");
            } else {
              alert("自分の投稿のため、回答できません")
            }
            // 回答が完了したら読み込み
            easyMDE.value("");
            // console.log(data[0]);
            showAnswer();
          }
        })
      }
    })

    setInterval(() => {
      showAnswer();
    }, 1000);

    // 回答を取得する関数
    function showAnswer() {
      $.ajax({
        url: 'db/selectAnswer.php',
        type: 'POST',
        dataType: "json",
        data: {
          answerId: answerId,
          question_id: params.get("question_id")
        },
        success: function (data) {
          // console.log(answerId)
          if (data.length !== 0) {
            // dom操作
            data.forEach(value => {
              if (value.answer_id != answerId) {
                let trJQ_r = $('<div></div>').appendTo(answerdiv);
                let cnt = 0;
                let codeCnt = 0;
                for (let element in value) {
                  // console.log(value[element]);
                  var text = value[element];
                  if (cnt++ === 0) {
                    continue;
                  } else {
                    var bar = text.match(regex);
                    if (bar?.[0]) {
                      var language = bar[0].replace("```", "");
                      language = language.replace("\r\n", "");
                      language = language.replace("\n", "");
                      // console.log(language);
                      text = text.replace(bar[0], '<pre class="language-' + language + '"><code class="language-' + language + '">');
                      text = text.replace("```", "</code></pre>");
                    }
                    $('<p>' + text + '</p>').appendTo(trJQ_r);
                  }
                }
                $('body').append(answerdiv);
              }
            });
          }

          if (data.length > 0) {
            // console.log("新しく増えたよ")
            answerId = data[data.length - 1].answer_id;
            // console.log(answerId);
          }
        },
        error: () => {
          console.log("XMLHttpRequest : " + XMLHttpRequest.status);
          // console.log("textStatus     : " + textStatus);
          // console.log("errorThrown    : " + errorThrown.message);
          alert("読み込みに失敗しました");
        }
      })
    }
  })




});
