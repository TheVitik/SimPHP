<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстрація - Лікарня</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="icon" href="./images/hospital.svg">
</head>
<body>
    <div class="wrap">
        <div class="wrap-header">
            <header>
                <h2><a href="/">Київська центральна лікарня</a></h2>
                <a class="a-header" href="/login">Увійти в особистий кабінет</a>
            </header>
        </div>
        <section class="content">
            <form action="/login" method="POST">
                <fieldset>
                <?php if(isset($scope['errors'])):?>
                <ul>
                <?php foreach($scope['errors'] as $error):?>
                    <li><?= $error ?></li>
                <?php endforeach ?>
                </ul>
                <?php endif ?>
                    <legend>Форма авторизації користувача</legend>
                    <input name="email" type="email" placeholder="Email" required>
                    <input name="password" type="password" placeholder="Password" required>
                    <button>Увійти</button>
                    <span>якщо ви не зареєстровані - <a href="/register">зареєструйтеся</a></span>
                </fieldset>
            </form>
        </section>
        <div class="wrap-footer">
            <footer>
                @2022 Всі Права Захищені
            </footer>
        </div>
    </div>
</body>
</html>