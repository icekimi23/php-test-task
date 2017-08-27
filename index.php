<?php

header('Content-Type: text/html; charset=utf-8');
require 'db_functions.php';

$title = 'Hodor';

$userID = $_COOKIE['userID'];

if (isset($userID)) {
    // делаем запрос на получение товаров в корзине
    $orders = getUserOrders($userID);

    $orderItems = array();
    $items = array();

    $productIDs = array();

    if ($orders) {
        while ($row = mysqli_fetch_assoc($orders)) {
            array_push ($orderItems, $row);
            array_push ($productIDs, $row['product_id']);
        }
    }

    // делаем запрос на получение товаров для добавления в корзину
    $products = getProducts($productIDs);

    if ($products) {
        while ($row = mysqli_fetch_assoc($products)) {
            array_push ($items, $row);
        }
    }

} else {
    // создаем пользователя и устанавливаем cookie
    $id = createNewUser();
    setcookie("userID", $id, time() + 3600 * 24 * 7); // устанавливаем на неделю
};

include './template.php';

?>