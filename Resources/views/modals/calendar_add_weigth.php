<div id="modalAddWeigth" class="modal">
    <div class="modal-content">
        <span onclick="closeModal('modalAddWeigth')" class="close">&times;</span>
        <h3>Додавання ваги на сьогодні</h3>
        <form id="form_add_weight" action="/api/weights/calendar/store">
            <input type="text" name="date" class="hidden" value="<?= $date ?>">
            <?php
            use App\Build;
            echo Build::FormControlInput('weigth', 'Вага', 'number', ' min="45" step="0.5"');
            echo Build::ButtonAPI('updateWeight');
            ?>
        </form>
    </div>
</div>