window.addEventListener('DOMContentLoaded', () => {
    /*
    * - data-child-count : 子要素の数
    * - data-child-view : 表示させる子要素の数
    */
    const myList = document.getElementById('myList');
    let liArray = document.getElementsByClassName('my-lists');
    const viewButton = document.getElementById('viewButton');
    let viewNum = 0;  // 表示数
    const Incremental = 3; // 増分

    myList.dataset.childCount = myList.childElementCount.toString();

    changeChildView();

    viewButton.addEventListener('click', () => {
        if (changeChildView(Incremental) === true) {
            myList.dataset.childView = viewNum.toString();
        }
    })


    function changeChildView() {
        if (myList.dataset.childCount == viewNum) {
            viewButton.dataset.disable = 'true';
            return false;
        }

        if (myList.dataset.childCount >= viewNum) {
            for (let i = 0; i < Incremental && viewNum + i < myList.childElementCount; i++) {
                liArray[viewNum + i].classList.add('viewLi');
            }

            viewNum += Incremental;

            if (myList.dataset.childCount == viewNum) {
                viewButton.dataset.disable = 'true';
            }

            return true;
        }
        return false;
    }
})