<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title><?php echo $title ?></title>
    <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <script src = "js/main.js" defer></script>
</head>
<body>

    <div class="container">

        Список покупок
        <ul id = "bucket">
            <?php
                foreach ($orderItems as $item) {
                    echo "<li>";
                    echo "<div>".$item['product_name']."</div>";
                    echo '<input class = "id" type = "hidden" value = '.$item['product_id'].'>';
                    echo '<input class = "amount" type = "number" value = '.$item['amount'].'>';
                    echo "<button class = 'removeFromBucket'>Удалить</button>";
                    echo "</li>";
                }
            ?>
        </ul>

        Список товаров
        <ul id = "productList">
            <?php
                foreach ($items as $item) {
                    echo "<li>";
                    echo "<div>".$item['name']."</div>";
                    echo '<input class = "id" type = "hidden" value = '.$item['product_id'].'>';
                    echo '<input class = "amount" type = "number" value = "1"/>';
                    echo "<button class = 'addToBucket'>Добавить в корзину</button>";
                    echo "</li>";
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