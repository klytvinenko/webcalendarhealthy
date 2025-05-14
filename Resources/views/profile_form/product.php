
<h2 style="margin: 10px 0;">Додавання продукту</h2>
<form id="form_add_product" action="" method="post">
    <?php 
    use App\Build;
    ?>
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