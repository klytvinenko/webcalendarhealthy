<div id="profile_link">
    <a href="./profile/setting">Повернутись</a>
</div>

<section class="setting">
    <h2 style="margin: 10px 0;">Розрахування норми калорій</h2>
    <form action="/profile/calc_kcal" method="post">
        <div class="form-control">
            <p>Стать:</p>
            <div class="inline">
                <input type="radio" id="woman" name="sex" value="woman">
                <label for="woman">жінка</label>
                <input type="radio" id="man" name="sex" value="man">
                <label for="man">чоловік</label>
            </div>

        </div>
        <?php
        use App\Build;

        echo Build::FormControlInput('weight','Вага','number','required min="45"');
        echo Build::FormControlInput('height','Зріст','number','required min="155"');
        echo Build::FormControlInput('date_of_birth','Дата народження','date','required');
        ?>
        
        <div class="form-control"></div>
        <label for="activity_level">Рівень активності</label>
        <select name="activity_level" id="activity_level">
            <option value="">Оберіть...</option>
            <?php
            foreach ($activity_levels as $level => $description) {
                ?>
                <option value="<?= $level ?>"><?= $level . ' - ' . $description ?></option>
                <?php
            }
            ?>
        </select>
        </div>
        <!-- <label for="age">Вік</label>
            <input type="text" name="age" placeholder="Вік" required> -->
        <button>Розрахувати</button>
    </form>
</section>