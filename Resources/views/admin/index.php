<section>
    <h1><?php echo $title; ?></h1>
    <div id="admin_buttons">
        <button onclick="href('/admin/recipes/add')" id="add_recipe">+ Рецепт</button>
        <button onclick="href('/admin/products/add')" id="add_product">+ Продукт</button>
        <button onclick="href('/admin/workouts/add')" id="add_training">+ Тренування</button>
        <button onclick="href('/admin/diet/diets/add')" id="add_allergy">+ Алерген</button>
        <button onclick="href('/admin/diet/allergies/add')" id="add_diet">+ Дієта</button>
    </div>
</section>