<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Адмінка - Лікарня</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="icon" href="./images/hospital.svg">
</head>
<body>
    <div class="wrap">
        <div class="wrap-header">
            <header>
                <h2><a href="/">Київська центральна лікарня</a></h2>
                <a class="a-header" href="/add">Додати лікаря</a>
                <a class="a-header" href="/logout">Вийти</a>
            </header>
        </div>
        <section class="content">
            <div class="search">
                <form action="/admin">
                    <input name="search" type="search" placeholder="пошук по імені" required minlength=3>
                </form>
            </div>
            <?php foreach($scope['applications'] as $application):?>
            <div class="aplication">
                <p><?= $application['username']?></p>
                <p><?= $application['visit_date']?></p>
                <p>Лікар: <?= $application['type']?></p>
            </div>
            <?php endforeach ?>
        </section>
        <div class="wrap-footer">
            <footer>
                @2022 Всі Права Захищені
            </footer>
        </div>
    </div>
</body>
</html>