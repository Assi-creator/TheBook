<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах" name="description">

    <title>Библиотека им. Л.Н.Толстого - контакты</title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

</head>
<body>
<?php  require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>
<br>
<main class="page-content-reader page-content main-body">
    <h1 style="margin: 15px; padding-bottom: 10px;">Наши контакты</h1>
    <br>
    <div class="section-default">
        <div class="container-default">
            <div class="contacts-list contacts-list--three">
                <div class="contacts-item">
                    <div class="contacts-item__title">
                        <img class="contacts-item__icon" src="/assets/images/root/icons/icon-phone.png"><span>Контактный телефон:</span>
                    </div>
                    <div class="contacts-item__content"><p class="contacts-item__link">8 (861) 259-29-28</p></div>
                </div>
                <div class="contacts-item">
                    <div class="contacts-item__title">
                        <img class="contacts-item__icon" src="/assets/images/root/icons/icon-email.png"><span>Свяжитесь по e-mail:</span>
                    </div>
                    <div class="contacts-item__content"><a class="contacts-item__link" href="mailto:cbsgk.lib.18@gmail.com"> cbsgk.lib.18@gmail.com</a></div>
                </div>
                <div class="contacts-item">
                    <div class="contacts-item__title">
                        <img class="contacts-item__icon" src="/assets/images/root/icons/icon-chatting.png">
                        <span>Мессенджеры:</span>
                    </div>
                    <div class="contacts-item__content">
                        <a class="contacts-item__link contacts-item__link--icon" href="https://vk.com/bibliolev ">
                            <img class="contacts-item__link-icon" src="/assets/images/root/icons/icon-vk.png">
                            <span>ВКонтакте</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-default">
        <div class="container-default">
            <div class="contacts-list contacts-list--three">
                <div class="contacts-item contacts-item--big">
                    <div class="contacts-item__title">
                        <img class="contacts-item__icon" src="/assets/images/root/icons/icon-briefcase.png"><span>Основаная информация:</span>
                    </div>
                    <div class="contacts-item__content">
                        <p> <strong>Полное наименование:</strong>Муниципальное учреждение культуры муниципального образования город Краснодар «Централизованная библиотечная система города Краснодара» Библиотека им. Л. Н. Толстого (филиал № 18)</p>
                        <p> <strong>Дата основания:</strong>Давно очень</p>
                        <p> <strong>График работы:</strong>Вторник - Воскресенье с 11:00-19:00</p>
                        <p> <strong style="color: white">График работы:</strong>Выходной - понедельник</p>
                        <p> <strong style="color: white">График работы:</strong>Каждый последняя пятница месяца - санитарный день</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-default">
        <div class="container-default">
            <div class="contacts-list contacts-list--three">
                <div class="contacts-item">
                    <div class="contacts-item__title">
                        <img class="contacts-item__icon" src="/assets/images/root/icons/icon-pin-map.png">
                        <span>Адрес библиотеки:</span>
                    </div>
                    <div class="contacts-item__content">
                        <p>350078, Краснодарский край, г. Краснодар, ул. Тургенева, д. 140/2</p>
                    </div>
                </div>
                <div class="contacts-item contacts-item--big">
                    <div class="contacts-map" id="map" style=""><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2302.250477525747!2d38.961987240410316!3d45.063942750548044!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40f04f8352454373%3A0xf62c47ff3a09db9a!2z0JHQuNCx0LvQuNC-0YLQtdC60LAg0LjQvCDQmy7QnS4g0KLQvtC70YHRgtC-0LPQvg!5e0!3m2!1sru!2sru!4v1684828517208!5m2!1sru!2sru" width="700" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>
</body>
</html>
