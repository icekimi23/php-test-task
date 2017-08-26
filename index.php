<?php

header('Content-Type: text/html; charset=utf-8');

$title = 'Hodor';

$userID = $_COOKIE['userID'];

if (isset($userID)) {
    // делаем запрос на получение товаров в корзине
    $orders = getUserOrders($userID);

    $orderItems = array();
    $items = array();

    if ($orders) {
        $productIDs = array();
        while ($row = mysqli_fetch_assoc($orders)) {
            array_push ($orderItems, $row);
            array_push ($productIDs, $row['product_id']);
        }
        // делаем запрос на получение товаров для добавления в корзину
        $products = getProducts($productIDs);

        while ($row = mysqli_fetch_assoc($products)) {
            array_push ($items, $row);
        }

    }

} else {
    // создаем пользователя и устанавливаем cookie
    $id = createNewUser();
    setcookie("userID", $id, time() + 3600 * 24 * 7); // устанавливаем на неделю
};

function createNewUser()
{

    require 'db_config.php';

    $db_link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error());

    $result = mysqli_query($db_link, "INSERT INTO  `users` (`user_id`) VALUES (NULL)");

    if ($result) {
        return mysqli_insert_id($db_link);
    } else {
        return false;
    }
}

// Получить товары в корзине для пользователя
function getUserOrders($id)
{
    require 'db_config.php';
    $db_link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error());

    mysqli_query($db_link,"SET NAMES utf8");

    $result = mysqli_query($db_link, "SELECT  `orders_content`.`product_id` ,  `goods`.`name` ,  `goods`.`image` ,  `goods`.`cost` ,  `producers`.`name` ,  `orders_content`.`amount` 
                                                FROM  `orders_content` 
                                                INNER JOIN  `orders` ON  `orders_content`.`order_id` =  `orders`.`order_id` 
                                                INNER JOIN  `goods` ON  `orders_content`.`product_id` =  `goods`.`product_id` 
                                                INNER JOIN  `producers` ON  `goods`.`producer_id` =  `producers`.`producer_id` 
                                                WHERE  `orders`.`user_id` = ".mysqli_escape_string($db_link,$id));

    $rows = mysqli_affected_rows($db_link);

    if ($rows > 0) {
        return $result;
    }
    elseif ($rows == 0) {
        return false;
    }
}

// Получить товары для добавления в корзину (уже добавленные в корзину($addedProductsIds) не должны отображаться)
function getProducts($addedProductsIds){

    require 'db_config.php';

    $db_link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error());

    mysqli_query($db_link,"SET NAMES utf8");

    forEach($addedProductsIds as $key => $value) {
        $addedProductsIds[$key] = mysqli_escape_string($db_link,$value);
    }

    $idsForQuery = implode(',', $addedProductsIds);

    $result = mysqli_query($db_link, "SELECT  * 
                                                FROM  `goods` 
                                                WHERE  `goods`.`product_id` NOT IN (".mysqli_escape_string($db_link,$idsForQuery).") AND `goods`.`isGroup` = 0");

    $rows = mysqli_affected_rows($db_link);

    if ($rows > 0) {
        return $result;
    }
    elseif ($rows == 0) {
        return false;
    }

}


include './template.php';

?>