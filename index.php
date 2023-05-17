<!DOCTYPE html>
<html lang="en" class="uk-height-1-1">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth</title>
    <link href="css/style.css" rel="stylesheet">
    <script src="script.js"></script>
</head>

<body>
    <section id="profile" class="hidden">
        <img src="" role="avatar">
        <h3 role="name">Name</h3>
        <p role="birthday">Birthday</p>
        <button role='logout'>Выйти</button>
    </section>
    <div id="success" class="hidden">
        <p>Выполнен вход</p>
        <p>Страница автоматически перезагрузится через 10 секунд</p>
    </div>
    <div id="error" class="hidden">
        <p>Неправильный логин и/или пароль</p>
    </div>
    <form id="auth" method="post">
        <fieldset>
            <legend>Авторизация</legend>
            <input id="login" name="login" type="text" placeholder="Логин">
            <input id="password" name="password" type="password" placeholder="Пароль">
            <button type="submit">Войти</button>
        </fieldset>
    </form>
</body>

</html>