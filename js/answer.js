$(function () {

  $('[type=button]').on('click', () => {
    let value = $('[name="answer"]').val();
    // valueが空でないなら登録をする
    // 詳細はtextなので文字数を気にすることはない
    console.log(value);
    if (value !== "") {
      $.ajax({
        url: 'func/answer.php',
        type: 'POST',
        data: {
          answer_detail: value
        },
        success: function (data) {
          $("#answer-success").text("回答完了");
        }
      })
    }
  })
});
