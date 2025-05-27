<h1><?= $title ?></h1>
<form id="form_add_recipe" action="/admin/recipes/update?id=<?= $recipe->id ?>" method="post">
    <!-- основне -->
    <div class="row">
        <?php
        use App\Data;
        use App\Build;
        use App\Models\Recipe;
        echo Build::FormControlInput('title', 'Назва', 'text', 'required value="' . $recipe->title . '"');
        echo Build::FormControlSelect('type', 'Тип', 'required', $recipe_types);
        ?>
    </div>
    <div class="row">
        <?php
        use App\Models\Diet;
        echo Build::FormControlSelect('diets[]', 'Дієти', 'multiple', $diets);
        echo Build::FormControlеTextarea('description', 'Опис', ' cols="30" rows="4"', $recipe->description);
        ?>
    </div>
    <!-- Інгрідієнти -->
    <div class="row">
        <?php
        echo Build::FormControlSelectSearch('select_search', 'Продукт', '/api/products/search');
        echo Build::FormControlInput("product_weight", 'Вага', 'number', ' min="0" id="product_weight""')
            ?>
        <div class="column j-c-end">
            <button class="button-icon button-icon-add" type="button" onclick="AddIngredient()"><ion-icon
                    name="add-outline"></ion-icon></button>
        </div>
    </div>
    <?php
    echo Build::FormMessageNotValid('ingredients');
    ?>
    <div id="ingredients_list">
        <?php
        foreach ($recipe->ingredients() as $ingredient) {
            echo '<div class="row mt-10">
                <div class="hidden"><input type = "number" name = "ingredients[]" value = "' . $ingredient['product_id'] .  '"></div>
                <div class="form-control"><input type="text" value="' . $ingredient['title'] . '"></div> 
                <div class="form-control"><input type="number" min="0" step="1" name="ingredients_weigths[]" value="' . $ingredient['weight'] . '"></div>
                <button type="button" class="button-icon button-icon-remove" onclick="DeleteIngredient(this)"><ion-icon name="close-outline"></ion-icon></button>
                </div>';
        }
        ?>
    </div>
    <!-- кнопка -->
    <div class="row j-c-end w-full">
        <button class="button button-save" type="submit">Додати</button>

    </div>
    <?php
    Build::FormClearMessages();
    ?>
</form>

<script>
    let choosed_product = { id: null, text: '', weight: 0 };
    let product_weight = document.getElementById('product_weight');
    let dropdown = document.getElementById('select_search_dropdown');
    let select_search = document.getElementById('select_search');
    let ingredients_list = document.getElementById('ingredients_list');
    let valid_message = document.getElementById('select_search_valid_message');

    function check(old_value) {
        let new_value = document.getElementById('select_search').value;
        if (new_value == old_value) {

        }
        else {
            setTimeout(check(new_value), 500); // check again in a second
        }
    }

    async function SearchSelect(url, e) {
        if (e.value == "") HideDropdown();
        else {
            check(e.value);

            select_search.classList.remove('not-valid');
            valid_message.classList.add('hidden');

            select_search.classList.add('select-search-active');
            let items = await Product.Search(e.value);
            if (items.length == 0) {
                items.push({
                    id: null, title: "Не було знайдено продуктів"
                });
            }
            dropdown.innerHTML = '';
            dropdown.classList.remove('hidden');
            items.forEach(item => {
                const newOption = document.createElement("li");
                newOption.textContent = item.title;
                if (item.id == null) newOption.classList.add('unchoosed')
                else {
                    newOption.id = item.id;
                    newOption.addEventListener('click', function (e) {
                        choosed_product.id = e.target.id;
                        choosed_product.text = e.target.innerHTML;

                        select_search.value = e.target.innerHTML;
                        HideDropdown();
                    })
                }
                dropdown.appendChild(newOption);
            });
        }
    }
    // 3. Закриття по кліку на екрані 

    document.addEventListener("click", (event) => {
        log(event.target, 'item')
        if (!event.target.contains(dropdown)) {
            HideDropdown()
        }
    });
    function HideDropdown() {
        dropdown.innerHTML = '';
        dropdown.classList.add('hidden');
        select_search.classList.remove('select-search-active');
    }
    function AddIngredient() {
        if (choosed_product.id == null) {
            select_search.classList.add('not-valid');
            valid_message.classList.remove('hidden');
        } else {
            choosed_product.weight = product_weight.value;

            //add to class
            ingredients_list.innerHTML += '<div class="row mt-10">' +
                '<div class="hidden"><input type = "number" name = "ingredients[]" value = "' + choosed_product.id + '"></div>' +
                '<div class="form-control"><input type="text" value="' + choosed_product.text + '"></div>' +
                '<div class="form-control"><input type="number" min="0" step="1" name="ingredients_weigths[]" value="' + choosed_product.weight + '"></div>' +
                '<button type="button" class="button-icon button-icon-remove" onclick="DeleteIngredient(this)"><ion-icon name="close-outline"></ion-icon></button>' +
                '</div>';

            //clear form 
            select_search.value = '';
            product_weight.value = '';
            choosed_product = { id: null, text: '', weight: 0 };
        }


    }
    function DeleteIngredient(e) {
        e.parentElement().parentElement().remove();
    }
</script>