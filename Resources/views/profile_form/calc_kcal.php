<?php

use App\Build;
?>
<section class="setting">
    <form action="/profile/calc_kcal" method="post">
        <div class="form-control">
            <b>Стать:</b>
            <div class="inline">
                <input type="radio" id="woman" name="sex" value="woman" <?= $user->sex == "woman" ? "checked" : "" ?>>
                <label class="unbold" for="woman">жінка</label>
                <input type="radio" id="man" name="sex" value="man" <?= $user->sex == "man" ? "checked" : "" ?>>
                <label class="unbold" for="man">чоловік</label>
            </div>

        </div>
        <?php

        $weigth = $user->weight->value ?? 0;

        echo Build::FormControlInput('weight', 'Вага', 'number', 'required min="45" value="' . $weigth . '"');
        echo Build::FormControlInput('height', 'Зріст', 'number', 'required min="155" value="' . $user->height . '"');
        echo Build::FormControlInput('date_of_birth', 'Дата народження', 'date', 'required value="' . $user->date_of_birth . '"');
        echo Build::FormControlSelect('activity_level', 'Рівень активності', 'required', $activity_levels);
        echo Build::Button();

        ?>
    </form>
</section>