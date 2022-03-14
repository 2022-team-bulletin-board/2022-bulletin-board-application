// urlを取得
const url = new URL(window.location.href)
// URLSearchParamsオブジェクトを取得
const params = url.searchParams;

// コメントと追加していくdomの取得
const answerdiv = document.getElementById("answer-div");

$(function () {

  $('[type=button]').on('click', () => {

    let value = $('[name="answer"]').val();
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
          $("#answer-success").text("回答完了");
          // 回答が完了したら読み込み
          document.getElementById("answer").value = "";
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
              for (let element in value) {
                if (cnt++ === 0) {
                  continue;
                } else if (cnt++ === 1) {
                  $('<h3>' + value[element] + '</h3>').appendTo(trJQ_r);
                } else {
                  $('<p>' + value[element] + '</p>').appendTo(trJQ_r);
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


});
