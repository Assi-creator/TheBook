let avatar;
let value;
let $container;
let alert = document.getElementById('tinyalert');
let isReviewDelete = 0;
const buttons = document.querySelectorAll('a[data-id]');
const reviewCard = document.querySelectorAll('.brow');
const reviewCards = document.querySelectorAll('.review-card');

let popupProfile = $('input[name="data-profile-popup"]')
let popupAction = $('input[name="data-action-popup"]')
let popupBook = $('input[name="data-book-id-popup"]')
let popupReview = $('input[name="data-exist-review-popup"]')
let popupIdReview = $('input[name="data-review-popup"]')
let popupMark = $('input[name="data-mark-popup"]')
let popupSession = $('input[name="data-session-popup"]')


$('.page-header__login').click(function () {
    $('.popup__regForm').addClass('open');
    $('.popup__modal').addClass('popup_open');

    $('.popup__reg-error').text('');
});

$('.popup__btn-close').click(function () {
    $('.popup__regForm').removeClass('open');
    $('.popup__modal').removeClass('popup_open');
});

$('.popup__title a').click(function () {
    $('.popup__forgotPass').addClass('open');
});

$('.popup__btn-back').click(function () {
    $('.popup__forgotPass').removeClass('open');
});

$('.page-header__search-input').on({
    keyup: function () {
        let search =  $('input[name="search"]').val();

        if (search === ''){
            $('.ll-block-hide').css('display','none');
        } else {
            $.ajax({
                url: '/api/',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    Class: 'search',
                    function: 'bookSearch',
                    search: search
                },
                success(data) {
                    if (data.ok) {
                        if (data.result !== null) {
                            $('.ll-block-hide').css('display','flex');
                            //TODO: Добавить все ссылки и кнопку "Показать всё" изменять href
                            let searchResObjects = $('#search-res .search-res-objects');
                            searchResObjects.empty(); // очистка результатов предыдущего поиска
                            data.result.forEach(book => {
                                let listItem = $('<li>').addClass('search-res-object__item book-item__item book-item--short').attr('id', 'searchrow-' + book.id);
                                let link = $('<a>').addClass('book-item__link').attr('href', '/views/book?book=' + book.id_book +'').attr('title', book.title);
                                let img = $('<img>').attr('src', book.image).attr('width', '100%').attr('height', 'auto');
                                link.append(img);
                                let wrapper = $('<div>').addClass('book-item__wrapper');
                                let title = $('<a>').addClass('book-item__title').attr('href', '/views/book?book=' + book.id_book +'').text(book.title);
                                wrapper.append(title);
                                let author = $('<p>').addClass('book-item__author-wrap book-item__author').text(book.author);
                                wrapper.append(author);
                                let genresList = $('<ul>').addClass('link-menu__list');
                                book.genre.forEach(genres => {
                                    let genreItem = $('<li>');
                                    let genreLink = $('<a>').attr('href', '/views/genres/genre/?genre=' + genres.id_genre +'').text(genres.name);
                                    genreItem.append(genreLink);
                                    genresList.append(genreItem);
                                });
                                wrapper.append(genresList);
                                let rating = $('<span>').addClass('book-item__rating').text(book.rating);
                                wrapper.append(rating);
                                let stat = $('<div>').addClass('book-item-stat');
                                let added = $('<a>').addClass('icon-added-grey').attr('title', `${book.reads} прочитали`).css('cursor', 'default').text(book.reads);
                                let read = $('<a>').addClass('icon-read-grey').attr('title', `${book.wishs} планируют прочитать`).css('cursor', 'default').text(book.wishs);
                                let review = $('<a>').addClass('icon-review-grey').attr('title', `${book.reviews} рецензий`).attr('href', '/views/book/review/?book=' + book.id_book +'').text(book.reviews);
                                stat.append(added).append(read).append(review);
                                wrapper.append(stat);
                                listItem.append(link).append(wrapper);
                                searchResObjects.append(listItem);
                                $('.see-all').attr('href', '/views/find?search=' + search +'')
                            });
                        } else if (data.result === null) {
                            let searchResObjects = $('#search-res .search-res-objects');
                            searchResObjects.empty();
                            $('.ll-block-hide').css('display','none');
                        }
                    }
                }
            });
        }
    },
    focus: function (){
        // $('.ll-block-hide').css('display','flex');
    },
    click: function () {
        // $('.ll-block-hide').css('display','flex');
    }
});

document.addEventListener("click", function (e) {
    console.log(e.target);
});

$('.popup__send-code').click(function (e) {
    e.preventDefault()
    $('.popup__reg-email-error').text('');
    let email = $('input[name="forgot"]').val(),
        user = $('input[name="forgot-user"]').val()

    $.ajax({
        url: '/api/',
        type: 'POST',
        dataType: 'JSON',
        data: {
            Class: 'session',
            function: 'forgotPassword',
            email: email,
            user: user
        },
        success(data) {
            if (data.ok) {
                $('.popup__regForm').removeClass('open');
                $('.popup__modal').removeClass('popup_open');
                $('.popup__forgotPass').removeClass('open');
                let message = '<div class="green"> <a title="[x]" class="action a-close site-alert-close" onclick="Close();"><span class="i-clear"></span></a>' + data.result + '</div>'
                alert.innerHTML += message
            } else {

                $('.popup__reg-email-error').text(data.description);
            }
        }
    });
});

