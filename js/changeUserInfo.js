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

    // エラーテキスト表示用
    const nameValueError = document.getElementById('nameValueError');
    const pwValueError = document.getElementById('pwValueError');
    const nullError = document.getElementById('nullError');

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
        changedName.value = "";
        nameContainer.classList.remove('show');
        nameValueError.classList.remove('show');
    })

    // 名前変更の実行ボタンが押されたとき
    changeNameBtn.addEventListener('click', () => {
        if(changedName.value != ""){
            changeNameForm.submit();
        } else {
            nameValueError.classList.add('show');
        }
    })

    // パスワード変更-----------------------------------
    passwordButton.addEventListener('click', ()=> {
        pwContainer.classList.add('show');
    })

    clearPwBtn.addEventListener('click', () => {
        changedPwFirst.value = "";
        changedPwSecond.value = "";
        pwContainer.classList.remove('show');
        pwValueError.classList.remove('show');
    })

    changedPwFirst.addEventListener('input', ()=> {
        if(changedPwFirst.value !== "" && changedPwSecond.value !== ""){
            nullError.classList.remove('show');
        }
        if(changedPwSecond.value != ""){
            if(changedPwFirst.value != changedPwSecond.value){
                pwValueError.classList.add('show');
            } else {
                pwValueError.classList.remove('show');
            }
        } else {
            pwValueError.classList.remove('show');
        }
    })

    changedPwSecond.addEventListener('input', ()=> {
        if(changedPwFirst.value !== "" && changedPwSecond.value !== ""){
            nullError.classList.remove('show');
        }
        if(changedPwFirst.value != changedPwSecond.value){
            pwValueError.classList.add('show');
        } else {
            pwValueError.classList.remove('show');
        }
    })

    changePwBtn.addEventListener('click', () => {
        if(changedPwFirst.value !== "" && changedPwSecond.value !== "") {
            if(changedPwFirst.value == changedPwSecond.value){
                changePwForm.submit();
            }
        } else {
            nullError.classList.add('show');
        }
    })
});
