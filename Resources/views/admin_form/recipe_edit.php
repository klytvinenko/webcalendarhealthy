<h1><?= $title ?></h1>
<form id="form_add_recipe" action="/admin/recipes/store" method="post">

    <!-- основне -->
    <div class="row">
        <div class="form-control" style="width: 50%;">
            <label for="title">Назва</label>
            <input type="text" name="title" id="title">
        </div>
        <div class="form-control" style="width: 50%;">
            <label for="type">Тип</label>
            <select name="type" id="type">
                <option value="">Оберіть...</option>
                <?php
                use App\Models\Recipe;
                $types = Recipe::types();
                foreach ($types as $key => $value) {
                    ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-control">
            <label for="diets">Дієти</label>
            <select name="diets[]" id="diets" multiple>
                <option value="" disabled selected>Оберіть дієту, якій підходить ця страва</option>
                <?php
                use App\Models\Diet;
                $diets = Diet::titles_and_ids();
                foreach ($diets as $diet) {
                    ?>
                    <option value="<?= $diet['id'] ?>"><?= $diet['name'] ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="form-control">
            <label for="description">Опис</label>
            <textarea name="description" id="description" cols="30" rows="6"></textarea>
        </div>
    </div>
    <!-- Інгрідієнти -->
    <div class="row">
        <div class="form-control" style="width: 40%;">
            <div class="autocomplete-wrapper">
                <label for="ingredient_new">Інгрідієнт</label>
                <input type="text" id="ingredient_new" name="ingredient_new" placeholder="Введіть назву...">
                <input type="number" id="selected-id" name="selected-id" class="hidden">
                <div class="suggestions" id="suggestions-box" hidden></div>
            </div>
        </div>
        <div class="form-control" style="width: 40%;">
            <label for="ingredient_weigth_new">Вага</label>
            <input type="number" min="0" step="1" id="ingredient_weigth_new" name="ingredient_weigth_new" value="0">
        </div>
        <div style="width: 20%;">
            <p></p><br>
            <button type="button" class="button button-add h-30px" style="margin:4px; width: 100%;"
                onclick="AddIngredient()">Додати інгрідієнт</button>
        </div>
    </div>
    <div id="ingredients_list">
        <div class="row">
            <input type="number" name="ingredients[]" class="hidden" value="">
            <input type="text" value="">
            <input type="number" min="0" step="1" name="ingredients_weigths[]" value="">
            <button type="button" class="button-icon button-icon-remove" onclick="DeleteIngredient(this)"><ion-icon
                    name="close-circle-outline"></ion-icon></button>
        </div>
        <div class="row">
            <input type="number" name="ingredients[]" class="hidden" value="">
            <input type="text" value="">
            <input type="number" min="0" step="1" name="ingredients_weigths[]" value="">
            <button type="button" class="button-icon button-icon-remove" onclick="DeleteIngredient(this)"><ion-icon
                    name="close-circle-outline"></ion-icon></button>
        </div>
        <div class="row">
            <input type="number" name="ingredients[]" class="hidden" value="">
            <input type="text" value="">
            <input type="number" min="0" step="1" name="ingredients_weigths[]" value="">
            <button type="button" class="button-icon button-icon-remove" onclick="DeleteIngredient(this)"><ion-icon
                    name="close-circle-outline"></ion-icon></button>
        </div>
    </div>
    <!-- кнопка -->
    <div class="row j-c-end w-full">
        <button class="button button-save" type="submit">Додати</button>

    </div>
</form>