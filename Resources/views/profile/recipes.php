<section>
    <div class="row j-c-end w-full">
        <button class="button" onclick="href('/profile/recipes/add')">Додати</button>
    </div>
    <?php
    use App\Build;
    if (empty($recipes)) {
        echo '<div class="empty-data"><p class="text-center">Рецептів не додано</div></div>';
    } else {

        ?>
        <div id="recipes_grid">

            <?php
            foreach ($recipes as $recipe) {
                ?>
                <div class="recipe-card" id="recipe_<?= $recipe->id ?>">
                    <div class="row" style="margin-top: 0;">
                        <h5><?= $recipe->title ?></h5>
                        <div><button class="button-icon button-icon-like"
                                onclick="href('/profile/recipes/like?id=<?= $recipe->id ?>')"
                                title="<?= $recipe->is_liked ? 'Прибрати з улюблених' : 'Додати до улюблених' ?>">
                                <?php
                                if ( $recipe->is_liked ) {
                                    ?>
                                    <ion-icon name="heart-dislike-outline"></ion-icon>
                                    <?php
                                } else {
                                    ?>
                                    <ion-icon name="heart-outline"></ion-icon>
                                    <?php
                                }
                                ?>
                            </button>
                            <button class="button-icon button-icon-show"
                                onclick="href('/profile/recipes/show?id=<?= $recipe->id ?>')" title="Переглянути"><ion-icon
                                    name="ellipsis-horizontal-circle-outline"></ion-icon></button>
                            <button class="button-icon button-icon-edit"
                                onclick="href('/profile/recipes/edit?id=<?= $recipe->id ?>')" title="Редагувати"><ion-icon
                                    name="create-outline"></ion-icon></button>
                            <button class="button-icon button-icon-remove"
                                onclick="Delete('/profile/recipes/delete?id=<?= $recipe->id ?>','recipe_<?= $recipe->id ?>')"><ion-icon
                                    name="close-circle-outline" title="Видалити"></ion-icon></button>
                        </div>
                    </div>
                    <p><i><?= $recipe->type->getName() ?></i></p>
                    <p><?= $recipe->kcal ?> ккал (<span title="Білки"> <?= $recipe->protein ?> г</span>/<span
                            title="Жири"><?= $recipe->fat ?> г</span>/<span title="Вуглеводи"><?= $recipe->carbonation; ?>
                            г</span>)
                    </p>
                    <p><b>Дієти:</b> <?= !empty($recipe->diets) ? implode(', ', $recipe->diets) : ' - ' ?></p>
                    <p><b>Алергени:</b><?= !empty($recipe->allergies) ? implode(', ', $recipe->allergies) : ' - ' ?> </p>
                    <p><b>Інгредієнти:</b>
                    <ul><?php
                    if (isset($recipe->ingredients)) {
                        foreach ($recipe->ingredients as $ingredient) {
                            ?>
                                <li><?= $ingredient['title'] ?> - <?= $ingredient['weight'] ?> г </li>
                                <?php
                        }
                    } else
                        echo ' - ';

                    ?></p>

                    </ul>
                </div>
                <?php
            }
            ?>
        </div>

        <?php
        echo Build::Pagination($item_on_page,'recipes','/profile/recipes');
    }

    ?>
</section>