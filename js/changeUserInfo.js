document.addEventListener('DOMContentLoaded', () => {
    // ポップアップを表示するボタン
    const nameButton = document.getElementById('name');
    const passwordButton = document.getElementById('password');

    // パスワード/名前のポップアップ全体
    const nameContainer = document.getElementById('nameContainer');
    const pwContainer = document.getElementById('pwContainer');

    // 入力用のフォーム
    const changeNameForm = document.getElementById('changeNameForm');
    const changePwForm = document.getElementById('changePwForm');

    // 値の入力用
    const changedName = document.getElementById('changedName');
    const changedPwFirst = document.getElementById('changedPwFirst');
    const changedPwSecond = document.getElementById('changedPwSecond');

    // ポップアップの×ボタン
    const clearNameBtn = document.getElementById('clearNameBtn');
    const clearPwBtn = document.getElementById('clearPwBtn');

    // 変更実行ボタン
    const changeNameBtn = document.getElementById('changeNameBtn');
    const changePwBtn = document.getElementById('changePwBtn');


    // 名前変更用のポップアップの切り替え-----------------------------------
    nameButton.addEventListener('click', ()=> {
        nameContainer.classList.add('show');
    })

    clearNameBtn.addEventListener('click', () => {
        nameContainer.classList.remove('show');
    })

    // 名前変更の実行ボタンが押されたとき
    changeNameBtn.addEventListener('click', () => {
        if(changedName.value != ""){
            changeNameForm.submit();
        } else {
            // 空の場合のエラーメッセージ
        }
    })

    // パスワード変更-----------------------------------
    passwordButton.addEventListener('click', ()=> {
        pwContainer.classList.add('show');
    })

    clearPwBtn.addEventListener('click', () => {
        pwContainer.classList.remove('show');
    })

    changedPwFirst.addEventListener('blur', ()=> {
        if(changedPwSecond.value != ""){
            if(changedPwFirst.value != changedPwSecond.value){
                // 一致していないメッセージ
            }
        }
    })

    changedPwSecond.addEventListener('blur', ()=> {
        if(changedPwFirst.value != changedPwSecond.value){
            // 一致していないメッセージ
        } else {

        }
    })
});
