<div id="profile_link">
    <a href="./profile_setting.php">Повернутись</a>
</div>
<section class="setting">
    <h2 style="margin: 10px 0;">Редагування дієти</h2>
    <form action="/profile/change_diets" method="post">
        <label for="diets">Дієта</label>
        <select name="diets[]" id="diets" multiple>
            <option value="">Не обирати</option>
            <?php
            foreach ($diets as $diet) {
                ?>
                <option value="<?= $diet['id'] ?>" <?= in_array($diet['id'], $user->dietsIds()) ? "selected" : "" ?>><?= $diet['name'] ?></option>
            <?php } ?>
        </select><label for="allergies">Алергії</label>
        <select name="allergies[]" id="allergies" multiple>
            <option value="">Не обирати</option>
            <?php
            foreach ($allergies as $allergy) {
                ?>
                <option value="<?= $allergy['id'] ?>" <?= in_array($allergy['id'], $user->allergiesIds()) ? "selected" : "" ?>><?= $allergy['name'] ?></option>
            <?php } ?>
        </select>
        <button>Зберегти</button>
    </form>
</section>