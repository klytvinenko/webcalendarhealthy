<form id="form_add_product" action="/admin/products/store" method="post">
    <div class="row">
        <?php
        use App\Build;
        use App\Data;
        use App\Models\Diet;
        use App\Models\Allergy;
        echo Build::FormControlInput('title', 'Назва', 'text', 'required');
        ?>
        <div class="form-control" style="align-self:center;">
            <br />
            <label for="is_can_be_meal" class="row j-c-start text-light">
                <input type="checkbox" name="is_can_be_meal" id="is_can_be_meal" style="margin-right:10px;">Продукт
                можна викорисувати як прийом їжі
            </label>
        </div>
    </div>
    <div class="row">

        <?php
        $diets = Diet::all();
        $allergies = Allergy::all();

        echo Build::FormControlSelect('diets[]', 'Дієти', 'multiple', $diets);
        echo Build::FormControlSelect('allergies[]', 'Алергії', 'multiple', $allergies);
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
    <div div class="row j-c-end w-full">
        <button class="button button-save">Зберегти</button>
    </div>

</form>