
<section>
<div class="row j-c-end w-full">
    <button class="button button-add" onclick="href('/profile/workouts/add')">Додати</button>
</div>
<?php
if (empty($workouts)) {
    echo '<div class="empty-data"><p class="text-center">Тренувань не додано<p></div>';
}else{
?>
<ul id="workouts_list">
    <?php
    foreach ($workouts as $workout) {
        ?>
        <li id="workout_<?=$workout['id']?>">
            <div class="row w-90" style="width: 85%;align-items:center;">

                <h4><?= $workout['title'] ?></h4>
                <i class="text-light overflow-hide" title="<?= $workout['description'] ?>"><?= $workout['description'] ?></i>
                <p><?= $workout['kcal'] ?> ккал/год</p>
            </div>
            <div class="icons">
            <button class="button-icon button-icon-show"
                                onclick="href('/profile/workouts/show?id=<?= $workout['id'] ?>')" title="Переглянути"><ion-icon
                                    name="ellipsis-horizontal-circle-outline"></ion-icon></button>
                            <button class="button-icon button-icon-edit" onclick="href('/profile/workouts/edit?id=<?=$workout['id']?>')" title="Редагувати"><ion-icon
                                    name="create-outline"></ion-icon></button>
                           
            </div>
        </li>
        <?php
    }
    ?>
</ul>
<?php 
} 
?></section>