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
    button.addEventListener('click', function () {
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
                if (response.ok === true) {
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
                console.log(data)
                let response = JSON.parse(data)
                if (response.ok === true) {
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

$("div.header-card__menu").each(function () {
    $(this).hover(function () {
        $(this).find(".header-card__menu-block").toggleClass("show");
    });
});

$('.bc-menu__stars label').on({
    click: function (){
        $('input[name="mymark"]').val($(this).prev('input').val());
        $('.popup-book-mark').text($(this).prev('input').val());
    }
});

$(document).ready(function() {
    let mark = $('input[name="mymark"]').val();
    $('.bc-menu__stars label').each(function(mark) {
        if ($(this).attr("for")) {
            $("#" + $(this).attr("for")).prop("checked", true);
            $(this).click();
        }

    });
});

// $(document).ready(function(){
//     let mark = $('input[name="mymark"]').val();
//     $('.bc-menu__stars label').slice(5-mark, 5);
// });

let isReviewDelete = 0;
$('#reviewremove').click(function () {
    if ($('#reviewremove').is(':checked')) {
        isReviewDelete = 1
    } else {
        isReviewDelete = 0
    }
});


$('#create-review').click(function(e){
    e.preventDefault();

    let mark = $('input[name="mymark"]').val(),
        title = $('input[name="review[title]"]').val(),
        text = $('textarea[name="review[review]"]').val(),
        book = $('input[name="data-book"]').val(),
        profile = $('input[name="data-editor"]').val();

    console.log(book)
    console.log(mark)

    $.ajax({
        url: '/api/controller/book/review.php',
        type: 'POST',
        dataType: 'JSON',
        data: {
            action: "newreview",
            mark: mark,
            title: title,
            text: text,
            book: book,
            profile: profile
        },
        success(data) {
            if (data.ok) {
                console.log('Нормалики')
            } else {
                console.log('пиздарики')
            }
        }
    });
});

$('#update-review').click(function(e){
    e.preventDefault();

    let mark = $('input[name="mymark"]').val(),
        title = $('input[name="review[title]"]').val(),
        review = $('input[name="data-review"]').val(),
        text = $('textarea[name="review[review]"]').val(),
        book = $('input[name="data-book"]').val(),
        profile = $('input[name="data-editor"]').val();

    console.log(book)
    console.log(mark)

    $.ajax({
        url: '/api/controller/book/review.php',
        type: 'POST',
        dataType: 'JSON',
        data: {
            action: "editreview",
            review: review,
            mark: mark,
            title: title,
            text: text,
            book: book,
            profile: profile,
            delete: isReviewDelete
        },
        success(data) {
            if (data.ok) {
                console.log('Нормалики')
            } else {
                console.log('пиздарики')
            }
        }
    });
});

$('.add-book__close-button').click(function () {
    $('.add-book').addClass('hidden')
});

let popupProfile = $('input[name="data-profile-popup"]')
let popupAction = $('input[name="data-action-popup"]') //Кароче это значение надо менять когда в списке что-то выбираешь, а то остается статический с того блока кнопки
let popupBook = $('input[name="data-book-id-popup"]')
let status = document.querySelector('.bc-menu__status-wrapper');

$('.ub-form-cansel').on('click', function () {
    $('.add-book__modal-remove').addClass('hidden');
});

//ОТКРЫТИЕ ОКНА СТАТУСА
$('.btn-add-plus').on('click', function () {
    $('.add-book').removeClass('hidden')
    $('.add-book__modal-remove').addClass('hidden');

    let $container = $('.userbook-container');
    let title = $container.attr('data-book-name')
    $('.add-book__book-title').text(title)

    popupProfile.val($container.data('profile'));
    popupBook.val($container.data('book-id'));
    popupAction.val($container.data('action'));

    let actionId = popupAction.val();
    let $statusItem = $('.add-book__action-item').eq(actionId - 1);
    let mark = $('.rating-in-popup');
    mark.addClass('hidden');

    if (!$statusItem.hasClass('not-selectable')) {
        $statusItem.removeClass('selected extendable');

        if (actionId % 2 === 0) {
            $statusItem.addClass('selected extendable');
            mark.removeClass('hidden')
        } else {
            $statusItem.addClass('selected');
            mark.addClass('hidden')
        }
    }

});

//ИЗМЕНЕНИЕ СТАТУСА КНИГИ
$('.add-book__action-title').on('click', function () {
    let $parent = $(this).closest('.add-book__action-item');
    let index = $('.add-book__action-item').index($parent);
    let mark = $('.rating-in-popup');
    mark.addClass('hidden');

    if (!$parent.hasClass('not-selectable')) {
        var $prevSelected = $('.add-book__action-item.selected');
        $prevSelected.removeClass('selected extendable');

        if (index % 2 === 0) {
            $parent.addClass('selected');
            mark.addClass('hidden');
        } else {
            $parent.addClass('selected extendable');
            mark.removeClass('hidden');
        }

        $('.btn-add-plus').addClass('btn-add-plus--add');
        let actionId = index + 1;

        if ($prevSelected.hasClass('selected')) {
            $('.add-book__modal-remove').removeClass('hidden');
        } else {
            $('.add-book__modal-remove').addClass('hidden');
        }

        $.ajax({
            url: '/api/controller/user/account.php',
            type: 'POST',
            dataType: 'JSON',
            data: {
                book: popupBook.val(),
                profile: popupProfile.val(),
                act: actionId,
                action: 'changemark'
            },
            success(data) {
                console.log(data);
                if (data.ok === true) {
                    let message;
                    switch (data.result){
                        case '1': message = '<a class="bc-menu__status bc-menu__status-lists" href="/views/reader/reading/">Читаю сейчас</a>';
                        break;
                        case '2': message = '<a class="bc-menu__status bc-menu__status-lists" href="/views/reader/read/">Прочитал</a>';
                        break;
                        case '3': message = '<a class="bc-menu__status bc-menu__status-lists" href="/views/reader/wish/">В планах</a>';
                        break;
                    }

                    status.innerHTML += message
                    console.log(popupAction)
                    popupAction.val(actionId)
                    console.log(popupAction)
                    $('.userbook-container').attr('data-action', actionId)
                } else {
                    console.log('не заебца');
                }
            }
        });
    }
});

//УДАЛЕНИЕ СТАТУСА КНИГИ
$('.ub-form-remove').on('click', function () {
    $.ajax({
        url: '/api/controller/user/account.php',
        type: 'POST',
        dataType: 'JSON',
        data: {
            book: popupBook.val(),
            profile: popupProfile.val(),
            action: 'removemark'
        },
        success(data) {
            console.log(data);
            if (data.ok === true) {
                $('.add-book__modal-remove').addClass('hidden');
                $('.btn-add-plus').removeClass('btn-add-plus--add');
            } else {
            }
        }
    });
});

$('.section-form__search-btn').click(function(e){
    e.preventDefault();
    $('#section-form-search').addClass('focus');
});

function Close() {
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
