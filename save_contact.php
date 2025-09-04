<?php
require_once 'db.php';
require_once 'functions.php';
session_start();

$marketingId = $_SESSION['user']['marketing_id'] ?? null;
if (!$marketingId) {
    die("Unauthorized: Anda harus login sebagai marketing.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "INSERT INTO crm 
            (company_name, contact_person, company_email, contact_person_email, phone_wa, 
             contact_person_position_title, company_website, company_category, 
             contact_person_position_category, company_industry_type, address, city, postcode, status, marketing_id)
            VALUES 
            (:company_name, :contact_person, :company_email, :contact_person_email, :phone_wa,
             :contact_person_position_title, :company_website, :company_category, 
             :contact_person_position_category, :company_industry_type, :address, :city, :postcode, :status, :marketing_id)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'company_name' => $_POST['company_name'],
        'contact_person' => $_POST['contact_person'],
        'company_email' => $_POST['company_email'],
        'contact_person_email' => $_POST['contact_person_email'],
        'phone_wa' => $_POST['phone_wa'],
        'contact_person_position_title' => $_POST['contact_person_position_title'],
        'company_website' => $_POST['company_website'],
        'company_category' => $_POST['company_category'],
        'contact_person_position_category' => $_POST['contact_person_position_category'],
        'company_industry_type' => $_POST['company_industry_type'],
        'address' => $_POST['address'],
        'city' => $_POST['city'],
        'postcode' => $_POST['postcode'],
        'status' => $_POST['status'],
        'marketing_id' => $marketingId
    ]);

    header("Location: contact_list.php");
    exit;
}
?>
