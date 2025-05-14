<div id="modalGenerateMenu" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span onclick="closeModal('modalGenerateMenu')" class="close">&times;</span>
            <form id="form_generate_menu" action="/api/generatemenu">

                <h3>Генерація меню</h3>
                <!-- TODO -->
                <button onclick="Ajax.GenerateMenu(this)">Додати</button>

            </form>
        </div>
    </div>