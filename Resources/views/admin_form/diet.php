<h1><?= $title ?></h1>
<form id="form_add_diet" action="/admin/diet/diets/store" method="post">

    <?php
    use App\Build;
    echo Build::FormControlInput('title', 'Назва', 'text', 'required');
    echo Build::FormControlеTextarea('description', 'Опис', '');
    ?>

    <div class="row j-c-end w-full">
        <button class="button button-save" type="submit">Зберегти</button>
    </div>
</form>