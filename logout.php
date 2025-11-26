<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
unset($_SESSION['curtain_ok']);
header('Location: index.php');
exit;
