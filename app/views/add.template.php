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
                <a class="a-header" href="/admin">Назад</a>
            </header>
        </div>
        <section class="content">
            <form action="/add" method="POST">
                <fieldset>
                    <legend>Форма додавання лікаря</legend>
                    <input name="type" type="text" placeholder="Невролог" required>
                    <button>Додати</button>
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