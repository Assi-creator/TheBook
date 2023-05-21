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
                                    <a class="userpic-edit-a" href="/views/account/editprofile#image">
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
                                            <a class="ll-select-row" onclick="showImagePopup()">Добавить обложку</a>
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
            </div>
        </div>
    </div>

    <?php
    $user = new \TheBook\controller\user();
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
                        <a href="/views/reader/read/"><?php if ($_SESSION['user']['gender'] == 'ж') {echo 'Прочитала';} else {echo 'Прочитал';} ?> <b><?php echo $countAction['read']; ?></b></a>
                    </li>
                    <li <?php if ($url[3] == 'wish') {
                        echo 'class="active"';
                    } ?>>
                        <a href="/views/reader/wish/">Хочу прочитать <b><?php echo $countAction['wish']; ?></b></a>
                    </li>
                    <li <?php if ($url[3] == 'reading') {
                        echo 'class="active"';
                    } ?>>
                        <a href="/views/reader/reading/">Читаю сейчас <b><?php echo $countAction['reading']; ?></b></a>
                    </li>

                    <li <?php if ($url[3] == 'reviews') {
                        echo 'class="active"';
                    } ?>>
                        <a href="/views/reader/reviews/">Мои рецензии <b><?php echo $countAction['review']; ?></b></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
