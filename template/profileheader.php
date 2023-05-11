<section class="header">
    <!--Верхнее меню-->
    <div id="profile-bg-wrapper" class="gp-wrapper user-profile"
         style="background: url(<?php echo $_SESSION['user']['cover_path']; ?>) <?php if($_SESSION['user']['cover_path'] === '/assets/images/root/icons/back-profile.png'){echo 'center center repeat-x #dbe0e6; background-size: contain !important;';} else{echo 'center center no-repeat; background-size: cover !important;';} ?> ;  height: 148px; width: 100%;">
        <div class="gp-outer">
            <div class="gp-inner">
                <table class="gp-table">
                    <tbody>
                    <tr>
                        <td class="gp-avatar">
                            <div id="profile-avatar" class="profile-avatar">
                                 <img src="<?php echo $_SESSION['user']['avatar_path']; ?>" height="100%" width="100%" style="width:92px !important; height:92px !important; object-fit: cover;"  alt="">
                                <div id="userpic-edit" class="userpic-edit">
                                    <div class="userpic-edit-back"></div>
                                    <a class="userpic-edit-a" onclick="showImagePopup()">
                                        <span class="i-tag-add" style="margin-left: -3px"></span>Добавить
                                    </a>
                                </div>
                            </div>
                        </td>


                        <td class="gp-details">
                            <div class="gp-more">
                                <div class="btn-inline ll-select ll-select-more"
                                     style="margin-left: 13px; vertical-align: top">
                                    <a class="btn-icon-empty btn-wh ll-click-toggle" onclick="showMoreDetails()">
                                        <span class="group-more-menu"></span>
                                    </a>

                                    <div id="div-profile-menu-more" class="ll-toggle-hide"
                                         style="visibility: visible; display: none;">
                                        <div class="div-context-shadow" onclick="hideMoreDetails()"></div>
                                        <div id="profile-menu-more" class="ll-select-holder"
                                             style="top: 36px; z-index: 10002;">
                                            <a class="ll-select-row" onclick="showImagePopup()">Добавить
                                                аватарку</a>
                                            <a class="ll-select-row">Добавить обложку</a>
                                            <a class="ll-select-row" href="/views/account/editprofile/">Редактировать профиль</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span id="header-profile-login"
                                  class="header-profile-login"><?php echo $_SESSION['user']['login']; ?></span>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <!--Окно с добавлением аватара-->
                <div id="user-pic-edit" style="display: none">
                    <div id="userpic-edit-popup">
                        <div class="popup-back"
                             style="display: block; z-index: 1000; overflow: auto; background: rgba(57, 66, 76, 0.5);">
                            <div style="position: absolute; width: 100%; height: 100%">
                                <div style="width: 100%; height: 100%; display: table">
                                    <div style="text-align: center; vertical-align: middle; display:table-cell;">
                                        <div class="block-border card-block"
                                             style="z-index: 1001; width: 908px; text-align: left; margin: 0 auto">
                                            <div class="group-title">
                                                <a class="right uderpic-popup-close" onclick="hideImagePopup()"
                                                   title="Закрыть">
                                                    <span class="i-cardclose" style="margin-right: -2px;"></span>
                                                </a>
                                                <h2>Изменение аватарки</h2>
                                            </div>
                                            <div class="with-pad">
                                                <p>С помощью ползунков выберите квадратное изображение, которое
                                                    будет использоваться в профиле и списках.</p>
                                                <div class="margs-top" style="position: relative;">
                                                    <div>
                                                        <div id="userpic-crop-image" class="marg-right"
                                                             style="float: left;">
                                                            <div id="imgouter" style="width: 200px;">
                                                                <img id="imgsource" style="width: 200px;"
                                                                     src="/assets/images/root/icons/noavatar.svg"
                                                                     class="cropper-hidden">
                                                                <div class="cropper-container cropper-bg"
                                                                     touch-action="none"
                                                                     style="width: 202px; height: 204px;">
                                                                    <div class="cropper-wrap-box">
                                                                        <div class="cropper-canvas"
                                                                             style="width: 208px; height: 208px; transform: translateX(-3px);">
                                                                            <img src="/assets/images/root/icons/noavatar.svg"
                                                                                 alt="The image to crop"
                                                                                 class="cropper-hide"
                                                                                 style="width: 208px; height: 208px; transform: none;">
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="cropper-drag-box cropper-crop cropper-modal"
                                                                        data-cropper-action="crop"></div>
                                                                    <div class="cropper-crop-box"
                                                                         style="width: 161.6px; height: 163.2px; transform: translateX(16.4px);">
                                                                            <span class="cropper-view-box">
                                                                                <img src="/assets/images/root/icons/noavatar.svg"
                                                                                     alt="The image to preview"
                                                                                     style="width: 208px; height: 208px; transform: translateX(-19.4px);">
                                                                            </span>
                                                                        <span
                                                                            class="cropper-dashed dashed-h"></span>
                                                                        <span
                                                                            class="cropper-dashed dashed-v"></span>
                                                                        <span class="cropper-center"></span>
                                                                        <span class="cropper-face cropper-move"
                                                                              data-cropper-action="all"></span>
                                                                        <span class="cropper-line line-e"
                                                                              data-cropper-action="e"></span>
                                                                        <span class="cropper-line line-n"
                                                                              data-cropper-action="n"></span>
                                                                        <span class="cropper-line line-w"
                                                                              data-cropper-action="w"></span>
                                                                        <span class="cropper-line line-s"
                                                                              data-cropper-action="s"></span>
                                                                        <span class="cropper-point point-e"
                                                                              data-cropper-action="e"></span>
                                                                        <span class="cropper-point point-n"
                                                                              data-cropper-action="n"></span>
                                                                        <span class="cropper-point point-w"
                                                                              data-cropper-action="w"></span>
                                                                        <span class="cropper-point point-s"
                                                                              data-cropper-action="s"></span>
                                                                        <span class="cropper-point point-ne"
                                                                              data-cropper-action="ne"></span>
                                                                        <span class="cropper-point point-nw"
                                                                              data-cropper-action="nw"></span>
                                                                        <span class="cropper-point point-sw"
                                                                              data-cropper-action="sw"></span>
                                                                        <span class="cropper-point point-se"
                                                                              data-cropper-action="se"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-new picture-form-right">
                                                            <div id="picture-new">
                                                                <a id="userpic-file-load"
                                                                   class="btn-fill marg-right"
                                                                   style="width: 220px;">Загрузить с компьютера</a>
                                                                <span class="picture-size">
                                                                        Формат: png, jpg.
                                                                        <br>
                                                                        Размер от 200x200 пикселей.
                                                                    </span>
                                                                <div class="marg-top picture-new">
                                                                    <input id="picture-url-new" class="marg-right"
                                                                           type="text" style="width: 220px;"
                                                                           placeholder="Ссылка на картинку">
                                                                    <a id="userpic-url-load" class="btn-fill">Загрузить</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="with-mpad block-bottom block-border-t">
                                                <a class="btn-fill-empty btn-wh userpic-popup-close"
                                                   onclick="hideImagePopup()">Отмена</a>
                                                <a id="userpic-save-btn" class="btn-fill btn-darkblue">Сохранить
                                                    изображение</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/api/controller/user/user.php';
    use TheBook\User;

    $user = new User;
    $url =  $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $url = explode('/', $url);
    $countAction = $user->getCountActionForProfile($_SESSION['user']['id_profile']);

    ?>

    <!--Нижнее меню-->
    <div class="header-context profile-context under-block">
        <div class="header-container">
            <div id="menu-inner" class="menu-group" style="overflow: hidden; height: 60px;">
                <ul id="menu-container" class="nav context">
                    <li <?php if ($url[3] == null) {
                        echo 'class="active"';
                    } ?>>
                        <a href="/views/reader/">Профиль</a>
                    </li>
                    <li <?php if ($url[3] == 'mybook') {
                        echo 'class="active"';
                    } ?>>
                        <a href="/views/reader/mybook/">Мои книги</a>
                    </li>
                    <li <?php if ($url[3] == 'read') {
                        echo 'class="active"';
                    }  ?>>
                        <a href="/views/reader/read/">Прочитала <b><?php echo $countAction['read']; ?></b></a>
                    </li>
                    <li <?php if ($url[3] == 'wish') {
                        echo 'class="active"';
                    } ?>>
                        <a href="/views/reader/wish/">Хочу прочитать <b><?php echo $countAction['reading']; ?></b></a>
                    </li>
                    <li <?php if ($url[3] == 'reading') {
                        echo 'class="active"';
                    } ?>>
                        <a href="/views/reader/reading/">Читаю сейчас <b><?php echo $countAction['wish']; ?></b></a>
                    </li>

                    <li>
                        <a href="/views/reader/reading/">Мои рецензии <b>0</b></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
