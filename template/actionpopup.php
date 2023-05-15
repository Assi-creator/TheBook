<div class="add-book hidden">
    <div id="ub-form-main" class="add-book__wrapper">
        <div class="add-book__header">
            <button class="add-book__close-button" type="button" onclick="Close()">Х</button>
            <p class="add-book__modal-title">Выбор действия</p>
            <p class="add-book__book-title"></p>
        </div>

        <div class="add-book__body">
            <div class="add-book__action-list">
                <div class="add-book__action-item">
                    <input id="want-to-read" type="radio" name="ub-status" value="1" checked="checked">
                    <label class="add-book__action-title" for="want-to-read">Читаю сейчас</label>
                </div>

                <div class="add-book__action-item">
                    <input id="already-read" type="radio" name="ub-status" value="2">
                    <label class="add-book__action-title" for="already-read"><?php if ($_SESSION['user']['gender'] == 'ж') {echo 'Прочитала';} else {echo 'Прочитал';} ?></label>
                </div>

                <div class="add-book__action-item">
                    <input id="read-now" type="radio" name="ub-status" value="3">
                    <label class="add-book__action-title" for="read-now">Хочу прочитать</label>
                </div>

                <div id="add-book__rating-inline" class="add-book__action-item not-selectable rating-in-popup hidden" style="top: 88px;">
                    <input id="ub-rating" type="hidden" name="new-book-rating" value="0">
                    <p class="add-book__action-title add-book__action-title_thin">
                        Моя оценка
                        <span id="ub-form-rating-popup-rating-value" class="add-book__my-rating"></span>
                    </p>
                    <div class="add-book__rating  five-point">
                        <input class="ub-from-set-rating-radio" type="radio" id="ub-radio-rating-10" value="10" name="add-book-rating" checked="checked">
                        <label for="ub-radio-rating-10"></label>
                        <input class="ub-from-set-rating-radio" type="radio" id="ub-radio-rating-9" value="10" name="add-book-rating">
                        <label for="ub-radio-rating-9"></label>
                        <input class="ub-from-set-rating-radio" type="radio" id="ub-radio-rating-8" value="8" name="add-book-rating">
                        <label for="ub-radio-rating-8"></label>
                        <input class="ub-from-set-rating-radio" type="radio" id="ub-radio-rating-7" value="8" name="add-book-rating">
                        <label for="ub-radio-rating-7"></label>
                        <input class="ub-from-set-rating-radio" type="radio" id="ub-radio-rating-6" value="6" name="add-book-rating">
                        <label for="ub-radio-rating-6"></label>
                        <input class="ub-from-set-rating-radio" type="radio" id="ub-radio-rating-5" value="6" name="add-book-rating">
                        <label for="ub-radio-rating-5"></label>
                        <input class="ub-from-set-rating-radio" type="radio" id="ub-radio-rating-4" value="4" name="add-book-rating">
                        <label for="ub-radio-rating-4"></label>
                        <input class="ub-from-set-rating-radio" type="radio" id="ub-radio-rating-3" value="4" name="add-book-rating">
                        <label for="ub-radio-rating-3"></label>
                        <input class="ub-from-set-rating-radio" type="radio" id="ub-radio-rating-2" value="2" name="add-book-rating">
                        <label for="ub-radio-rating-2"></label>
                        <input class="ub-from-set-rating-radio" type="radio" id="ub-radio-rating-1" value="2" name="add-book-rating">
                        <label for="ub-radio-rating-1"></label>
                    </div>
                </div>
            </div>
            <input id="ub-rating" type="hidden" name="new_book_rating" value="0">
            <div class="add-book__modal-remove center centered hidden" id="ub-from-confirm-modal-remove-ub-from-collection">
                <p>Вы уверены, что хотите удалить книгу из коллекции?</p>
                <div>
                    <button id="ub-from-confirm-modal-btn-confirm-remove-ub-from-collection" class="ub-form-remove" type="button">Да, удалить</button>
                    <button id="ub-from-confirm-modal-btn-cancel-remove-ub-from-collection" class="ub-form-cansel" type="button">Отмена</button>
                </div>
            </div>
        </div>

        <div class="add-book__footer add-book__footer-buttons">
            <button class="add-book__save-button add-book__save-button_outline">Написать рецензию</button>
            <button class="add-book__save-button" type="button">Сохранить</button>
        </div>
    </div>
    <input type="hidden" name="data-profile-popup">
    <input type="hidden" name="data-book-id-popup">
    <input type="hidden" name="data-action-popup">
</div>
