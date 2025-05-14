<h1><?= $title ?></h1>
<table>
    <thead>
        <tr>
            <th>Назва</th>
            <th>Дієти</th>
            <th>Алергени</th>
            <th>Каллорії</th>
            <th>Дії</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        use App\Models\Product;
        $products=Product::fulldata();
        foreach($products as $product){
        ?>
        <tr>
            <td><?=$product['title']?></td>
            <td><?=$product['diets']?></td>
            <td><?=$product['allergies']?></td>
            <td><?=$product['kcal']?></td>
            <td>
                <button class="btn-icon" title="show"><ion-icon name="eye-outline"></ion-icon></button>
                <button class="btn-icon" title="edit"><ion-icon name="create-outline"></ion-icon></button>
                <button class="btn-icon" title="delete"><ion-icon name="close-outline"></ion-icon></button>
            </td>
        </tr>
<?php 
}
        ?>
    </tbody>
</table>