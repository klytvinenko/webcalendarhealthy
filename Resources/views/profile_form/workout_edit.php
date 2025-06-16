<form id="form_add_training" action="/profile/workouts/update?id=<?= $workout->id ?>" method="POST">
    <div class="row">

        <?php
        use App\Build;
        echo Build::FormControlInput('title', 'Назва', 'text', 'required value="' . $workout->title . '"');
        echo Build::FormControlInput('kcal', 'Спалювані ккалорії (за 1 год.)', 'number', 'required min="0" value="' . $workout->kcal . '"');
        ?>
    </div>

        <?php
        echo Build::FormControlTextarea('description', 'Опис / Інструкція', "", $workout->description);
        echo Build::Button("Зберегти");
        ?>
        
</form>