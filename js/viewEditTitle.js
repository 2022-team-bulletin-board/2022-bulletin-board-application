window.addEventListener('DOMContentLoaded', () => {
    const buttonLists = Array.from(document.getElementsByClassName('toggleTitleEdit'));
    const titleList = Array.from(document.getElementsByClassName('toggleTitle'));

    buttonLists.forEach(val => {
        val.addEventListener('click', () => {
            titleList.forEach(elem => {
                if (elem.dataset.view === "true") {
                    elem.dataset.view = "false";
                } else {
                    elem.dataset.view = "true";
                }
            })
        })
    })
});
