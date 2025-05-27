
<form id="form_add_product" action="/profile/products/store" method="post">
    <?php 
    use App\Build;
    ?>
    <div class="row">

        <?= Build::FormControlInput('title', 'Назва', 'text', 'required'); ?>
        <?= Build::FormControlInput('type', 'Може бути самостійною стравою', 'checkbox', ''); ?>
    </div>
    <div class="row">
        <?php
        use App\Models\Diet;
        use App\Models\Allergy;
        echo Build::FormControlSelect('diets[]', 'Дієти', 'multiple ', $diets);
        echo Build::FormControlSelect('allergies[]', 'Алергени', 'multiple ', $allergies);
        ?>
    </div>
    <div class="row">
        <?php
        echo Build::FormControlInput('kcal', 'Ккалорії', 'number', 'required min="0" step="0.0001"');
        echo Build::FormControlInput('fat', 'Жири', 'number', 'min="0" step="0.0001"');
        echo Build::FormControlInput('protein', 'Білок', 'number', 'min="0" step="0.0001"');
        echo Build::FormControlInput('carbonation', 'Вуглеводи', 'number', 'min="0" step="0.0001"');
        echo Build::FormControlInput('na', 'Натрій', 'number', 'min="0" step="0.0001"');
        echo Build::FormControlInput('cellulose', 'Клітковина', 'number', 'min="0" step="0.0001"');
        ?>
    </div>
    <?= Build::Button() ?>
</form>