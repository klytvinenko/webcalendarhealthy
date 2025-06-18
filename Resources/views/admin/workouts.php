<h1>Список тренувань</h1>

<div class="row j-c-end w-full">
    <button class="button" onclick="href('/admin/workouts/add')">Додати</button>
</div>
<?php
if (empty($workouts)) {
    echo '<p>Тренувань не додано<p>';
}else{
?>
<ul id="workouts_list">
    <?php
    foreach ($workouts as $workout) {
        
        ?>
        <li id="workout_<?=$workout->id?>">
            <div class="row w-90">

                <h4><?= $workout->title ?></h4>
                <i class="text-light overflow-hide"><?= $workout->description ?></i>
                <p><?= $workout->kcal ?> ккал/год</p>
            </div>
            <div class="icons">
            <?php
                        if(!$workout->approved&&!$workout->is_copy){
                            ?>
                            <button class="button-icon button-icon-add" onclick="href('/admin/workouts/approve?id=<?= $workout->id ?>')" title="Зробити доступним для всіх"><ion-icon name="lock-open-outline"></ion-icon></button>
                        <?php
                        } 
                        ?>
            <button class="button-icon button-icon-show"
                                onclick="href('/admin/workouts/show?id=<?=$workout->id?>')" title="Переглянути"><ion-icon name="ellipsis-horizontal-circle-outline"></ion-icon></button>
                            <button class="button-icon button-icon-edit" onclick="href('/admin/workouts/edit?id=<?=$workout->id?>')" title="Редагувати"><ion-icon
                                    name="create-outline"></ion-icon></button>
                                    <?php
                        if($workout->can_be_delete&&$workout->approved){
                            ?>
                            <button class="button-icon button-icon-remove" onclick="Delete('/admin/workouts/delete?id=<?=$workout->id?>','workout_<?=$workout->id?>')"><ion-icon name="close-circle-outline"
                                    title="Видалити"></ion-icon></button><?php
                        } 
                        ?>
            </div>
        </li>
        <?php
    }
    ?>
</ul>
<?php 
} 
?>