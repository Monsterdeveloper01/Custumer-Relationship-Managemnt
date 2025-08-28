<?php
// functions.php
session_start();

function require_login() {
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit;
    }
}

function current_marketing_id() {
    return $_SESSION['user']['marketing_id'] ?? null;
}

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
?>
