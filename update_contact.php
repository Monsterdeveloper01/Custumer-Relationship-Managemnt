<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_email = $_POST['company_email']; // kunci utama
    $stmt = $pdo->prepare("
        UPDATE crm SET
          company_name = :company_name,
          contact_person = :contact_person,
          contact_person_email = :contact_person_email,
          phone_wa = :phone_wa,
          contact_person_position_title = :contact_person_position_title,
          company_website = :company_website,
          company_category = :company_category,
          contact_person_position_category = :contact_person_position_category,
          company_industry_type = :company_industry_type,
          address = :address,
          city = :city,
          postcode = :postcode,
          status = :status
        WHERE company_email = :company_email
    ");
    
    $stmt->execute([
        'company_name' => $_POST['company_name'],
        'contact_person' => $_POST['contact_person'],
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
        'company_email' => $company_email
    ]);

    header("Location: contact_list.php");
    exit;
}
?>
