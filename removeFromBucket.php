<?php

    require 'db_functions.php';

    $userID = $_COOKIE['userID'];

    if (isset($userID)) {

        $orderID = getOrderID($userID);

        if ($orderID) {

            $productID = $_POST['id'];

            if (isset($productID)) {
                $result = removeProductFromOrder($orderID, $productID);
                echo $result;
            }

        }

    }

?>