<h1><?= $recipe->title ?> (<i><?= $recipe->type->getName() ?></i>)</h1>
<div class="center">
    <p><b>Ккалорії: </b><?= $recipe->kcal ?> ккал</p>
    <p><b>Жири: </b><?= $recipe->fat ?> г</p>
    <p><b>Білки: </b><?= $recipe->protein ?> г</p>
    <p><b>Вуглеводи: </b><?= $recipe->carbonation ?> г</p>
    <p><b>Натрій: </b><?= $recipe->na ?> мг</p>
    <p><b>Клітковина: </b><?= $recipe->cellulose ?> г</p>
    <div class="line"></div>
    <p><b>Інгредієнти:</b>
    <ul><?php
    if (isset($recipe->ingredients)) {
        foreach ($recipe->ingredients as $ingredient) {
            ?>

                <li><a class="not-link"
                        onclick="href('/admin/products/show?id=<?= $ingredient['id'] ?>')"><?= $ingredient['title'] ?></a>
                    - <?= $ingredient['weight'] ?> г </li>
                <?php
        }

    } else
        echo ' - ';

    ?>
    </ul></p>
    <div class="line"></div>
    <p><b>Дієти:</b> <?= !empty($recipe->diets) ? implode(', ', $recipe->diets) : ' - ' ?></p>
    <p><b>Алергени:</b><?= !empty($recipe->allergies) ? implode(', ', $recipe->allergies) : ' - ' ?> </p>
    <div class="line"></div>
    <p><i><?= $recipe->description ?></i></p>

</div>