const regForm = document.querySelector('.popup__container');
const popup = document.querySelector('.popup__regForm');


function showRegForm() {
    regForm.classList.add('open');
    popup.classList.add('popup_open');
}

function closeRegForm () {
    regForm.classList.remove('open');
    popup.classList.remove('popup_open');
}

function showHidePassword(target){
    var input = document.getElementById('popup__password-id');
    if (input.getAttribute('type') === 'password') {
        target.classList.add('view');
        input.setAttribute('type', 'text');
    } else {
        target.classList.remove('view');
        input.setAttribute('type', 'password');
    }
    return false;
}
