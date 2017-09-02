<?php

function formCategoryText($categoryArr) {
    $categoryText = implode($categoryArr,'<img class = "arrow-right" src="images/arrow_right.svg" alt="">');
    return $categoryText;
}

$cart_items = '';
foreach ($orderItems as $item) {
    $cart_items .= '<div class="inner-wrapper">
                    <div class="row">
                        <input class = "id" type="hidden" value = ' . $item['product_id'] . '>
                        <div class="col-sm-3 col-md-2 col-xs-4">
                            <img class="img-responsive" src=' . $item['image'] . '>
                        </div>
                        <div class="col-sm-5 col-md-6 col-xs-8 caption">
                            <div class="row title">
                               ' . $item['product_name'] . '
                            </div>
                            <div class="row producer">
                                ' . $item['name'] . '
                            </div>
                            <div class="row category">
                                <div class = "catecory">' . formCategoryText($item['categoryArr']) . '</div>
                            </div>
                            <div class="row controlBtn">
                                <a class = "removeFromBucket" href="#">Удалить</a>
                            </div>
                            <div class="row"></div>
                        </div>
                        <div class="col-sm-2 col-xs-6 text-center price">
                             ' . $item['cost'] . ' руб.
                        </div>
                        <div class="col-sm-2 col-xs-6 text-center">
                            <input class = "amount" type="number" value = ' . $item['amount'] . '>
                        </div>
    
                    </div>
                </div>';
}

$other_items = '';
foreach ($items as $item) {
    $other_items .= '<div class="inner-wrapper">
                    <div class="row">
                        <input class = "id" type="hidden" value = ' . $item['product_id'] . '>
                        <div class="col-sm-3 col-md-2 col-xs-4">
                            <img class="img-responsive" src=' . $item['image'] . '>
                        </div>
                        <div class="col-sm-5 col-md-6 col-xs-8 caption">
                            <div class="row title">
                               ' . $item['product_name'] . '
                            </div>
                            <div class="row producer">
                                ' . $item['name'] . '
                            </div>
                            <div class="row category">
                                <div class = "catecory">' . formCategoryText($item['categoryArr']) . '</div>
                            </div>
                            <div class="row controlBtn">
                                <a class = "addToBucket" href="#">В корзину</a>
                            </div>
                            <div class="row"></div>
                        </div>
                        <div class="col-sm-2 col-xs-6 text-center price">
                             ' . $item['cost'] . ' руб.
                        </div>
                        <div class="col-sm-2 col-xs-6 text-center">
                            <input class = "amount" type="number" value = "1">
                        </div>
    
                    </div>
                </div>';
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Shopping cart</title>
    <script src="https://code.jquery.com/jquery-3.2.1.js"
            integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/closest-polyfill.js" defer></script>
    <script src="js/main.js" defer></script>
</head>
<body>

<div class="container">

    <div class="outer-wrapper cart">
        <p class="header-text">Список покупок</p>
        <div class="row header">
            <div class="col-sm-3"></div>
            <div class="col-sm-5"></div>
            <div class="col-sm-2 hidden-xs text-center column-header-text">Цена</div>
            <div class="col-sm-2 hidden-xs text-center column-header-text">Количество</div>
        </div>

        <div id="bucket">
            <?php echo $cart_items; ?>
        </div>


        <p class="summary-text"></p>

    </div>

    <div class="outer-wrapper products">
        <p class="header-text">Список товаров</p>
        <div class="row header">
            <div class="col-sm-3"></div>
            <div class="col-sm-5"></div>
            <div class="col-sm-2 hidden-xs text-center column-header-text">Цена</div>
            <div class="col-sm-2 hidden-xs text-center column-header-text">Количество</div>
        </div>

        <div id="productList">
            <?php echo $other_items; ?>
        </div>

    </div>

</div>

</div>

</body>
</html>