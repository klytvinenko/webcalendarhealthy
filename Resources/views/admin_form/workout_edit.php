<h1><?= $title ?></h1>
<form id="form_add_training" action="/admin/workouts/update?id=<?= $workout->id ?>" method="POST">
    <div class="row">

        <?php
        use App\Build;
        echo Build::FormControlInput('title', 'Назва', 'text', 'required value="' . $workout->title . '"');
        echo Build::FormControlInput('kcal', 'Спалювані ккалорії (за 1 год.)', 'number', 'required min="0" value="' . $workout->kcal . '"');
        ?>
    </div>
    <div class="row">

        <?php
        echo Build::FormControlеTextarea('description', 'Опис / Інструкція', "", $workout->description);
        ?>
    </div>

    <div class="row j-c-end w-full">
        <button class="button button-save" type="submit">Зберегти</button>
    </div>
</form>