$('.btn-forgot-password__form_save').click(function (e) {
    e.preventDefault();
    let newPassword = $('input[name="forgot-new_password"]').val(),
        repeatNewPassword = $('input[name="forgot-repeat_password"]').val();
    alert.innerHTML = ''
    $.ajax({
        url: '/api/',
        type: 'POST',
        dataType: 'JSON',
        data: {
            Class: 'session',
            function: 'changeForgotPassword',
            new: newPassword,
            repeat: repeatNewPassword,
        },
        success(data) {
            if (data.ok) {
                document.location.href = '/views/reader/';
            } else {
                let message = '<div class="red"> <a title="[x]" class="action a-close site-alert-close" onclick="Close();"><span class="i-clear"></span></a>' + data.description + '</div>'
                alert.innerHTML += message
                window.scrollTo(0, 0);
            }
        }
    });
});

$('.popup__btn-login').click(function (e) {
    e.preventDefault();
    let login = $('input[name="login"]').val(),
        password = $('input[name="password"]').val();


    $.ajax({
        url: '/api/',
        type: 'POST',
        dataType: 'JSON',
        data: {
            Class: 'session',
            function: 'auth',
            login: login,
            password: password,
        },
        success(data) {
            if (data.ok) {
                document.location.href = '/';
            } else {
                $('.popup__reg-error').text(data.description);
            }
        }
    });
});

$('.logout').click(function(){
    $.ajax({
        url: '/api/',
        type: 'POST',
        dataType: 'JSON',
        data: {
            Class: 'session',
            function: 'logout',
        },
        success(data) {
            if (data.ok) {
                document.location.href = '/';
            }
        }
    });
})

$('.menu-item').click(function () {
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
        formData.append('Class', 'session');
        formData.append('function', 'registration');
        formData.append('card', card);
        formData.append('reader', reader);
        formData.append('login', login);
        formData.append('password', password);
        formData.append('email', email);
        formData.append('about', about);
        formData.append('value', value);
        formData.append('avatar', avatar);
        formData.append('avatarurl', avatarurl);
        formData.append('file', 2);

        $.ajax({
            url: '/api/',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            success(data) {
                if (data.ok) {
                    document.location.href = '/';
                } else {
                    let message = '<div class="red"> <a title="[x]" class="action a-close site-alert-close" onclick="Close();"><span class="i-clear"></span></a>' + data.description + '</div>'
                    alert.innerHTML += message
                    window.scrollTo(0, 0);
                }
            }
        });
    } else {
        window.scrollTo(0, 0);
    }
});

$('.email-change').click(function (e) {
    e.preventDefault();
    let error = 0;

    alert.innerHTML = ''
    if (error === 0) {
        let newEmail = $('input[name="account-new_email"]').val(),
            password = $('input[name="account-password"]').val();

        $.ajax({
            url: '/api/',
            type: 'POST',
            dataType: 'JSON',
            data: {
                Class: 'account',
                function: 'changeEmail',
                password: password,
                email: newEmail
            },
            success(data) {
                if (data.ok === true) {
                    document.location.href = '/index.php';
                } else {
                    let message = '<div class="red"> <a title="[x]" class="action a-close site-alert-close" onclick="Close();"><span class="i-clear"></span></a>' + data.description + '</div>'
                    alert.innerHTML += message
                    window.scrollTo(0, 0);
                }
            }
        });
    }
});

$('.change-password').click(function (e) {
    e.preventDefault();
    let error = 0;

    alert.innerHTML = ''
    if (error === 0) {
        let old = $('input[name="account-old_password"]').val(),
            newP = $('input[name="account-new_password"]').val(),
            repeat = $('input[name="account-repeat_password"]').val();

        $.ajax({
            url: '/api/',
            type: 'POST',
            dataType: 'JSON',
            data: {
                Class: 'account',
                function: 'changePassword',
                old: old,
                new: newP,
                repeat: repeat
            },
            success(data) {
                if (data.ok) {
                    document.location.href = '/views/reader/';
                } else {
                    let message = '<div class="red"> <a title="[x]" class="action a-close site-alert-close" onclick="Close();"><span class="i-clear"></span></a>' + data.description + '</div>'
                    alert.innerHTML += message
                    window.scrollTo(0, 0);
                }
            }
        });
    }
});

