<div class="center">
    <h2>
    <?= $product->type == 'product' ? '<ion-icon title="Може використовуватись як самостійний продукт" class="classic" name="fast-food-outline"></ion-icon>' : 
    '<ion-icon title="Не може використовуватись як самостійний продукт" class="classic" name="nutrition-outline"></ion-icon>' ?><?= $product->title ?></h2>
    <p><b>Ккалорії: </b><?= $product->kcal ?> ккал</p>
    <p><b>Жири: </b><?= $product->fat ?> г</p>
    <p><b>Білки: </b><?= $product->protein ?> г</p>
    <p><b>Вуглеводи: </b><?= $product->carbonation ?> г</p>
    <p><b>Натрій: </b><?= $product->na ?> мг</p>
    <p><b>Клітковина: </b><?= $product->cellulose ?> г</p>
    <div class="line"></div>
                <p><b>Дієти: </b> <?= !empty($product->diets)?implode(', ',$product->diets):' - ' ?></p>
                <p><b>Алергени: </b> <?= !empty($product->allergies)?implode(', ',$product->allergies):' - ' ?> </p>
</div>