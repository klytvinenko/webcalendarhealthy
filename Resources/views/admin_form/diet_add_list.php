
<h1><?= $title ?></h1>
<form id="form_add_list_to_diet" action="/admin/diet/allergies/addlist" method="post">
    <div class="row">
        <?php
        use App\Build;
        echo Build::FormControlSelectSearch('select_search', 'Продукт', '/api/products/search');
            ?>
        <div class="column j-c-end">
            <button class="button-icon button-icon-add" type="button" onclick="AddIngredient()"><ion-icon
                    name="add-outline"></ion-icon></button>
        </div>
    </div>
    <div id="products_list">

    </div>
    <div class="row">
        <?php
        echo Build::FormControlSelectSearch('select_search', 'Рецепт', '/api/products/search');
            ?>
        <div class="column j-c-end">
            <button class="button-icon button-icon-add" type="button" onclick="AddIngredient()"><ion-icon
                    name="add-outline"></ion-icon></button>
        </div>
    </div>
    <div id="recipes_list">

    </div>
    <div class="row j-c-end w-full">
        <button class="button button-save" type="submit">Зберегти</button>
    </div>
</form>
<script>

</script>