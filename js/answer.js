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
    });

    // const modal = document.getElementById('questionEditModal');
    // document.getElementById('questionEditArea').addEventListener('click', () => {
    //   openModal(modal);
    // });

    // document.getElementById('questionEditModalClose').addEventListener('click', () => {
    //   closeModal(modal);
    // })

    // function openModal($el) {
    //   $el.classList.add('is-active');
    // }

    // function closeModal($el) {
    //   $el.classList.remove('is-active');
    // }

    // document.addEventListener('keydown', (event) => {
    //   const e = event || window.event;

    //   if (e.keyCode === 27) {
    //     closeModal(modal);
    //   }
    // })

  })
});
