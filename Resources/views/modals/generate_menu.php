<div id="modalGenerateMenu" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span onclick="closeModal('modalGenerateMenu')" class="close">&times;</span>
        <form id="form_generate_menu" action="/profile/meals/generate" method="post">
            <h3>Генерація меню</h3>
            <b>Оберіть параметри перед генерацією меню:</b>
            <input type="input" name="for_work_put_method" value="test" style="visibility:hidden;" id="">
            <?php
            use App\Build;

            echo '<div class="row">';
            echo Build::FormControlInput('favorite_dishes', 'Улюблені страви', 'checkbox', '');
            echo Build::FormControlInput('no_sweets','без солодощів', 'checkbox', '');
            echo '</div><div class="row">';
            echo Build::FormControlInput('no_bakery','без мучного', 'checkbox', '');
            // echo Build::FormControlInput('no_soups','без супів', 'checkbox', '');!
            echo '</div>';
            echo Build::Button();
            ?>

        </form>
    </div>
</div>