<div id="modalAddMeal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span onclick="closeModal('modalAddMeal')" class="close">&times;</span>
        <div class="form">
            <h3>Додавання страви</h3>
            <div class="row">
                <div class="row w-half">
                    <?php
                    use App\Build;
                    echo Build::FormControlSelectSearch('select_search', 'Страва / продукт', '/api/meal/search', 'required placeholder="Введіть назву..."');
                    echo Build::FormControlInput('weight', 'Вага', 'number', 'min="0" onchange="ChooseWeigth(this)" id="modal_add_meal_weight"');
                    ?>
                </div>
                <div class="form-control w-half">
                    <?php
                    echo Build::FormControlSelect('mealtime', 'Час', 'required onchange="ChooseTime(this)" id="meal_time"', $mealtimes)

                        ?>
                </div>
            </div>
            <div class="row">
                <div class="w-half charts-grid ">
                    <div id="modal_add_meal_chart1"></div>
                    <div id="modal_add_meal_chart2"></div>
                    <div id="modal_add_meal_chart3"></div>
                    <div id="modal_add_meal_chart4"></div>
                    <div id="modal_add_meal_chart5"></div>
                    <div id="modal_add_meal_chart6"></div>
                </div>
                <div id="" class="w-half column" style="margin:10px;">
                    <p id="info_about_time"></p>
                    <!-- <p id="info_about_diets"></p>
                    <p id="info_about_allergies"></p> -->
                    <ul id="ingredient_list"></ul>
                </div>
            </div>
            <div class="row j-c-end w-full"><button class="button button-save" type="button"
                    onclick="SaveMeal()">Зберегти</button></div>
        </div>
    </div>
</div>