<?php
require_once 'db.php';
require_once 'functions.php';

// cek method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ambil data dari form
    $data = [
        'company_name'                   => $_POST['company_name'] ?? '',
        'contact_person'                 => $_POST['contact_person'] ?? '',
        'company_email'                  => $_POST['company_email'] ?? '',
        'contact_person_email'           => $_POST['contact_person_email'] ?? '',
        'phone_wa'                       => $_POST['phone_wa'] ?? '',
        'contact_person_position_title'  => $_POST['contact_person_position_title'] ?? '',
        'company_website'                => $_POST['company_website'] ?? '',
        'company_category'               => $_POST['company_category'] ?? '',
        'contact_person_position_category'=> $_POST['contact_person_position_category'] ?? '',
        'company_industry_type'          => $_POST['company_industry_type'] ?? '',
        'address'                        => $_POST['address'] ?? '',
        'city'                           => $_POST['city'] ?? '',
        'postcode'                       => $_POST['postcode'] ?? '',
        'status'                         => $_POST['status'] ?? '',
        'marketing_id'                   => current_marketing_id() // dari session
    ];

    try {
        $sql = "INSERT INTO crm 
            (company_name, contact_person, company_email, contact_person_email, phone_wa, 
             contact_person_position_title, company_website, company_category, 
             contact_person_position_category, company_industry_type, address, city, postcode, 
             status, marketing_id) 
            VALUES 
            (:company_name, :contact_person, :company_email, :contact_person_email, :phone_wa, 
             :contact_person_position_title, :company_website, :company_category, 
             :contact_person_position_category, :company_industry_type, :address, :city, :postcode, 
             :status, :marketing_id)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

        // setelah insert balik ke index.php
        header("Location: contact_list.php?msg=success");
        exit;

    } catch (PDOException $e) {
        die("Error insert: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
    exit;
}
