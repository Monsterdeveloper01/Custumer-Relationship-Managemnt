<?php
require_once 'db.php';
session_start();

// Cek user login
$marketingId = $_SESSION['user']['marketing_id'] ?? null;
if (!$marketingId) {
    die("Unauthorized: Anda harus login sebagai marketing.");
}

// Ambil email dari query string
if (!isset($_GET['email']) || empty($_GET['email'])) {
    $_SESSION['toast'] = "Email tidak valid!";
    header("Location: contact_list.php");
    exit;
}

$companyEmail = trim($_GET['email']); // trim biar ga ada spasi tersembunyi

// Eksekusi DELETE dengan filter marketing_id
$sql = "DELETE FROM crm WHERE company_email = :email AND marketing_id = :marketing_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':email' => $companyEmail,
    ':marketing_id' => $marketingId
]);

if ($stmt->rowCount() > 0) {
    $_SESSION['toast'] = "✅ Kontak berhasil dihapus!";
} else {
    // Debug opsional → cek apakah email ada tapi marketing_id beda
    $check = $pdo->prepare("SELECT marketing_id FROM crm WHERE company_email = :email");
    $check->execute([':email' => $companyEmail]);
    $row = $check->fetch();

    if ($row) {
        $_SESSION['toast'] = "❌ Gagal menghapus: kontak ini milik marketing_id lain (" . $row['marketing_id'] . ")";
    } else {
        $_SESSION['toast'] = "❌ Gagal menghapus: kontak tidak ditemukan.";
    }
}

// Balik ke contact list
header("Location: contact_list.php");
exit;
