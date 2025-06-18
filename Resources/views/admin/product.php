<div class="center">
    <h1><?= $product->title ?>
    <?= $product->type == 'product' ? '<ion-icon title="Може використовуватись як самостійний продукт" class="black-icon" name="fast-food-outline"></ion-icon>' : 
    '<ion-icon title="Не може використовуватись як самостійний продукт" class="black-icon" name="nutrition-outline"></ion-icon>' ?></h1>
    <p><b>Ккалорії: </b><?= $product->kcal ?> ккал</p>
    <p><b>Жири: </b><?= $product->fat ?> г</p>
    <p><b>Білки: </b><?= $product->protein ?> г</p>
    <p><b>Вуглеводи: </b><?= $product->carbonation ?> г</p>
    <p><b>Натрій: </b><?= $product->na ?> мг</p>
    <p><b>Клітковина: </b><?= $product->cellulose ?> г</p>
    <div class="line"></div>
                <p><b>Дієти: </b> <?= !empty($product->diets)?implode(', ',$product->diets):' - ' ?></p>
                <p><b>Алергени: </b> <?= !empty($product->allergies)?implode(', ',$product->allergies):' - ' ?> </p>
        <?php 
        if($product->has_copies){
        ?>
        <div class="line"></div>
    <table id="products">
        <thead>
            <tr>
                <th>Назва</th>
                <th>Користувач</th>
                <th>Тип</th>
                <th>Ккал</th>
                <th>Білки</th>
                <th>Жири</th>
                <th>Вуглеводи</th>
                <th>Натрій</th>
                <th>Клітковина</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($product->copies as $copy) {
            
                ?>
                <tr id="product_<?= $copy['id'] ?>">
                    <td><?= $copy['title'] ?></td>
                    <td><?= $copy['user_login'] ?></td>
                    <td><?= $copy['type'] == 'product' ? '<ion-icon title="Може використовуватись як самостійний продукт" class="black-icon" name="fast-food-outline"></ion-icon>' : ' - ' ?></td>
                    <td><?= $copy['kcal'] ?></td>
                    <td><?= $copy['fat'] ?></td>
                    <td><?= $copy['protein'] ?></td>
                    <td><?= $copy['carbonation'] ?></td>
                    <td><?= $copy['na'] ?></td>
                    <td><?= $copy['cellulose'] ?></td>
                    <td class="icons"> <button class="button-icon button-icon-primary" onclick="href('/admin/products/replace?original_id=<?=$product->id?>&new_id=<?= $copy['id'] ?>')" title="Замінити"><ion-icon name="sync-outline"></ion-icon></button></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
<?php 
}
?>


            </div>