<?php

$link = mysql_connect("localhost", "sei_user", "Us3rS31#01");

if (!$link) {
    die('Could not connect: ' . mysql_error() . ' ' . mysql_errno());
} else {
    echo "connected";
}
