<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Редактирование профиля</title>

    <link rel="stylesheet" href="/assets/css/main.css">
    <link href="/assets/css/header.css" rel="stylesheet">
    <link rel="shortcut icon" href="/assets/images/the-book-icon.ico" type="image/x-i con">

    <script src="/assets/js/header.js" defer></script>
    <script src="/assets/js/profile.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.js"></script>
</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>
<main class="main-body page-content">
    <section class="header">
        <div class="header-context profile-context">
            <div class="header-container">
                <ul class="nav context">
                    <li class="standard">
                        <a href="/views/reader/">←</a>
                    </li>
                    <li class="active">
                        <a href="/reader/NastyaMastyugina/profile">Профиль</a>
                    </li>
                    <li class="standard" style="position: relative;">
                        <div id="div-profileedit-account-dropdown" class="div-context-more ll-toggle-hide"
                             style="margin-top: 65px; left: 0px; margin-left: 0px; display: none">
                            <div class="div-context-shadow" onclick="hideAccountDetails()"></div>
                            <ul id="ul-context-more" class="share-menu share-menu-ul oneline">
                                <li class="personal"><a href="/views/account/editemail">Добавить email</a></li>
                                <li class="personal"><a href="/views/account/editpassword/">Установить пароль</a></li>
                                <li class="personal"><a href="/views/account/lastvisits/">Входы в аккаунт</a></li>
                                <li class="personal"><a href="/views/account/close/">Закрыть аккаунт</a></li>
                            </ul>
                        </div>
                        <a onclick="showAccountDetails()">Аккаунт</a>
                    </li>
                    <li class="standard">
                        <a href="/views/account/security/" style="color:#FA385D">Настройки безопасности</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="wrapper-ugc" style="max-width: 816px; margin-top: 25px;">
            <form action="/account/saveprofile" method="POST" enctype="multipart/form-data" name="account_info">
                <div class="block-border card-block">
                    <div class="group-title">
                        <h2>Настройки профиля</h2>
                    </div>
                    <div class="with-pad form-new">
                        <div class="form-row">
                            <div class="tb-column-2">
                                <label class="label-form" for="account-name">Имя</label>
                                <div class="form-input">
                                    <input type="text" id="account-name" name="account[name]" value="Настя">
                                </div>
                            </div>
                            <div class="tb-column-sep"></div>
                            <div class="tb-column-2">
                                <label class="label-form" for="account-surname">Фамилия</label>
                                <div class="form-input">
                                    <input type="text" id="account-surname" name="account[surname]" value="Мастюгина">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="tb-column-2">
                                <label class="label-form" for="account-sex">Пол</label>
                                <select id="account-sex" name="account[sex]" data-compare_id="3" class="max"
                                        onchange="toggle_gender_custom_row($(this));">
                                    <option value="0">Выберите...</option>
                                    <option value="2" selected="">Женский</option>
                                    <option value="1">Мужской</option>
                                    <option value="3">Другое</option>
                                </select>
                            </div>
                            <div class="tb-column-sep"></div>
                            <div class="tb-column-2">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="tb-column-2">
                                <label class="label-form">Дата рождения</label>

                                <select name="birth-day" id="birth-day" onchange="">
                                    <option value="0">--</option>
                                    <option value="1">01</option>
                                    <option value="2">02</option>
                                    <option value="3">03</option>
                                    <option value="4">04</option>
                                    <option value="5">05</option>
                                    <option value="6">06</option>
                                    <option value="7">07</option>
                                    <option value="8">08</option>
                                    <option value="9">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18" selected="selected">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                </select>


                                <select name="birth-month" id="birth-month" onchange="ll_seledate_setmonth('birth');">
                                    <option value="0">--</option>
                                    <option value="1">январь</option>
                                    <option value="2">февраль</option>
                                    <option value="3">март</option>
                                    <option value="4">апрель</option>
                                    <option value="5">май</option>
                                    <option value="6">июнь</option>
                                    <option value="7">июль</option>
                                    <option value="8">август</option>
                                    <option value="9">сентябрь</option>
                                    <option value="10">октябрь</option>
                                    <option value="11">ноябрь</option>
                                    <option value="12" selected="selected">декабрь</option>
                                </select>

                                <select name="birth-year" id="birth-year" onchange="">
                                    <option value="0">----</option>
                                    <option value="2023">2023</option>
                                    <option value="2022">2022</option>
                                    <option value="2021">2021</option>
                                    <option value="2020">2020</option>
                                    <option value="2019">2019</option>
                                    <option value="2018">2018</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                    <option value="2014">2014</option>
                                    <option value="2013">2013</option>
                                    <option value="2012">2012</option>
                                    <option value="2011">2011</option>
                                    <option value="2010">2010</option>
                                    <option value="2009">2009</option>
                                    <option value="2008">2008</option>
                                    <option value="2007">2007</option>
                                    <option value="2006">2006</option>
                                    <option value="2005">2005</option>
                                    <option value="2004">2004</option>
                                    <option value="2003" selected="selected">2003</option>
                                    <option value="2002">2002</option>
                                    <option value="2001">2001</option>
                                    <option value="2000">2000</option>
                                    <option value="1999">1999</option>
                                    <option value="1998">1998</option>
                                    <option value="1997">1997</option>
                                    <option value="1996">1996</option>
                                    <option value="1995">1995</option>
                                    <option value="1994">1994</option>
                                    <option value="1993">1993</option>
                                    <option value="1992">1992</option>
                                    <option value="1991">1991</option>
                                    <option value="1990">1990</option>
                                    <option value="1989">1989</option>
                                    <option value="1988">1988</option>
                                    <option value="1987">1987</option>
                                    <option value="1986">1986</option>
                                    <option value="1985">1985</option>
                                    <option value="1984">1984</option>
                                    <option value="1983">1983</option>
                                    <option value="1982">1982</option>
                                    <option value="1981">1981</option>
                                    <option value="1980">1980</option>
                                    <option value="1979">1979</option>
                                    <option value="1978">1978</option>
                                    <option value="1977">1977</option>
                                    <option value="1976">1976</option>
                                    <option value="1975">1975</option>
                                    <option value="1974">1974</option>
                                    <option value="1973">1973</option>
                                    <option value="1972">1972</option>
                                    <option value="1971">1971</option>
                                    <option value="1970">1970</option>
                                    <option value="1969">1969</option>
                                    <option value="1968">1968</option>
                                    <option value="1967">1967</option>
                                    <option value="1966">1966</option>
                                    <option value="1965">1965</option>
                                    <option value="1964">1964</option>
                                    <option value="1963">1963</option>
                                    <option value="1962">1962</option>
                                    <option value="1961">1961</option>
                                    <option value="1960">1960</option>
                                    <option value="1959">1959</option>
                                    <option value="1958">1958</option>
                                    <option value="1957">1957</option>
                                    <option value="1956">1956</option>
                                    <option value="1955">1955</option>
                                    <option value="1954">1954</option>
                                    <option value="1953">1953</option>
                                    <option value="1952">1952</option>
                                    <option value="1951">1951</option>
                                    <option value="1950">1950</option>
                                    <option value="1949">1949</option>
                                    <option value="1948">1948</option>
                                    <option value="1947">1947</option>
                                    <option value="1946">1946</option>
                                    <option value="1945">1945</option>
                                    <option value="1944">1944</option>
                                    <option value="1943">1943</option>
                                    <option value="1942">1942</option>
                                    <option value="1941">1941</option>
                                    <option value="1940">1940</option>
                                    <option value="1939">1939</option>
                                    <option value="1938">1938</option>
                                    <option value="1937">1937</option>
                                    <option value="1936">1936</option>
                                    <option value="1935">1935</option>
                                    <option value="1934">1934</option>
                                    <option value="1933">1933</option>
                                    <option value="1932">1932</option>
                                    <option value="1931">1931</option>
                                    <option value="1930">1930</option>
                                    <option value="1929">1929</option>
                                    <option value="1928">1928</option>
                                    <option value="1927">1927</option>
                                    <option value="1926">1926</option>
                                    <option value="1925">1925</option>
                                    <option value="1924">1924</option>
                                    <option value="1923">1923</option>
                                </select>
                            </div>
                            <div class="tb-column-sep"></div>
                            <div class="tb-column-2">
                                <label class="label-form" for="account-location">Откуда вы?</label>
                                <div class="form-input">
                                    <input type="text" id="account-location" name="account[location]" value="">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="tb-column">
                                <label class="label-form" for="account-web">Расскажите о себе</label>
                                <div class="form-texteditor">
                                    <div id="teaccount-about-container">
                                        <div class="text-editor-container" id="teaccount-about-ed_editor">
                                            <div class="editor-textarea">
                                                <div class="textarea-outer">
                          <textarea placeholder="..." class="ed_textarea  llcut"
                                    id="account-about" name="account[about]"
                                    rows="10"></textarea>
                                                </div>
                                                <br>
                                                <div class="text-editor-separator"></div>

                                                <div class="separator"></div>
                                            </div>
                                            <div></div>
                                            <div class="ed_preview" id="teaccount-about-preview"
                                                 style="display:none"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <label class="label-form" for="account-picture">Аватарка</label>
                            <img alt="NastyaMastyugina" title="NastyaMastyugina"
                                 style="min-width:200px; background-color: #ffffff;"
                                 src="https://i.livelib.ru/userpic/NastyaMastyugina/200/261f/NastyaMastyugina.jpg"
                                 onerror="this.onerror=null;pagespeed.lazyLoadImages.loadIfVisibleAndMaybeBeacon(this);"
                                 width="200"><br>
                            <div class="tb-column-2 radiogroup">
                                <a href="javascript:void(0)"
                                   class="campaign-groups-a color-gray ll-toggle-active menu-item active"
                                   data-radio="campaign-groups-a" data-id="account_picture_action_current"><span
                                        class="ub-check"></span>Сохранить текущую</a>
                                <input id="account_picture_action_current" name="account[picture_action]"
                                       value="current" style="display:none;" type="radio" checked="checked">
                            </div>
                            <div class="tb-column-sep"></div>
                            <div class="tb-column-2 radiogroup">
                                <a href="javascript:void(0)"
                                   class="campaign-groups-a color-gray ll-toggle-active menu-item"
                                   data-radio="campaign-groups-a" data-id="account_picture_action_no"><span
                                        class="ub-check"></span>Удалить</a>
                                <input id="account_picture_action_no" name="account[picture_action]" value="no"
                                       style="display:none;" type="radio">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="tb-column-2 radiogroup">
                                <a id="account_picture" href="javascript:void(0)"
                                   class="campaign-groups-a color-gray ll-toggle-active menu-item"
                                   data-radio="campaign-groups-a" data-id="account_picture_action_new"><span
                                        class="ub-check"></span>Загрузить с компьютера</a>
                                <input id="account_picture_action_new" name="account[picture_action]" value="new"
                                       style="display:none;" type="radio">
                                <div class="form-file form-bottom-checkgroup">
                                    <input type="file" name="account[picture]" onclick="$('#account_picture').click();">
                                </div>
                            </div>
                            <div class="tb-column-sep"></div>
                            <div class="tb-column-2 radiogroup">
                                <a id="account_url" href="javascript:void(0)"
                                   class="campaign-groups-a color-gray ll-toggle-active menu-item"
                                   data-radio="campaign-groups-a" data-id="account_picture_action_url"><span
                                        class="ub-check"></span>Ссылка на внешнюю картинку</a>
                                <input id="account_picture_action_url" name="account[picture_action]" value="url"
                                       style="display:none;" type="radio">
                                <div class="form-input form-bottom-checkgroup">
                                    <input placeholder="http://" type="text" name="account[url]" value=""
                                           onclick="$('#account_url').click();">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="with-mpad block-bottom block-border-t" id="user-posts-more">
                        <input type="submit" name="btn_save" class="btn-fill btn-darkgreen" value="Сохранить">
                        <input type="button" class="btn-fill btn-wh right" value="Отмена"
                               onclick="location.href='/views/reader/';">
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>