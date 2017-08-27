<?php

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

function createNewOrder($userID)
{

    require 'db_config.php';

    $db_link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error());

    $result = mysqli_query($db_link, "INSERT INTO  `orders` (`order_id`,`user_id`) VALUES (NULL,".mysqli_escape_string($db_link, $userID).")");

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

    $result = mysqli_query($db_link, "SELECT  `orders_content`.`product_id` ,  `goods`.`name` as `product_name`,  `goods`.`image` ,  `goods`.`cost` ,  `producers`.`name` ,  `orders_content`.`amount` 
                                                FROM  `orders_content` 
                                                INNER JOIN  `orders` ON  `orders_content`.`order_id` =  `orders`.`order_id` 
                                                INNER JOIN  `goods` ON  `orders_content`.`product_id` =  `goods`.`product_id` 
                                                INNER JOIN  `producers` ON  `goods`.`producer_id` =  `producers`.`producer_id` 
                                                WHERE  `orders`.`user_id` = " . mysqli_escape_string($db_link, $id));

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

    $query = "SELECT  * 
              FROM  `goods` 
              WHERE  `goods`.`isGroup` = 0" .$cond;

    $result = mysqli_query($db_link, $query);

    $rows = mysqli_affected_rows($db_link);

    if ($rows > 0) {
        return $result;
    } elseif ($rows == 0) {
        return false;
    }
}

function getOrderID($userID){

    require 'db_config.php';

    $db_link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error());

    mysqli_query($db_link, "SET NAMES utf8");

    $result = mysqli_query($db_link, "SELECT `orders`.`order_id` FROM `orders` WHERE `orders`.`user_id` = ".mysqli_escape_string($db_link, $userID));

    $rows = mysqli_affected_rows($db_link);

    if ($rows > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['order_id'];
    } elseif ($rows == 0) {
        return false;
    }

}

function addProductToOrder($orderID, $productID, $amount){

    require 'db_config.php';

    $db_link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error());

    $result = mysqli_query($db_link, "INSERT INTO  `orders_content` (
                                                    `id` ,
                                                    `order_id` ,
                                                    `product_id` ,
                                                    `amount`
                                                    )
                                                    VALUES (
                                                    NULL , ".mysqli_escape_string($db_link, $orderID).",".mysqli_escape_string($db_link, $productID).",".mysqli_escape_string($db_link, $amount)."
                                                    )");

    if ($result) {
        return true;
    } else {
        return false;
    }

}

function removeProductFromOrder($orderID, $productID) {

    require 'db_config.php';

    $db_link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error());

    $query = "DELETE FROM `orders_content` WHERE `orders_content`.`order_id` = ".mysqli_escape_string($db_link, $orderID)." AND `orders_content`.`product_id` = ".mysqli_escape_string($db_link, $productID);

    $result = mysqli_query($db_link, $query);

    if ($result) {
        return true;
    } else {
        return false;
    }

}

function updateAmountInOrder($orderID, $productID, $newAmount){

    require 'db_config.php';

    $db_link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error());

    $query = "UPDATE `orders_content` SET  `amount` =  ".mysqli_escape_string($db_link, $newAmount)." WHERE `orders_content`.`order_id` = ".mysqli_escape_string($db_link, $orderID)." AND `orders_content`.`product_id` = ".mysqli_escape_string($db_link, $productID);

    $result = mysqli_query($db_link, $query);

    if ($result) {
        return true;
    } else {
        return false;
    }

}

?>