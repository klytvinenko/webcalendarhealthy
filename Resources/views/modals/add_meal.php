<div id="modalAddMeal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span onclick="closeModal('modalAddMeal')" class="close">&times;</span>
            <div class="form">
                <h3>Додавання страви</h3>
                <div class="row">
                    <div class="row w-half">
                        <div class="form-control w-full" id="modal_add_meal_form_control_meal">
                            <label for="modal_add_meal_meal">Страва/продукт</label>
                            <div class="autocomplete-wrapper">
                                <input type="text" id="modal_add_meal_meal" name="modal_add_meal_meal"
                                    placeholder="Введіть назву...">
                                <!-- <input type="number" id="selected-id" name="selected-id" class="hidden"> -->
                                <div class="suggestions" id="suggestions-box" hidden></div>
                            </div>
                        </div>
                        <!-- <img id="liked_meal_or_product" src="../img/icons/like_not.png" alt="unliked" onclick="ToogleLiked()"> -->
                        <div class="form-control w-half" id="modal_add_meal_form_control_weight_input">
                            <label for='modal_add_meal_weight'>Вага:</label>
                            <input id='modal_add_meal_weight' name='modal_add_meal_weight' type='number' min='0'
                                onchange="ModalAddMealChoosedWeigth(this)" />

                        </div>

                    </div>
                    <div class="form-control w-half">
                        <label for="modal_add_meal_mealtime">Прийом їжі</label>
                        <select name="mealtime" id="modal_add_meal_mealtime"
                            onchange="ModalAddMealChoosedMealtime(this)">
                            <option value="" selected disabled>Оберіть</option>
                            <option value="Сніданок">Сніданок</option>
                            <option value="Ранковий перекус">Ранковий перекус</option>
                            <option value="Обід">Обід</option>
                            <option value="Після обідній перекус">Після обідній перекус</option>
                            <option value="Вечеря">Вечеря</option>
                        </select>
                    </div>

                </div>
                <div class="row" id="modal_add_meal_choosed_order">
                    <div id="modal_add_meal_choosed_order_charts" class="w-half">
                        <div id="modal_add_meal_chart1"></div>
                        <div id="modal_add_meal_chart2"></div>
                        <div id="modal_add_meal_chart3"></div>
                        <div id="modal_add_meal_chart4"></div>
                        <div id="modal_add_meal_chart5"></div>
                        <div id="modal_add_meal_chart6"></div>
                    </div>
                    <div id="modal_add_meal_choosed_order_description" class="w-half">

                    </div>
                </div>
                <button type="button" onclick="Ajax.AddMeal(this)">Додати</button>
            </div>
        </div>
    </div>