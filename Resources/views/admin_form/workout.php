<h1><?= $title ?></h1>
<form id="form_add_training" action="/admin/workouts/store" method="post">
    <div class="row">

        <?php
        use App\Build;
        echo Build::FormControlInput('title', 'Назва', 'text', 'required');
        echo Build::FormControlInput('kcal', 'Спалювані ккалорії (за 1 год.)', 'number', 'required min="0"');
        ?>
    </div>
    <div class="row">

        <?php

        echo Build::FormControlеTextarea('description', 'Опис / Інструкція', '');
        ?>
    </div>

    <div class="row j-c-end w-full">
        <button class="button button-save" type="submit">Зберегти</button>
    </div>
</form>