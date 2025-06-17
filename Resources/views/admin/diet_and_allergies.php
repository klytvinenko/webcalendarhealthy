<div class="row">
    <div class="column w-50">
        <h2>Дієти</h2>
        <div class="row j-c-end w-full">
            <button class="button" onclick="href('/admin/diet/diets/add')">Додати</button>
        </div>
        <?php
        if (empty($diets)) {
            echo '<div class="empty-data"><p>Дієт не додано</div></div>';
        } else {
            ?>
            <ul id="diets_list">
                <?php
                foreach ($diets as $diet) {
                    ?>
                    <li id="diet_<?=$diet['id']?>">
                        <div class="row w-50">
                            <p><?= $diet['name'] ?></p>
                            <i class="text-light overflow-hide"><?= $diet['description'] ?></i>
                        </div>
                        <div class="icons">
                            <!-- <button class="button-icon button-icon-add" onclick="href('/admin/diet/diets/add_list?id=')">
                                <ion-icon name="list-outline" title="Додати список продукти/рецепти"></ion-icon> -->
                            </button>
                            <button class="button-icon button-icon-edit" onclick="href('/admin/diet/diets/edit?id=<?=$diet['id']?>')" title="Редагувати"><ion-icon
                                    name="create-outline"></ion-icon></button>
                           
                        </div>
                    </li>
                    <?php
                }
                ?>
            </ul>
        <?php
        }
        ?>
    </div>
    <div class="column w-50">
        <h2>Алергени</h2>
        <div class="row j-c-end w-full">
            <button class="button" onclick="href('/admin/diet/allergies/add')">Додати</button>
        </div>
        <?php
        if (empty($allergies)) {
            echo '<div class="empty-data"><p>Алергенів не додано</div></div>';
        } else {
            ?>
            <ul id="allergies_list">
                <?php
                foreach ($allergies as $allergy) {
                    ?>
                    <li id="allergy_<?=$allergy['id']?>">
                        <div class="row">
                            <p><?= $allergy['name'] ?></p>
                        </div>
                        <div class="icons">
                        <!-- <button class="button-icon button-icon-add" onclick="href('/admin/diet/allergies/add_list?id=')">
                                <ion-icon name="list-outline" title="Додати список продукти/рецепти"></ion-icon> -->
                            </button>
                            <button class="button-icon button-icon-edit" onclick="href('/admin/diet/allergies/edit?id=<?=$allergy['id']?>')" title="Редагувати"><ion-icon
                                    name="create-outline"></ion-icon></button>
                        </div>
                    </li>
                    <?php
                }
                ?>
            </ul>
        <?php
        }
        ?>
    </div>
</div>