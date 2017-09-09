<?php
error_reporting(0);

function createNewUser()
{

    require 'db_config.php';

    $user_id = uniqid("",true);

    $db_link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error());
    $query = "INSERT INTO  `users` (`user_id`) VALUES ('".mysqli_escape_string($db_link, $user_id)."')";
    $result = mysqli_query($db_link, $query);

    if ($result) {
        return $user_id;
    } else {
        return false;
    }
}

function createNewOrder($userID)
{

    require 'db_config.php';

    $db_link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error());
    $query = "INSERT INTO  `orders` (`order_id`,`user_id`) VALUES (NULL,'" . mysqli_escape_string($db_link, $userID) ."')";
    $result = mysqli_query($db_link, $query);

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

    mysqli_query($db_link, "SET NAMES utf8");

    $query = "SELECT  `orders_content`.`product_id` ,  `goods`.`name` AS `product_name`,  `goods`.`image` , `goods`.`parent_id`, `goods`.`cost` ,  `producers`.`name` ,  `orders_content`.`amount` 
                                                FROM  `orders_content` 
                                                INNER JOIN  `orders` ON  `orders_content`.`order_id` =  `orders`.`order_id` 
                                                INNER JOIN  `goods` ON  `orders_content`.`product_id` =  `goods`.`product_id` 
                                                INNER JOIN  `producers` ON  `goods`.`producer_id` =  `producers`.`producer_id` 
                                                WHERE  `orders`.`user_id` = '" . mysqli_escape_string($db_link, $id)."'";
    $result = mysqli_query($db_link, $query);

    $rows = mysqli_affected_rows($db_link);

    if ($rows > 0) {
        return $result;
    } elseif ($rows == 0) {
        return false;
    }
}

// Получить товары для добавления в корзину (уже добавленные в корзину($addedProductsIds) не должны отображаться)
function getProducts($addedProductsIds)
{

    require 'db_config.php';

    $db_link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error());

    mysqli_query($db_link, "SET NAMES utf8");

    forEach ($addedProductsIds as $key => $value) {
        $addedProductsIds[$key] = mysqli_escape_string($db_link, $value);
    }

    $idsForQuery = implode(',', $addedProductsIds);

    if (count($addedProductsIds) > 0) {
        $cond = " AND `goods`.`product_id` NOT IN (" . mysqli_escape_string($db_link, $idsForQuery) . ")";
    } else {
        $cond = "";
    }

    $query = "SELECT  `goods`.`product_id` , `goods`.`parent_id`,  `goods`.`name` AS `product_name`,  `goods`.`image` ,  `goods`.`cost` ,  `producers`.`name` 
              FROM  `goods`
              INNER JOIN  `producers` ON  `goods`.`producer_id` =  `producers`.`producer_id` 
              WHERE  `goods`.`isGroup` = 0" . $cond;

    $result = mysqli_query($db_link, $query);

    $rows = mysqli_affected_rows($db_link);

    if ($rows > 0) {
        return $result;
    } elseif ($rows == 0) {
        return false;
    }
}

function getOrderID($userID)
{

    require 'db_config.php';

    $db_link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error());

    mysqli_query($db_link, "SET NAMES utf8");

    $query = "SELECT `orders`.`order_id` FROM `orders` WHERE `orders`.`user_id` = '". mysqli_escape_string($db_link, $userID)."'";
    $result = mysqli_query($db_link, $query);

    $rows = mysqli_affected_rows($db_link);

    if ($rows > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['order_id'];
    } elseif ($rows == 0) {
        return false;
    }

}

function addProductToOrder($orderID, $productID, $amount)
{

    require 'db_config.php';

    $db_link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error());

    $result = mysqli_query($db_link, "INSERT INTO  `orders_content` (
                                                    `id` ,
                                                    `order_id` ,
                                                    `product_id` ,
                                                    `amount`
                                                    )
                                                    VALUES (
                                                    NULL , " . mysqli_escape_string($db_link, $orderID) . "," . mysqli_escape_string($db_link, $productID) . "," . mysqli_escape_string($db_link, $amount) . "
                                                    )");

    if ($result) {
        return true;
    } else {
        return false;
    }

}

function removeProductFromOrder($orderID, $productID)
{

    require 'db_config.php';

    $db_link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error());

    $query = "DELETE FROM `orders_content` WHERE `orders_content`.`order_id` = " . mysqli_escape_string($db_link, $orderID) . " AND `orders_content`.`product_id` = " . mysqli_escape_string($db_link, $productID);

    $result = mysqli_query($db_link, $query);

    if ($result) {
        return true;
    } else {
        return false;
    }

}

function updateAmountInOrder($orderID, $productID, $newAmount)
{

    require 'db_config.php';

    $db_link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error());

    $query = "UPDATE `orders_content` SET  `amount` =  " . mysqli_escape_string($db_link, $newAmount) . " WHERE `orders_content`.`order_id` = " . mysqli_escape_string($db_link, $orderID) . " AND `orders_content`.`product_id` = " . mysqli_escape_string($db_link, $productID);

    $result = mysqli_query($db_link, $query);

    if ($result) {
        return true;
    } else {
        return false;
    }

}

function formCategoryTree($productID){

    $categories = array();

    $productInfo = getProcuctById($productID);

    while ($productInfo['parent_id'] !== null) {
        $productInfo = getProcuctById($productInfo['parent_id']);
        array_push($categories, $productInfo['name']);
    }

    return array_reverse($categories);

}

function getProcuctById($productID)
{

    require 'db_config.php';

    $db_link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error());

    mysqli_query($db_link, "SET NAMES utf8");


    $query = "SELECT  `goods`.`name` ,  `goods`.`parent_id`
              FROM  `goods`
              WHERE  `goods`.`product_id` = ".mysqli_escape_string($db_link, $productID);

    $result = mysqli_query($db_link, $query);

    $rows = mysqli_affected_rows($db_link);

    if ($rows > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row;
    } elseif ($rows == 0) {
        return false;
    }

}

?>