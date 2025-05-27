<div id="modalAddTraining" class="modal">
    <div class="modal-content">
        <span onclick="closeModal('modalAddTraining')" class="close">&times;</span>
        <h3>Додавання тренування на сьогодні</h3>
        <form id="form_add_training" action="/api/workouts/calendar/store?date=<?= $date ?>">
            <?php
            use App\Build;

            echo '<div class="row">';
            echo Build::FormControlSelect('type', 'Тип', 'required id="modal_add_training_select_training"  onchange="calcKcalByTraining()"', $workoutsTypes);
            echo Build::FormControlInput('calc_kcal_by_training', 'Витрати', 'text', 'readonly id="calc_kcal_by_training"');
            echo '</div><div class="row">';
            echo Build::FormControlInput('start_time', 'Початок', 'time', 'required id="modal_add_training_start_time" onchange="calcKcalByTraining()"');
            echo Build::FormControlInput('end_time', 'Закінчення', 'time', 'required id="modal_add_training_end_time" onchange="calcKcalByTraining()"');
            echo '</div>';
            echo Build::ButtonAPI('updateTrainings');
            ?>
        </form>

    </div>
</div>