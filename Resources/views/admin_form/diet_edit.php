<h1><?= $title ?></h1>
<form id="form_add_diet" action="/admin/diet/diets/update?id=<?= $diet->id ?>" method="post">

    <?php
    use App\Build;
    use App\Data;
    echo Build::FormControlInput('title', 'Назва', 'text', 'required value="' . $diet->name . '"');
    echo Build::FormControlTextarea('description', 'Опис','',  $diet->description);
    ?>

    <div class="row j-c-end w-full">
        <button class="button button-save" type="submit">Зберегти</button>
    </div>
</form>