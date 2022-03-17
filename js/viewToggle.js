window.addEventListener('DOMContentLoaded', () => {
    const buttonLists = Array.from(document.getElementsByClassName('toggleTitleEdit'));
    const titleList = Array.from(document.getElementsByClassName('toggleTitle'));
    const modalButton = Array.from(document.getElementsByClassName('modalButton'));
    const modalCloseButton = Array.from(document.getElementsByClassName('modalCloseButton'));

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

    modalButton.forEach(val => {
        val.addEventListener('click', () => {
            openModal(document.getElementById(val.dataset.modalField));
        })
    })

    modalCloseButton.forEach(val => {
        val.addEventListener('click', () => {
            closeModal(document.getElementById(val.dataset.modalField));
        })
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
            modalCloseButton.forEach(elem => {
                closeModal(document.getElementById(elem.dataset.modalField));
            })
        }
    })
});
