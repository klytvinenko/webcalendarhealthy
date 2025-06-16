<h1>Список продуктів</h1>

<div class="row j-c-end w-full">
    <button class="button" onclick="href('/admin/products/add')">Додати</button>
</div>
<?php
use App\Build;
if (empty($products)) {
    echo '<div class="empty-data"><p>Продуктів не додано</div></div>';
} else {
    ?>
    <table id="products">
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
                <tr id="product_<?= $product->id ?>">
                    <td><?= $product->title ?><i style="color:orange"><?= $product->approved?'':" Додано користувачем ".$product->user->login ?></i></td>
                    <td><?= $product->type == 'product' ? '<ion-icon title="Може використовуватись як самостійний продукт" class="black-icon" name="fast-food-outline"></ion-icon>' : ' - ' ?>
                    </td>
                    <td><?= $product->kcal ?></td>
                    <td><?= $product->fat ?></td>
                    <td><?= $product->protein ?></td>
                    <td><?= $product->carbonation ?></td>
                    <td><?= $product->na ?></td>
                    <td><?= $product->cellulose ?></td>
                    </td>
                    <td class="icons">
                        <?php
                        if($product->approved&&!$product->is_copy){
                            ?>
                            <button class="button-icon button-icon-add" onclick="href('/admin/products/show?id=<?= $product->id ?>')" title="Зберегти для всіх"><ion-icon name="checkmark-outline"></ion-icon></button>
                        <?php
                        } else {
                        ?>
                            <button class="button-icon button-icon-primary" onclick="href('/admin/products/show?id=<?= $product->id ?>')" title="Замінити"><ion-icon name="sync-outline"></ion-icon></button>
                            <?php
                        }
                        ?>
                        <button class="button-icon button-icon-show"
                            onclick="href('/admin/products/show?id=<?= $product->id ?>')" title="Переглянути"><ion-icon
                                name="ellipsis-horizontal-circle-outline"></ion-icon></button>
                        <button class="button-icon button-icon-edit"
                            onclick="href('/admin/products/edit?id=<?= $product->id ?>')" title="Редагувати"><ion-icon
                                name="create-outline"></ion-icon></button>
                        <button class="button-icon button-icon-remove"
                            onclick="Delete('/admin/products/delete?id=<?= $product->id?>','product_<?= $product->id ?>')"><ion-icon
                                name="close-circle-outline" title="Видалити"></ion-icon></button>
                    </td>

                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php
    echo Build::Pagination($item_on_page,'products','/admin/products');

}
?>