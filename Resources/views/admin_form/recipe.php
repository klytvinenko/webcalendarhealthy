<h1><?= $title ?></h1>
<form id="form_add_recipe" action="/admin/recipes/store" method="post">
    <!-- основне -->
    <div class="row">
        <?php
        use App\Build;
        use App\Models\Recipe;
        echo Build::FormControlInput('title', 'Назва', 'text', 'required');
        echo Build::FormControlSelect('type', 'Тип', 'required', Recipe::types());
        ?>
    </div>
    <div class="row">
        <?php
        use App\Models\Diet;
        echo Build::FormControlSelect('diets', 'Дієти', 'multiple', Diet::all());
        echo Build::FormControlеTextarea('description', 'Опис', ' cols="30" rows="4"');
        ?>
    </div>
    <!-- Інгрідієнти -->
    <div class="row">
        <div class="form-control">
            <label for="select_search">Продукт</label>
            <input type="text" id="select_search" oninput="SearchSelect('api/products/search',this)">
            <ul class="dropdown hidden" id="select_search_dropdown"></ul>
        </div>
        <div class="form-control">
            <label for="product_weight">Вага</label>
            <input type="number" min="0" id="product_weight">
        </div>
        <div class="form-contrl">
            </br>
            <button class="button button-add" type="button" onclick="AddIngredient()">Add</button>
        </div>
    </div>
    <div id="ingredients_list"></div>
    <!-- кнопка -->
    <div class="row j-c-end w-full">
        <button class="button button-save" type="submit">Додати</button>

    </div>
</form>

<script>
    let choosed_product = { id: null, text: '', weight: 0 };
    let product_weight = document.getElementById('product_weight');
    let dropdown = document.getElementById('select_search_dropdown');
    let select_search = document.getElementById('select_search');
    let ingredients_list = document.getElementById('ingredients_list');
    async function SearchSelect(url, e) {
        if (e.value == "") HideDropdown();
        else {
            select_search.classList.remove('not-valid');
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
        log(event.target,'item')
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
        } else {
            choosed_product.weight = product_weight.value;

            //add to class
            ingredients_list.innerHTML += '<div class="row mt-10">' +
                '<div class="hidden"><input type = "number" name = "ingredients[]" value = "' + choosed_product.id + '"></div>' +
                '<div class="form-control"><input type="text" value="' + choosed_product.text + '"></div>' +
                '<div class="form-control"><input type="number" min="0" step="1" name="ingredients_weigths[]" value="' + choosed_product.weight + '"></div>' +
                '<button type="button" style="height:fit-content" class="button-icon button-icon-remove" onclick="DeleteIngredient(this)"><ion-icon name="close-outline"></ion-icon></button>' +
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
    document.addEventListener('mouseup', function (e) {
        var container = document.getElementById('container');
        if (!container.contains(e.target)) {
            container.style.display = 'none';
        }
    });
</script>