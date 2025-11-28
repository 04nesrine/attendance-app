<?php
require "db_connect.php";

$connection = getConnection();

if ($connection) {
    echo "Connection successful!";
} else {
    echo "Connection failed!";
}
