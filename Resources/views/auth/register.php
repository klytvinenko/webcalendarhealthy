<form action="/signup" method="POST" enctype="multipart/form-data">
    
    <label>Ім'я</label>
    <input type="text" name="login" placeholder="Введіть своє ім'я">
    <?= isset($_SESSION['message']['login']) ? '<p class="msg"> ' . $_SESSION['message']['login'] . ' </p>' : ''; ?>
    
    <label>Ел.пошта</label>
    <input type="email" name="email" placeholder="Введіть електронну пошту">
    <?= isset($_SESSION['message']['email']) ? '<p class="msg"> ' . $_SESSION['message']['email'] . ' </p>' : ''; ?>
    
    <label>Пароль</label>
    <input type="password" name="password" placeholder="Введіть пароль">
    
    <label>Пітвердження пароля</label>
    <input type="password" name="password_confirm" placeholder="Підтвердьте пароль">
    <?= isset($_SESSION['message']['password']) ? '<p class="msg"> ' . $_SESSION['message']['password'] . ' </p>' : ''; ?>
    <?= isset($_SESSION['message']['password_confirm']) ? '<p class="msg"> ' . $_SESSION['message']['password_confirm'] . ' </p>' : ''; ?>
    <?php
    echo isset($_SESSION['message']['all_form']) ? '<p class="msg"> ' . $_SESSION['message']['all_form'] . ' </p>' : '';
    unset($_SESSION['message']);
    unset($_SESSION['not_valid']);
    ?>
    <button class="btn" type="submit">Увійти</button>
    <button type="button" class="secondary" onclick='href("/")'>Авторизація</button>
   
</form>