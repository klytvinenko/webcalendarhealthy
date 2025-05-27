<section class="setting">
    <form action="/profile/change_diets" method="post">
        <?php 
        // in_array($allergy['id'], $user->allergiesIds()) ? "selected" : "" 
        ?>
        <?php 
        use App\Build;
        echo Build::FormControlSelect('diets[]', 'Дієта', 'multiple', $diets,'Не обирати');
        echo Build::FormControlSelect('allergies[]', 'Алергени', 'multiple', $allergies,'Не обирати');
        echo Build::Button();
        ?>
    </form>
</section>