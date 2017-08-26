<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title><?php echo $title ?></title>
</head>
<body>

    <div class="container">

        Список покупок
        <ul>
            <?php
                foreach ($orderItems as $item) {
                    echo "<li>".$item['name']."</li>";
                    echo "<button>Удалить</button>";
                }
            ?>
        </ul>

        Список товаров
        <ul>
            <?php
                foreach ($items as $item) {
                    echo "<li>".$item['name']."</li>";
                    echo '<input type = "number" value = "1"/>';
                    echo "<button class = 'addToBucket'>Добавить в корзину</button>";
                }
            ?>
        </ul>

<!--        <button class="addToBucket"></button>-->


<!--        <div class="row">-->
<!--            <div class="col-xs-12">-->
<!--                <p>Список покупок</p>-->
<!--            </div>-->
<!--            <div class="col-md-8">-->
<!---->
<!--            </div>-->
<!--            <div class="col-md-2">-->
<!--                <p>Цена</p>-->
<!--            </div>-->
<!--            <div class="col-md-2">-->
<!--                <p>Количество</p>-->
<!--            </div>-->
<!---->
<!--            <div class="col-xs-12">-->
<!--                <div class="col-md-2">-->
<!--                    <img src="images/chico.jpg" alt="">-->
<!--                </div>-->
<!--                <div class="col-md-6">-->
<!---->
<!--                </div>-->
<!--                <div class="col-md-2">-->
<!--                    <p>2500</p>-->
<!--                </div> -->
<!--                <div class="col-md-2">-->
<!--                    <input type="number">-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--        </div>-->


<!--        <div class="row">-->
<!--            <p>Список товаров</p>-->
<!--            <ul>-->
<!--                <li></li>-->
<!--                <li></li>-->
<!--            </ul>-->
<!--        </div>-->
    </div>

</body>
</html>