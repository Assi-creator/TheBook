let avatar;
let value;
let alert = document.getElementById('tinyalert');
$('.page-header__login').click(function (e) {
    $('.popup__regForm').addClass('open');
    $('.popup__modal').addClass('popup_open');

    $('.popup__reg-error').text('');
});

$('.popup__btn-close').click(function (e) {
    $('.popup__regForm').removeClass('open');
    $('.popup__modal').removeClass('popup_open');
});

$('.popup__title a').click(function (e) {
    $('.popup__forgotPass').addClass('open');
});

$('.popup__btn-back').click(function (e) {
    $('.popup__forgotPass').removeClass('open');
});

$('.popup__btn-login').click(function (e) {
    e.preventDefault();
    let login = $('input[name="login"]').val(),
        password = $('input[name="password"]').val();


    $.ajax({
        url: '/api/controller/session/session.php',
        type: 'POST',
        dataType: 'JSON',
        data: {
            login: login,
            password: password,
            action: 'session'
        },
        success(data) {
            if (data.ok) {
                document.location.href = '/index.php';
            } else {
                $('.popup__reg-error').text(data.description);
            }
        }
    });
});


$.each($('.radiogroup'), function (index, val) {
    if ($(this).find('menu-item').prop('checked') === true) {
        $(this).addClass('active');
    }
});

$('.menu-item').click(function (e) {
    var itemId = $(this).attr("data-id") || "";
    var inputType = "";
    if (itemId) {
        var inputElem = $(document.getElementById(itemId));
        inputType = inputElem.prop("type") || "";
        if ("radio" === inputType) {
            inputElem.prop("checked", true);
        } else {
            inputElem.val($(this).hasClass("active") ? 0 : 1);
            inputElem.prop("checked", !$(this).hasClass("active"));
        }
        inputElem.change();
    }

    var radioId = $(this).attr("data-radio") || "";
    var activeClass = $(this).attr("data-class") || "active";
    if (radioId && "radio" === inputType) {
        $("." + radioId).removeClass(activeClass);
        $(this).addClass(activeClass);
    } else {
        $(this).toggleClass(activeClass);
    }
});

$('input[name="profile-file"]').change(function (e) {
    avatar = e.target.files[0];
    console.log(avatar)
});

const buttons = document.querySelectorAll('a[data-id]');
buttons.forEach(button => {
    button.addEventListener('click', function() {
        const id = this.dataset.id;
        const input = document.querySelector(`#${id}`);
        value = input.value;
        console.log(value)
    });
});

$('#btn_reg').click(function (e) {
    e.preventDefault();

    let error = formValidate();
    alert.innerHTML = ''

    if (error === 0) {
        let card = $('input[name="card-index"]').val(),
            reader = $('input[name="name-reader"]').val(),
            login = $('input[name="profile-login"]').val(),
            password = $('input[name="profile-password"]').val(),
            email = $('input[name="profile-email"]').val();
        about = $('textarea[name="profile-about"]').val();
        avatarurl = $('input[name="profile-url"]').val();

        let formData = new FormData();
        formData.append('action', 'reg');
        formData.append('card', card);
        formData.append('reader', reader);
        formData.append('login', login);
        formData.append('password', password);
        formData.append('email', email);
        formData.append('about', about);
        formData.append('value', value);
        formData.append('avatar', avatar);
        formData.append('avatarurl', avatarurl);


        $.ajax({
            url: '/api/controller/session/session.php',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            success(data) {
                let response = JSON.parse(data)
                if (response.ok === true){
                    document.location.href = '/index.php';
                } else {
                    let message = '<div class="red"> <a title="[x]" class="action a-close site-alert-close" onclick="Close();"><span class="i-clear"></span></a>' + response.description + '</div>'
                    alert.innerHTML += message
                    window.scrollTo(0, 0);
                }
            }
        });
    } else {
        window.scrollTo(0, 0);
    }
});

$('#btn-editprofile-save').click(function (e) {
    e.preventDefault();
    let error = 0;
    alert.innerHTML = ''
    if (error === 0) {
        let login = $('input[name="profile-login"]').val(),
            about = $('textarea[name="profile-about"]').val();
        avatarurl = $('input[name="profile-url"]').val();

        let formEditData = new FormData();
        formEditData.append('action', 'editprofile');
        formEditData.append('login', login);
        formEditData.append('about', about);
        formEditData.append('value', value);
        formEditData.append('avatar', avatar);
        formEditData.append('avatarurl', avatarurl);

        $.ajax({
            url: '/api/controller/user/account.php',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formEditData,
            success(data) {
                let response = JSON.parse(data)
                if (response.ok === true){
                    let message = '<div class="green"> <a title="[x]" class="action a-close site-alert-close" onclick="Close();"><span class="i-clear"></span></a>Профиль изменен</div>'
                    alert.innerHTML += message
                    window.scrollTo(0, 0);
                } else {
                    let message = '<div class="red"> <a title="[x]" class="action a-close site-alert-close" onclick="Close();"><span class="i-clear"></span></a>' + response.description + '</div>'
                    alert.innerHTML += message
                    window.scrollTo(0, 0);
                }
            }
        });
    }
});




function Close(){
    alert.innerHTML = ''
}

function formValidate() {
    let error = 0;
    let formReq = document.querySelectorAll('._req');
    let email = document.getElementById('profile-email');

    for (let index = 0; index < formReq.length; index++) {
        const input = formReq[index];
        formRemoveError(input);

        if (input.value === '') {
            formAddError(input);
            error++;
        }
    }
    return error;
}

function formAddError(input) {
    input.parentElement.classList.add('_error');
    input.classList.add('_error');
}

function formRemoveError(input) {
    input.parentElement.classList.remove('_error');
    input.classList.remove('_error');
}

function showHidePassword(target) {
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
