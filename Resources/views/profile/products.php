<section id="products">
    <div class="row j-c-end w-full">
        <button class="button button-add" onclick="href('/profile/products/add')">Додати</button>
    </div>
    <?php
    use App\Build;
    if (empty($products)) {
        echo '<div class="empty-data"><p class="text-center">Продуктів не додано</div></div>';
    } else {
        ?>
        <table>
            <thead>
                <tr>
                    <th>Назва</th>
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
                foreach ($products as $product) {
                    ?>
                    <tr id="product_<?= $product['id'] ?>">
                        <td><?= $product['title'] ?></td>
                        <td><?= $product['type'] == 'product' ? '<ion-icon title="Може використовуватись як самостійний продукт" class="black-icon" name="fast-food-outline"></ion-icon>' : ' - ' ?>
                        </td>
                        <td><?= $product['kcal'] ?></td>
                        <td><?= $product['fat'] ?></td>
                        <td><?= $product['protein'] ?></td>
                        <td><?= $product['carbonation'] ?></td>
                        <td><?= $product['na'] ?></td>
                        <td><?= $product['cellulose'] ?></td>
                        </td>
                        <td class="icons">
                            <button class="button-icon button-icon-like"
                                onclick="href('/profile/products/like?id=<?= $product['id'] ?>')" title="<?= $product['is_liked']?'Прибрати з улюблених':'Додати до улюблених' ?>">
                                <?php
                                if ($product['is_liked']) {
                                    ?>
                                    <ion-icon name="heart-outline"></ion-icon>
                                    <?php
                                } else {
                                    ?>
                                    <ion-icon name="heart-dislike-outline"></ion-icon>
                                    <?php
                                }
                                ?>
                            </button>
                            <button class="button-icon button-icon-show"
                                onclick="href('/profile/products/show?id=<?= $product['id'] ?>')" title="Переглянути"><ion-icon
                                    name="ellipsis-horizontal-circle-outline"></ion-icon></button>
                            <button class="button-icon button-icon-edit"
                                onclick="href('/profile/products/edit?id=<?= $product['id'] ?>')" title="Редагувати"><ion-icon
                                    name="create-outline"></ion-icon></button>
                        </td>

                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php
        echo Build::Pagination($item_on_page, 'products', '/profile/products');

    }
    ?>
</section>