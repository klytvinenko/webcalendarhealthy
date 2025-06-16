<?php
use App\Build;
?>


<form id="form_add_meal" action="" method="post">
    <legend>Додавання страви</legend>

    <div class="row">
        <button type="button" class="btn-secondary"
            onclick="switchBlocks('form_add_meal_product','form_add_meal_recipe','2')">Рецепт</button>
        <button type="button" class="btn-secondary"
            onclick="switchBlocks('form_add_meal_product','form_add_meal_recipe','1')">Продукт</button>

    </div>
    <div class="row">
        <div id="form_add_meal_recipe" class="row" style="display: none;">
            <?php
            echo Build::FormControlSelectSearch('product', 'Прийом їжі', 'required', 'form_add_meal_product_search');
            echo Build::FormControlInput('precent', 'Відсоток', 'number', 'min="0" max="100" required');
            ?>
        </div>
        <div id="form_add_meal_product" class="row" style="display: block;">
            <?php
            echo Build::FormControlSelectSearch('recipe', 'Прийом їжі', 'required', 'form_add_meal_recipe_search');
            echo Build::FormControlInput('weight', 'Вага', 'number', 'min="0" required ');
            ?>
        </div>
        <?php
        echo Build::FormControlSelect('mealtime', 'Прийом їжі', 'required', [
            ['id' => 1, 'name' => 'Сніданок'],
            ['id' => 2, 'name' => 'Перекус 1'],
            ['id' => 3, 'name' => 'Обід'],
            ['id' => 4, 'name' => 'Перекус 2'],
            ['id' => 4, 'name' => 'Вечеря'],
        ]);
        ?>
    </div>
    <div class="row">
        <div id="form_add_meal_charts"></div>
        <div id="form_add_meal_info"></div>
    </div>

    <button type="submit" class="btn-primary">Зберегти</button>
</form>

<form id="form_add_product" action="" method="post">

    <legend>Додавання продукту</legend>
    <div class="row">

        <?= Build::FormControlInput('name', 'Імя', 'text', 'required'); ?>
        <?= Build::FormControlInput('type', 'Може бути самостійною стравою', 'checkbox', 'required'); ?>
    </div>
    <div class="row">
        <?php
        use App\Models\Diet;
        use App\Models\Allergy;
        echo Build::FormControlSelect('diets[]', 'Дієти', 'multiple required', Diet::titles_and_ids());
        echo Build::FormControlSelect('allergies[]', 'Алергени', 'multiple required', Allergy::titles_and_ids());
        ?>
    </div>
    <div class="row">
        <?php
        echo Build::FormControlInput('kcal', 'Каллорії', 'number', 'required');
        echo Build::FormControlInput('protein', 'Білки', 'number', 'required');
        echo Build::FormControlInput('fat', 'Жири', 'number', 'required');
        echo Build::FormControlInput('carbonation', 'Вуглеводи', 'number', 'required');
        echo Build::FormControlInput('na', 'Натрій', 'number', 'required');
        echo Build::FormControlInput('cellulose', 'Клітковина', 'number', 'required');
        ?>
    </div>
    <button type="submit" class="btn-primary">Зберегти</button>
</form>

<form id="form_add_recipe" action="" method="post">

    <legend>Додавання рецепту</legend>
</form>

<form id="form_add_diet" action="" method="post">

    <legend>Додавання дієти</legend>
    <?= Build::FormControlInput('name', 'Імя', 'text', 'required'); ?>
    <?= Build::FormControlTextarea('description', 'Опис', 'required'); ?>
    <button type="submit" class="btn-primary">Зберегти</button>

</form>


<form id="form_add_allergy" action="" method="post">

    <legend>Додавання алергени</legend>
    <?= Build::FormControlInput('name', 'Імя', 'text', 'required'); ?>
    <?= Build::FormControlTextarea('description', 'Опис', 'required'); ?>
    <button type="submit" class="btn-primary">Зберегти</button>
</form>

<!-- AJAX -->
<form id="form_add_weight" action="" method="post">

    <legend>Додавання ваги</legend>
    <?= Build::FormControlInput('name', 'Імя', 'text', 'required'); ?>
    <button type="button" class="btn-primary" onclick="Ajax.Post(this)">Зберегти</button>
</form>


<form id="form_add_training" action="" method="post">
    <legend>Додавання тренування</legend>
    <div class="row">
        <button type="button" class="btn-secondary"
            onclick="switchBlocks('form_add_training_new','form_add_training_choose','1')">Створити нове</button>
        <button type="button" class="btn-secondary"
            onclick="switchBlocks('form_add_training_new','form_add_training_choose','2')">Із списку</button>

    </div>
    <div id="form_add_training_new" class="row" style="display:none;">
        <?php
        echo Build::FormControlInput('name', 'Назва', 'text', 'required');
        echo Build::FormControlInput('description', 'Опис', 'text', 'required');
        ?>
    </div>
    <div id="form_add_training_choose" class="row" style="display:block;">
        <?php
        echo Build::FormControlSelect('training_id', 'Тренування', 'required', [
            ['id' => 1, 'name' => 'Тренування 1'],
            ['id' => 2, 'name' => 'Тренування 2'],
            ['id' => 3, 'name' => 'Тренування 3'],
            ['id' => 4, 'name' => 'Тренування 4'],
        ]);
        ?>
    </div>
    <div class="row">
        <?php
        echo Build::FormControlInput('date', 'Дата', 'date', 'required');
        echo Build::FormControlInput('start_time', 'Час поч.', 'time', 'required');
        echo Build::FormControlInput('end_time', 'Час кін.', 'time', 'required');
        ?>
    </div>
    <button type="button" class="btn-primary" onclick="Ajax.Post(this)">Зберегти</button>
</form>


<script>
    // for form_add_training







</script>