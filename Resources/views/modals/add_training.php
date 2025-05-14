<div id="modalAddTraining" class="modal">
    <div class="modal-content">
        <span onclick="closeModal('modalAddTraining')" class="close">&times;</span>

        <form id="form_add_training" action="/api/workouts/store">
            <h3>Додавання тренування на сьогодні</h3>
            <label>Назва тренування</label>
            <input type="text" name="title" id="">
                <?php
                // use App\Build;
                // Build::FormControlSelect("type","Тип","",$workoutsTypes);
                ?>
            <label>Початок</label>
            <input type="time" id="" name="time_start" value="07:00" required />
            <label>Закінчення</label>
            <input type="time" name="time_end" value="08:00" required />
            <button onclick="Ajax.Post(this)">Додати</button>
        </form>

    </div>
</div>