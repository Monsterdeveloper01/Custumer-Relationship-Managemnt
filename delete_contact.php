<?php
require_once 'db.php';

if (isset($_GET['email'])) {
    $stmt = $pdo->prepare("DELETE FROM crm WHERE company_email = :email");
    $stmt->execute(['email' => $_GET['email']]);
}

header("Location: contact_list.php");
exit;
?>
