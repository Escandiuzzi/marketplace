<?php

if ($_SESSION['admin'] === TRUE) {
    return true;
} else {
    header("Location: unauthorized.php");
    exit;
}
