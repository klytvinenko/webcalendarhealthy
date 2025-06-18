
<h1><?= $workout->title ?></h1>
<div class="center">
    <p><b>Ккалорії: </b><?= $workout->kcal ?>/год</p>
    <p><b>К-сть: </b><?= $workout_number ?> разів було заплановане</p>
    <div class="line"></div>
    <p><b>Опис: </b><?= $workout->description ?></p>
    <?php 
        if($workout->has_copies){
        ?>
        <div class="line"></div>
        <table id="products">
        <thead>
            <tr>
                <th>Назва</th>
                <th>Користувач</th>
                <th>Опис</th>
                <th>Ккал</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($workout->copies as $copy) {
                ?>
                <tr id="workout_<?= $copy['id'] ?>">
                    <td><?=  $copy['title'] ?></td>
                    <td><?=  $copy['user_login'] ?></td>
                    <td><?=  $copy['description'] ?></td>
                    <td><?=  $copy['kcal'] ?></td>
                    <td class="icons"><button class="button-icon button-icon-primary" onclick="href('/admin/workouts/replace?original_id=<?=$workout->id?>&new_id=<?= $copy['id'] ?>')" title="Замінити"><ion-icon name="sync-outline"></ion-icon></button>
                </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
        
</ul><?php 
}
?>
</div>