$('.change-reserv-email').click(function (e) {
    e.preventDefault();
    let error = 0;

    alert.innerHTML = ''
    if (error === 0) {
        let backup = $('input[name="security-email_backup"]').val();

        $.ajax({
            url: '/api/',
            type: 'POST',
            dataType: 'JSON',
            data: {
                Class: 'account',
                function: 'changeReservedEmail',
                backup: backup
            },
            success(data) {
                if (data.ok) {
                    let message = '<div class="green"> <a title="[x]" class="action a-close site-alert-close" onclick="Close();"><span class="i-clear"></span></a>Профиль изменен</div>'
                    alert.innerHTML += message
                    window.scrollTo(0, 0);
                } else {
                    let message = '<div class="red"> <a title="[x]" class="action a-close site-alert-close" onclick="Close();"><span class="i-clear"></span></a>' + data.description + '</div>'
                    alert.innerHTML += message
                    window.scrollTo(0, 0);
                }
            }
        });
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
        formEditData.append('Class', 'account');
        formEditData.append('function', 'editProfile');
        formEditData.append('login', login);
        formEditData.append('about', about);
        formEditData.append('value', value);
        formEditData.append('avatar', avatar);
        formEditData.append('avatarurl', avatarurl);
        formEditDataData.append('file', 2);

        $.ajax({
            url: '/api/',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formEditData,
            success(data) {
                if (data.ok) {
                    let message = '<div class="green"> <a title="[x]" class="action a-close site-alert-close" onclick="Close();"><span class="i-clear"></span></a>Профиль изменен</div>'
                    alert.innerHTML += message
                    window.scrollTo(0, 0);
                } else {
                    let message = '<div class="red"> <a title="[x]" class="action a-close site-alert-close" onclick="Close();"><span class="i-clear"></span></a>' + data.description + '</div>'
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

$('#reviewremove').click(function () {
    if ($('#reviewremove').is(':checked')) {
        isReviewDelete = 1
    } else {
        isReviewDelete = 0
    }
});

$('#create-review').click(function (e) {
    e.preventDefault();

    let mark = $('.popup-book-mark').text(),
        title = $('input[name="review[title]"]').val(),
        text = $('textarea[name="review[review]"]').val(),
        book = $('input[name="data-book"]').val(),
        profile = $('input[name="data-editor"]').val();

    $.ajax({
        url: '/api/',
        type: 'POST',
        dataType: 'JSON',
        data: {
            Class: 'review',
            function: 'newReview',
            mark: mark,
            title: title,
            text: text,
            book: book,
            profile: profile
        },
        success(data) {
            if (data.ok) {
                location.href = '/views/reader/reviews/'
            } else {
                let message = '<div class="red"> <a title="[x]" class="action a-close site-alert-close" onclick="Close();"><span class="i-clear"></span></a>' + data.description + '</div>'
                alert.innerHTML += message
                window.scrollTo(0, 0);
            }
        }
    });
});

$('#update-review').click(function (e) {
    e.preventDefault();

    let mark = $('.popup-book-mark').text(),
        title = $('input[name="review[title]"]').val(),
        review = $('input[name="data-review"]').val(),
        text = $('textarea[name="review[review]"]').val(),
        book = $('input[name="data-book"]').val(),
        profile = $('input[name="data-editor"]').val();

    $.ajax({
        url: '/api/',
        type: 'POST',
        dataType: 'JSON',
        data: {
            Class: 'review',
            function: 'editReview',
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
                if(data.result !== null) {
                    location.href = '/views/review/single/?review='+data.result+''
                } else {
                    location.href = '/views/reader/reviews/'
                }

            } else {
                let message = '<div class="red"> <a title="[x]" class="action a-close site-alert-close" onclick="Close();"><span class="i-clear"></span></a>' + data.description + '</div>'
                alert.innerHTML += message
                window.scrollTo(0, 0);
            }
        }
    });
});

$('.add-book__close-button').click(function () {
    $('.add-book').addClass('hidden')
    if ($(".popup-book-mark").length) {
        const ratingValue = parseInt(document.querySelector('.popup-book-mark').textContent);
        const ratingRadios = document.querySelectorAll('.rating-radio');

        for (let i = 0; i < ratingRadios.length; i++) {
            if (parseInt(ratingRadios[i].value) >= ratingValue) {
                const labelFor = ratingRadios[i].id;
                const label = document.querySelector(`label[for="${labelFor}"]`);
                label.click();
            }
        }
    }
});

$()

$('.ub-form-cansel').on('click', function () {
    $('.add-book__modal-remove').addClass('hidden');
});

$('.add-book__action-item label').on({
    click: function () {
        let $statusItem = $('.add-book__action-item');
        if (!$statusItem.hasClass('not-selectable')) {
            $('input[name="tmp_mark"]').val($(this).prev('input').val());
        }
    }
});

$('.btn-add-plus').on('click', function () {
    $('.add-book').removeClass('hidden')
    $('.add-book__modal-remove').addClass('hidden');

    $container = $(this).closest('[class^="userbook-container-"]');
    let containerId = $container.attr('class').match(/userbook-container-\d+/)[0];
    $container.attr('id', containerId);

    let title = $container.attr('data-book-name')
    $('.add-book__book-title').text(title)

    let popupmark = $container.attr('data-mark')
    let popupaction = $container.attr('data-action')

    popupMark.val(popupmark);
    popupSession.val($container.data('session'));
    popupProfile.val($container.data('profile'));
    popupBook.val($container.data('book-id'));
    popupAction.val(popupaction);
    popupReview.val($container.data('exist-review'));
    popupIdReview.val($container.data('review'));

    const ratingValue = popupmark;
    if (ratingValue !== '') {
        const ratingRadios = $('.add-book__rating').find('.rating-radio-popup');

        for (let i = 0; i < ratingRadios.length; i++) {
            if (parseInt(ratingRadios[i].value) >= ratingValue) {
                const labelFor = ratingRadios[i].id;
                const label = $('.add-book__rating').find(`label[for="${labelFor}"]`);
                label.click();
            }
        }
    }

    let actionId = popupaction;

    let $statusItem = $('.add-book__action-item').eq(actionId - 1);
    let mark = $('.rating-in-popup');
    $('.add-book__action-item').removeClass('selected extendable');
    mark.addClass('hidden')

    if (actionId !== "") {
        if (!$statusItem.hasClass('not-selectable')) {
            $('.add-book__action-item').removeClass('selected extendable');

            if (actionId % 2 === 0) {
                mark.removeClass('hidden')
                $statusItem.addClass('selected extendable');
            } else {
                $statusItem.addClass('selected');
                mark.addClass('hidden')
            }
        }
    }
    let reviewButton = $('.add-book__footer')
    reviewButton.empty();
    let exist = popupReview.val();

    if (exist === '1') {
        reviewButton.append('<a class="add-book__save-button add-book__save-button_outline" style="text-align: center;" href="/views/review/edit?review=' + popupIdReview.val() + '">Редактировать рецензию</a> <button class="add-book__save-button" type="button">Сохранить</button>')
    } else {
        reviewButton.append('<a class="add-book__save-button add-book__save-button_outline" style="text-align: center;" href="/views/review/create?book=' + popupBook.val() + '">Написать рецензию</a> <button class="add-book__save-button" type="button">Сохранить</button>')
    }

    $('.add-book__save-button').click(function () {
        let newMark = $('input[name="new_book_rating"]').val()

        console.log(newMark)
        if (newMark === 0 || newMark === '' || newMark === null || newMark === "0") {
            newMark = "1"
        }

        $.ajax({
            url: '/api/',
            type: 'POST',
            dataType: 'JSON',
            data: {
                Class: 'user',
                function: 'saveAction',
                book: popupBook.val(),
                profile: popupProfile.val(),
                act: popupAction.val(),
                mark: newMark,
                review: popupIdReview.val()
            },
            success(response) {
                if (response.ok) {
                    $container.attr('data-mark', null)
                    $container.attr('data-action', null)

                    let idStatus = popupBook.val()
                    let status = $('.bc-menu__status-wrapper.status-' + idStatus + ' ')
                    let message;

                    switch (response.result) {
                        case '1':
                            message = '<a class="bc-menu__status bc-menu__status-lists" href="/views/reader/reading/">Читаю сейчас</a>';
                            break;
                        case '2':
                            message = '<a class="bc-menu__status bc-menu__status-lists" href="/views/reader/read/">Прочитал</a>';
                            break;
                        case '3':
                            message = '<a class="bc-menu__status bc-menu__status-lists" href="/views/reader/wish/">В планах</a>';
                            break;
                    }

                    if (status.length > 0) {
                        status[0].innerHTML += message
                    }

                    if (popupAction.val() === '2') {
                        $container.attr('data-mark', Number(newMark))

                        $.ajax({
                            url: '/api/',
                            type: 'POST',
                            dataType: 'JSON',
                            data: {
                                Class: 'book',
                                function: 'getBookRating',
                                id: popupBook.val()
                            },
                            success(data) {
                                if ($(".popup-book-mark").length){
                                    if ($('.bc-rating-medium').hasClass(popupBook.val())){
                                        $('.bc-rating-medium span').text(data)
                                        const ratingValue = parseInt(document.querySelector('.popup-book-mark').textContent);
                                        const ratingRadios = document.querySelectorAll('.rating-radio');

                                        for (let i = 0; i < ratingRadios.length; i++) {
                                            if (parseInt(ratingRadios[i].value) >= ratingValue) {
                                                const labelFor = ratingRadios[i].id;
                                                const label = document.querySelector(`label[for="${labelFor}"]`);
                                                label.click();
                                            }
                                        }
                                    }
                                }

                                if ($('.carousel-book__rating').length){
                                    let val = popupBook.val();
                                    if ($('.carousel-book__rating').hasClass(val)) {
                                        $('.'+ val +'').text(data);
                                    }
                                }

                                if($('.lists__mymark').length){
                                    let val = popupBook.val();
                                    $('.lists__mymark.'+ val +' ').css('display', 'flex')
                                    if ($('.lists__mymark').hasClass(val)) {
                                        $('.lists__mymark.'+ val +' ').css('display', null)
                                        $('.lists__mymark.'+ val +' ').text(newMark)
                                    }
                                }
                            }
                        });
                        $('.add-book').addClass('hidden')
                    } else if (popupAction.val() === '1' || popupAction.val() === '3') {
                        $.ajax({
                            url: '/api/',
                            type: 'POST',
                            dataType: 'JSON',
                            data: {
                                Class: 'book',
                                function: 'getBookRating',
                                id: popupBook.val()
                            },
                            success(data) {
                                if ($('.carousel-book__rating').length){
                                    let val = popupBook.val();
                                    if ($('.carousel-book__rating').hasClass(val)) {
                                        $('.'+ val +'').text(data);
                                    }
                                }

                                if($('.lists__mymark').length){
                                    let val = popupBook.val();
                                    if ($('.lists__mymark').hasClass(val)) {
                                        $('.lists__mymark.'+ val +' ').text(null)
                                        $('.lists__mymark.'+ val +' ').css('display', 'none')
                                    }
                                }
                            }
                        });

                        $('.add-book').addClass('hidden')
                        $('.popup-book-mark').text('')
                    }
                    $container.attr('data-action', Number(popupAction.val()))
                }
            }
        });

    });
});


$('.add-book__action-title').on('click', function () {
    if (popupSession.val() === '') {
        $('.popup__regForm').addClass('open');
        $('.popup__modal').addClass('popup_open');

        $('.popup__reg-error').text('');
    } else {
        let $parent = $(this).closest('.add-book__action-item');
        let index = $('.add-book__action-item').index($parent);
        let mark = $('.rating-in-popup');
        mark.addClass('hidden');

        if (!$parent.hasClass('not-selectable')) {
            var $prevSelected = $('.add-book__action-item.selected');
            $('.add-book__action-item').removeClass('selected extendable');

            if (index % 2 === 0) {
                $parent.addClass('selected');
                mark.addClass('hidden');
            } else {
                $parent.addClass('selected extendable');
                mark.removeClass('hidden');
            }

            $container.find($('.btn-add-plus')).addClass('btn-add-plus--add');

            let actionId = index + 1;

            if ($prevSelected.hasClass('selected')) {
                $('.add-book__modal-remove').removeClass('hidden');
            } else {
                $('.add-book__modal-remove').addClass('hidden');
            }
            popupAction.val(actionId)
        }
    }
});

$('.ub-form-remove').on('click', function () {
    $.ajax({
        url: '/api/',
        type: 'POST',
        dataType: 'JSON',
        data: {
            book: popupBook.val(),
            profile: popupProfile.val(),
            Class: 'user',
            function: 'removeAction'

        },
        success(data) {
            if (data.ok) {
                $('.add-book__modal-remove').addClass('hidden');
                $container.find($('.btn-add-plus')).removeClass('btn-add-plus--add');
                $('.add-book__action-item').removeClass('selected extendable');

                $container.attr('data-mark', null)
                $container.attr('data-action', null)
                $('.popup-book-mark').text(null)

                $.ajax({
                    url: '/api/',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        Class: 'book',
                        function: 'getBookRating',
                        id: popupBook.val()
                    },
                    success(data) {
                        if ($(".popup-book-mark").length){
                            if ($('.bc-rating-medium').hasClass(popupBook.val())){
                                $('.bc-rating-medium span').text(data)
                            }
                        }

                        if ($('.carousel-book__rating').length){
                            let val = popupBook.val();
                            if ($('.carousel-book__rating').hasClass(val)) {
                                $('.'+ val +'').text(data);
                            }
                        }

                        if($('.lists__mymark').length){
                            let val = popupBook.val();
                            if ($('.lists__mymark').hasClass(val)) {
                                $('.lists__mymark.'+ val +' ').text(null)
                                $('.lists__mymark.'+ val +' ').css('display', 'none')
                            }
                        }
                    }
                });
                let idStatus = popupBook.val()
                let status = $('.bc-menu__status-wrapper.status-' + idStatus + ' ')
                if (status.length > 0) {
                    status[0].innerHTML = ''
                }

                $('.add-book').addClass('hidden')
            }
        }
    });
});

$('.add-book__rating label').on({
    click: function () {
        $('input[name="new_book_rating"]').val($(this).prev('input').val());
        $('.popup-book-mark').text($(this).prev('input').val());
    }
});

$('.section-form__search-btn').click(function (e) {
    e.preventDefault();
    $('#section-form-search').addClass('focus');

    let gerne = $('input[name="filter-genre-id"]').val(),
        rating = $('input[name="filter-rating"]').val(),
        order = $('input[name="filter-order"]').val(),
        date =  $('input[name="filter-month"]').val(),
        name = $('input[name="filter-search"]').val()

    const params = new URLSearchParams();
    if (gerne !== '') {
        params.append('genre', gerne);
    }
    if (rating !== '') {
        params.append('rating', rating);
    }
    if (date !== '') {
        params.append('date', date);
    }
    if (order !== '') {
        params.append('order', order);
    }
    if(name !== '') {
        params.append('name', name);
    }
    const url = '/views/review/search/' + (params.toString() !== '' ? `?${params.toString()}` : '');
    window.location.href = url;
});

$('#btn_add_book').click(function(){
    alert.innerHTML = ''
        let title = $('input[name="title-book"]').val(),
            author = $('input[name="book-author"]').val(),
            genre = $('input[name="subgenre-id"]').val(),
            publishing = $('input[name="book-publishing"]').val(),
            ISBN = $('input[name="book-ISBN"]').val(),
            pages = $('input[name="book-count"]').val(),
            year = $('input[name="book-year"]').val(),
            age = $('input[name="book-age"]').val(),
            series = $('input[name="book-series"]').val(),
            annotation = $('textarea[name="book-annotation"]').val(),
            avatarurl = $('input[name="profile-url"]').val();

        let formAddData = new FormData();
        formAddData.append('Class', 'book');
        formAddData.append('function', 'setNewBook');
        formAddData.append('value', value);
        formAddData.append('file', 1);
        formAddData.append('title', title);
        formAddData.append('author', author);
        formAddData.append('genre', genre);
        formAddData.append('publishing', publishing);
        formAddData.append('ISBN', ISBN);
        formAddData.append('pages', pages);
        formAddData.append('year', year);
        formAddData.append('age', age);
        formAddData.append('series', series);
        formAddData.append('annotation', annotation);
        formAddData.append('annotation', annotation);
        formAddData.append('avatar', avatar);
        formAddData.append('avatarurl', avatarurl);

        $.ajax({
            url: '/api/',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formAddData,
            success(data) {
                console.log(data)
            }
        });
});

$('.lenta-review').each(function () {
    var reviewTextEscaped = $(this).find('#lenta-card__text-review-escaped');
    if (reviewTextEscaped.length !== 0) {
        var reviewTextWrapper = reviewTextEscaped.closest('.lenta-card');
        var reviewTextFull = reviewTextWrapper.find('#lenta-card__text-review-fulltext');

        if (reviewTextEscaped.height() > 200) {
            reviewTextEscaped.css('max-height', '220px');
            reviewTextWrapper.append($('<a/>').addClass('btn__read-more').text('Читать полностью'));

            reviewTextWrapper.find('.btn__read-more').on('click', function (e) {
                e.preventDefault();
                if ($(this).hasClass('open')) {
                    $(this).removeClass('open').text('Читать полностью');
                    reviewTextEscaped.css('max-height', '220px');
                    reviewTextFull.addClass('hidden');
                    reviewTextEscaped.css('display', '');
                } else {
                    $(this).addClass('open').text('Скрыть текст');
                    reviewTextFull.removeClass('hidden');
                    reviewTextEscaped.css('display', 'none');
                }
            });
        }
    }
});

const details = document.querySelectorAll(".ll-details-closed");

// добавить к каждому клику события клика
[...details].forEach((targetDetail) => {
    targetDetail.addEventListener("click", _ => {
        // закрывать всех кроме кликнутого
        details.forEach((detail) => {
            if (detail !== targetDetail) {
                detail.removeAttribute("open");
            }
        });
    });
});

$('.review-menu__stars label').on({
    click: function () {
        $('input[name="mymark"]').val($(this).prev('input').val());
        $('.popup-book-mark').text($(this).prev('input').val());
    }
});

if ($(".popup-book-mark").length) {
    const ratingValue = parseInt(document.querySelector('.popup-book-mark').textContent);
    const ratingRadios = document.querySelectorAll('.rating-radio');

    for (let i = 0; i < ratingRadios.length; i++) {
        if (parseInt(ratingRadios[i].value) >= ratingValue) {
            const labelFor = ratingRadios[i].id;
            const label = document.querySelector(`label[for="${labelFor}"]`);
            label.click();
        }
    }

}

if ($(".popup-book-mark").length) {
    const ratingValue = parseInt(document.querySelector('.popup-book-mark').textContent);
    const ratingRadios = document.querySelectorAll('.review-radio');

    for (let i = 0; i < ratingRadios.length; i++) {
        if (parseInt(ratingRadios[i].value) >= ratingValue) {
            const labelFor = ratingRadios[i].id;
            const label = document.querySelector(`label[for="${labelFor}"]`);
            label.click();
        }
    }
}
$('input[name="profile-file"]').change(function (e) {
    avatar = e.target.files[0];
});
buttons.forEach(button => {
    button.addEventListener('click', function () {
        const id = this.dataset.id;
        const input = document.querySelector(`#${id}`);
        value = input.value;
    });
});
reviewCard.forEach(card => {
    const reviewId = card.querySelector('.reviewID').value
    const reviewText = card.querySelector('#review-text-brief');
    if (reviewText !== null) {
        const reviewTextHeight = reviewText.offsetHeight;
        if (reviewTextHeight > 200) {
            const descriptionDiv = reviewText.closest('.lenta-card');
            descriptionDiv.innerHTML += '<a href="/views/review/single?review=' + reviewId + '" style="font-size: 16px;" class="btn__read-more">Читать полностью</a>';
            $('.btn-add-plus').on('click', function () {
                $('.add-book').removeClass('hidden')
                $('.add-book__modal-remove').addClass('hidden');

                $container = $(this).closest('[class^="userbook-container-"]');
                let containerId = $container.attr('class').match(/userbook-container-\d+/)[0];
                $container.attr('id', containerId);

                let title = $container.attr('data-book-name')
                $('.add-book__book-title').text(title)

                let popupmark = $container.attr('data-mark')
                let popupaction = $container.attr('data-action')

                popupMark.val(popupmark);
                popupSession.val($container.data('session'));
                popupProfile.val($container.data('profile'));
                popupBook.val($container.data('book-id'));
                popupAction.val(popupaction);
                popupReview.val($container.data('exist-review'));
                popupIdReview.val($container.data('review'));

                const ratingValue = popupmark;
                if (ratingValue !== '') {
                    const ratingRadios = $('.add-book__rating').find('.rating-radio-popup');

                    for (let i = 0; i < ratingRadios.length; i++) {
                        if (parseInt(ratingRadios[i].value) >= ratingValue) {
                            const labelFor = ratingRadios[i].id;
                            const label = $('.add-book__rating').find(`label[for="${labelFor}"]`);
                            label.click();
                        }
                    }
                }

                let actionId = popupaction;

                let $statusItem = $('.add-book__action-item').eq(actionId - 1);
                let mark = $('.rating-in-popup');
                $('.add-book__action-item').removeClass('selected extendable');
                mark.addClass('hidden')

                if (actionId !== "") {
                    if (!$statusItem.hasClass('not-selectable')) {
                        $('.add-book__action-item').removeClass('selected extendable');

                        if (actionId % 2 === 0) {
                            mark.removeClass('hidden')
                            $statusItem.addClass('selected extendable');
                        } else {
                            $statusItem.addClass('selected');
                            mark.addClass('hidden')
                        }
                    }
                }
                let reviewButton = $('.add-book__footer')
                reviewButton.empty();
                let exist = popupReview.val();

                if (exist === '1') {
                    reviewButton.append('<a class="add-book__save-button add-book__save-button_outline" style="text-align: center;" href="/views/review/edit?review=' + popupIdReview.val() + '">Редактировать рецензию</a> <button class="add-book__save-button" type="button">Сохранить</button>')
                } else {
                    reviewButton.append('<a class="add-book__save-button add-book__save-button_outline" style="text-align: center;" href="/views/review/create?book=' + popupBook.val() + '">Написать рецензию</a> <button class="add-book__save-button" type="button">Сохранить</button>')
                }

                $('.add-book__save-button').click(function () {
                    let newMark = $('input[name="new_book_rating"]').val()
                    $.ajax({
                        url: '/api/',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            Class: 'user',
                            function: 'saveAction',
                            book: popupBook.val(),
                            profile: popupProfile.val(),
                            act: popupAction.val(),
                            mark: newMark,
                            review: popupIdReview.val()
                        },
                        success(data) {
                            if (data.ok) {
                                $container.attr('data-mark', null)
                                $container.attr('data-action', null)

                                if (popupAction.val() === '2') {
                                    $container.attr('data-mark', Number(newMark))

                                    $.ajax({
                                        url: '/api/',
                                        type: 'POST',
                                        dataType: 'JSON',
                                        data: {
                                            Class: 'book',
                                            function: 'getBookRating',
                                            id: popupBook.val()
                                        },
                                        success(data) {
                                            if ($(".popup-book-mark").length){
                                                if ($('.bc-rating-medium').hasClass(popupBook.val())){
                                                    $('.bc-rating-medium span').text(data)
                                                    const ratingValue = parseInt(document.querySelector('.popup-book-mark').textContent);
                                                    const ratingRadios = document.querySelectorAll('.rating-radio');

                                                    for (let i = 0; i < ratingRadios.length; i++) {
                                                        if (parseInt(ratingRadios[i].value) >= ratingValue) {
                                                            const labelFor = ratingRadios[i].id;
                                                            const label = document.querySelector(`label[for="${labelFor}"]`);
                                                            label.click();
                                                        }
                                                    }
                                                }
                                            }

                                            if ($('.carousel-book__rating').length){
                                                let val = popupBook.val();
                                                if ($('.carousel-book__rating').hasClass(val)) {
                                                    $('.'+ val +'').text(data);
                                                }
                                            }

                                            if($('.lists__mymark').length){
                                                let val = popupBook.val();
                                                $('.lists__mymark.'+ val +' ').css('display', 'flex')
                                                if ($('.lists__mymark').hasClass(val)) {
                                                    $('.lists__mymark.'+ val +' ').text(newMark)
                                                    console.log($('.lists__mymark.'+ val +' '))
                                                }
                                            }
                                        }
                                    });
                                    $('.add-book').addClass('hidden')
                                } else {
                                    $.ajax({
                                        url: '/api/',
                                        type: 'POST',
                                        dataType: 'JSON',
                                        data: {
                                            Class: 'book',
                                            function: 'getBookRating',
                                            id: popupBook.val()
                                        },
                                        success(data) {
                                            if ($('.carousel-book__rating').length){
                                                let val = popupBook.val();
                                                if ($('.carousel-book__rating').hasClass(val)) {
                                                    $('.'+ val +'').text(data);
                                                }
                                            }

                                            if($('.lists__mymark').length){
                                                let val = popupBook.val();
                                                if ($('.lists__mymark').hasClass(val)) {
                                                    $('.lists__mymark.'+ val +' ').text(null)
                                                    $('.lists__mymark.'+ val +' ').css('display', 'none')
                                                }
                                            }
                                        }
                                    });

                                    $('.add-book').addClass('hidden')
                                    $('.popup-book-mark').text('')
                                }
                                $container.attr('data-action', Number(popupAction.val()))
                            }
                        }
                    });

                });
            });
        }
    }
});
reviewCards.forEach(cards => {
    const reviewId = cards.querySelector('.reviewID').value
    const reviewText = cards.querySelector('#lenta-card__text-review-escaped');
    if (reviewText !== null) {
        const reviewTextHeight = reviewText.offsetHeight;
        if (reviewTextHeight > 200) {
            const descriptionDiv = reviewText.closest('.lenta-card');
            descriptionDiv.innerHTML += '<a href="/views/review/single?review=' + reviewId + '" style="font-size: 16px;" class="btn__read-more">Читать полностью</a>';
            $('.btn-add-plus').on('click', function () {
                $('.add-book').removeClass('hidden')
                $('.add-book__modal-remove').addClass('hidden');

                $container = $(this).closest('[class^="userbook-container-"]');
                let containerId = $container.attr('class').match(/userbook-container-\d+/)[0];
                $container.attr('id', containerId);

                let title = $container.attr('data-book-name')
                $('.add-book__book-title').text(title)

                let popupmark = $container.attr('data-mark')
                let popupaction = $container.attr('data-action')

                popupMark.val(popupmark);
                popupSession.val($container.data('session'));
                popupProfile.val($container.data('profile'));
                popupBook.val($container.data('book-id'));
                popupAction.val(popupaction);
                popupReview.val($container.data('exist-review'));
                popupIdReview.val($container.data('review'));

                const ratingValue = popupmark;
                if (ratingValue !== '') {
                    const ratingRadios = $('.add-book__rating').find('.rating-radio-popup');

                    for (let i = 0; i < ratingRadios.length; i++) {
                        if (parseInt(ratingRadios[i].value) >= ratingValue) {
                            const labelFor = ratingRadios[i].id;
                            const label = $('.add-book__rating').find(`label[for="${labelFor}"]`);
                            label.click();
                        }
                    }
                }

                let actionId = popupaction;

                let $statusItem = $('.add-book__action-item').eq(actionId - 1);
                let mark = $('.rating-in-popup');
                $('.add-book__action-item').removeClass('selected extendable');
                mark.addClass('hidden')

                if (actionId !== "") {
                    if (!$statusItem.hasClass('not-selectable')) {
                        $('.add-book__action-item').removeClass('selected extendable');

                        if (actionId % 2 === 0) {
                            mark.removeClass('hidden')
                            $statusItem.addClass('selected extendable');
                        } else {
                            $statusItem.addClass('selected');
                            mark.addClass('hidden')
                        }
                    }
                }
                let reviewButton = $('.add-book__footer')
                reviewButton.empty();
                let exist = popupReview.val();

                if (exist === '1') {
                    reviewButton.append('<a class="add-book__save-button add-book__save-button_outline" style="text-align: center;" href="/views/review/edit?review=' + popupIdReview.val() + '">Редактировать рецензию</a> <button class="add-book__save-button" type="button">Сохранить</button>')
                } else {
                    reviewButton.append('<a class="add-book__save-button add-book__save-button_outline" style="text-align: center;" href="/views/review/create?book=' + popupBook.val() + '">Написать рецензию</a> <button class="add-book__save-button" type="button">Сохранить</button>')
                }

                $('.add-book__save-button').click(function () {
                    let newMark = $('input[name="new_book_rating"]').val()

                    console.log(newMark)
                    if (newMark === 0 || newMark === '' || newMark === null || newMark === "0") {
                        newMark = "1"
                    }

                    $.ajax({
                        url: '/api/',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            Class: 'user',
                            function: 'saveAction',
                            book: popupBook.val(),
                            profile: popupProfile.val(),
                            act: popupAction.val(),
                            mark: newMark,
                            review: popupIdReview.val()
                        },
                        success(response) {
                            if (response.ok) {
                                $container.attr('data-mark', null)
                                $container.attr('data-action', null)

                                let idStatus = popupBook.val()
                                let status = $('.bc-menu__status-wrapper.status-' + idStatus + ' ')
                                console.log(status)
                                let message;

                                switch (response.result) {
                                    case '1':
                                        message = '<a class="bc-menu__status bc-menu__status-lists" href="/views/reader/reading/">Читаю сейчас</a>';
                                        break;
                                    case '2':
                                        message = '<a class="bc-menu__status bc-menu__status-lists" href="/views/reader/read/">Прочитал</a>';
                                        break;
                                    case '3':
                                        message = '<a class="bc-menu__status bc-menu__status-lists" href="/views/reader/wish/">В планах</a>';
                                        break;
                                }

                                if (status.length > 0) {
                                    status[0].innerHTML += message
                                }

                                if (popupAction.val() === '2') {
                                    $container.attr('data-mark', Number(newMark))

                                    $.ajax({
                                        url: '/api/',
                                        type: 'POST',
                                        dataType: 'JSON',
                                        data: {
                                            Class: 'book',
                                            function: 'getBookRating',
                                            id: popupBook.val()
                                        },
                                        success(data) {
                                            if ($(".popup-book-mark").length){
                                                if ($('.bc-rating-medium').hasClass(popupBook.val())){
                                                    $('.bc-rating-medium span').text(data)
                                                    const ratingValue = parseInt(document.querySelector('.popup-book-mark').textContent);
                                                    const ratingRadios = document.querySelectorAll('.rating-radio');

                                                    for (let i = 0; i < ratingRadios.length; i++) {
                                                        if (parseInt(ratingRadios[i].value) >= ratingValue) {
                                                            const labelFor = ratingRadios[i].id;
                                                            const label = document.querySelector(`label[for="${labelFor}"]`);
                                                            label.click();
                                                        }
                                                    }
                                                }
                                            }

                                            if ($('.carousel-book__rating').length){
                                                let val = popupBook.val();
                                                if ($('.carousel-book__rating').hasClass(val)) {
                                                    $('.'+ val +'').text(data);
                                                }
                                            }

                                            if($('.lists__mymark').length){
                                                let val = popupBook.val();
                                                $('.lists__mymark.'+ val +' ').css('display', 'flex')
                                                if ($('.lists__mymark').hasClass(val)) {
                                                    $('.lists__mymark.'+ val +' ').text(newMark)
                                                    console.log($('.lists__mymark.'+ val +' '))
                                                }
                                            }
                                        }
                                    });
                                    $('.add-book').addClass('hidden')
                                } else if (popupAction.val() === '1' || popupAction.val() === '3') {
                                    $.ajax({
                                        url: '/api/',
                                        type: 'POST',
                                        dataType: 'JSON',
                                        data: {
                                            Class: 'book',
                                            function: 'getBookRating',
                                            id: popupBook.val()
                                        },
                                        success(data) {
                                            if ($('.carousel-book__rating').length){
                                                let val = popupBook.val();
                                                if ($('.carousel-book__rating').hasClass(val)) {
                                                    $('.'+ val +'').text(data);
                                                }
                                            }

                                            if($('.lists__mymark').length){
                                                let val = popupBook.val();
                                                if ($('.lists__mymark').hasClass(val)) {
                                                    $('.lists__mymark.'+ val +' ').text(null)
                                                    $('.lists__mymark.'+ val +' ').css('display', 'none')
                                                }
                                            }
                                        }
                                    });

                                    $('.add-book').addClass('hidden')
                                    $('.popup-book-mark').text('')
                                }
                                $container.attr('data-action', Number(popupAction.val()))
                            }
                        }
                    });

                });
            });
        }
    }
});
$.each($('.radiogroup'), function (index, val) {
    if ($(this).find('menu-item').prop('checked') === true) {
        $(this).addClass('active');
    }
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
