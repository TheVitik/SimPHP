<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявка на відвідування лікаря - Лікарня</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="icon" href="./images/hospital.svg">
</head>
<body>
    <?php if(isset($scope['message'])):?>
        <div id="message_bar"><?= $scope['message']?></div>
    <?php endif ?>
    <div class="wrap">
        <div class="wrap-header">
            <header>
                <h2><a href="/">Київська центральна лікарня</a></h2>
                <a class="a-header" href="/account">Назад</a>
            </header>
        </div>
        <section class="content">
            <form action="/create" method="POST">
                <fieldset>
                <?php if(isset($scope['errors'])):?>
                <ul>
                <?php foreach($scope['errors'] as $error):?>
                    <li><?= $error ?></li>
                <?php endforeach ?>
                </ul>
                <?php endif ?>
                    <legend>Подавання заявки на відвідування лікаря</legend>
                    <select name="doctor" required>
                        <?php foreach($scope['doctors'] as $doctor):?>
                            <option value="<?= $doctor['id']?>"><?= $doctor['type']?></option>
                        <?php endforeach ?>
                    </select>
                    <input name="visit_date" type="datetime-local" required>
                    <input name="phone" type="tel"  pattern="^((\+380)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$" placeholder="+380969352474" title="Введіть в форматі : +380969352473" required>
                    <button>Подати заявку</button> 
                </fieldset>
            </form>
        </section>
        <div class="wrap-footer">
            <footer>
                @2022 Всі Права Захищені
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="js/message.js"></script>
</body>
</html>