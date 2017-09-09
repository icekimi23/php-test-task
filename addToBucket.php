<?php
error_reporting(0);

require 'db_functions.php';

    $userID = $_COOKIE['userID'];

    if (isset($userID)) {

        $orderID = getOrderID($userID);
        if ($orderID) {

            $productID = $_POST['id'];
            $amount = $_POST['amount'];

            if (isset($productID) && isset($amount)){
                if ($amount <= 0){
                    $amount = 1;
                }

                $newContentID = addProductToOrder($orderID, $productID, $amount);

                if ($newContentID) {
                    echo $newContentID;
                } else {
                    echo false;
                }
            }


        }

    }

?>