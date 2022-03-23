document.addEventListener('DOMContentLoaded', () => {
    const nameButton = document.getElementById('name');
    const passwordButton = document.getElementById('password');
    const grey = document.getElementById('grey');
    const popup = document.getElementById('popup');
    const clearBtn = document.getElementById('clearBtn');
    const changeBtn = document.getElementById('changeBtn');
    const changedName = document.getElementById('changedName');
    let changedNameText = "";

    // console.log(nameButton);
    
    nameButton.addEventListener('click', ()=> {
        grey.classList.add('show');
    })

    clearBtn.addEventListener('click', () => {
        grey.classList.remove('show');
    })

    changeBtn.addEventListener('click', () => {
        changedNameText = changedName.value;
        console.log(changedNameText);
    })

});
