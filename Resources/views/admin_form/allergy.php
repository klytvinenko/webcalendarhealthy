<h1><?= $title ?></h1>
<form id="form_add_allergy" action="/admin/diet/allergies/store" method="post">
    <?php
    use App\Build;
    echo Build::FormControlInput('title', 'Назва', 'text', 'required');
    ?>
    <div class="row j-c-end w-full">
        <button class="button button-save" type="submit">Зберегти</button>
    </div>
</form>