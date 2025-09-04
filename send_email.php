<?php
require_once 'db.php';
require_once 'functions.php';
require_login();

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

$mid             = current_marketing_id();
$marketing_name  = $_SESSION['user']['name'];
$marketing_email = $_SESSION['user']['email'];

$company_email = $_GET['email'] ?? '';
if (!$company_email) { 
    header('Location: dashboard.php'); 
    exit; 
}

// ambil data contact & cek kepemilikan
$stmt = $pdo->prepare("SELECT * FROM crm WHERE company_email = ? AND marketing_id = ?");
$stmt->execute([$company_email, $mid]);
$data = $stmt->fetch();
if (!$data) { 
    die("Data tidak ditemukan atau akses ditolak."); 
}

// ==========================
// Default Template Email
// ==========================
$default_subject = "Kesempatan Kerja Sama antara PT Rayterton Indonesia & {$data['company_name']}";
$default_body    = "Halo ".($data['name_person'] ?: $data['company_name']).",\n\n"
    . "Perkenalkan, saya {$marketing_name} dari PT Rayterton Indonesia. "
    . "Saya menghubungi Bapak/Ibu karena melihat ada potensi kerja sama yang baik "
    . "antara PT Rayterton Indonesia dan {$data['company_name']}.\n\n"
    . "Kami yakin, dengan pengalaman serta layanan yang kami miliki, "
    . "kolaborasi ini bisa membawa manfaat bagi kedua belah pihak.\n\n"
    . "Apakah Bapak/Ibu berkenan meluangkan waktu untuk diskusi singkat minggu ini? "
    . "Saya bisa menyesuaikan jadwal sesuai waktu yang nyaman bagi Bapak/Ibu.\n\n"
    . "Terima kasih atas perhatian Bapak/Ibu.\n"
    . "Saya berharap kita bisa segera berdiskusi lebih lanjut.\n\n"
    . "Salam hangat,\n"
    . "{$marketing_name}\n"
    . "[Posisi]\n"
    . "[Telepon/WA]\n";

$info = '';

// ==========================
// Proses Kirim Email
// ==========================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to      = $_POST['to'] ?? $company_email;
    $subject = trim($_POST['subject'] ?? $default_subject);
    $body    = trim($_POST['body'] ?? $default_body);

    $mail = new PHPMailer(true);
    try {
        // ==========================
        // KONFIGURASI SMTP
        // ==========================

        $mail->isSMTP();
        
        // --- PAKAI GMAIL (butuh App Password) ---
        /*
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'marketing@rayterton.com';
        $mail->Password   = 'APP_PASSWORD_GMAIL';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        */

        // --- PAKAI SMTP MAIL SERVER PERUSAHAAN (cPanel/Plesk) ---
        $mail->Host       = 'mail.rayterton.com'; // ubah sesuai mail server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'marketing@rayterton.com';
        $mail->Password   = 'PASSWORD_EMAIL'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SSL
        $mail->Port       = 465; // atau 587 (STARTTLS) jika server mendukung

        // ==========================
        // IDENTITAS EMAIL
        // ==========================
        $mail->setFrom('marketing@rayterton.com', "CRM - {$marketing_name}");
        $mail->addAddress($to);

        // supaya klien balas ke email marketing masing-masing
        if ($marketing_email) {
            $mail->addReplyTo($marketing_email, $marketing_name);
        }

        // ==========================
        // KONTEN EMAIL
        // ==========================
        $mail->isHTML(false); // plain text
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();

        // update status di database
        $stmt = $pdo->prepare("UPDATE crm SET status = 'emailed', updated_at = NOW() WHERE company_email = ? AND marketing_id = ?");
        $stmt->execute([$company_email, $mid]);

        $info = "✅ Email berhasil dikirim ke {$to}. Status diupdate menjadi 'emailed'.";
    } catch (Exception $e) {
        $info = "❌ Gagal mengirim email. Error: {$mail->ErrorInfo}";
    }
}
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Send Email | CRM</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6">
  <div class="w-full max-w-3xl bg-white shadow-lg rounded-2xl p-8">
    <h2 class="text-2xl font-bold text-blue-700 mb-6">Send Email ke <?=h($data['company_name'])?></h2>

    <?php if ($info): ?>
      <div class="mb-4 p-4 rounded-lg <?=strpos($info, 'berhasil') !== false ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'?>">
        <?=h($info)?>
      </div>
    <?php endif; ?>

    <form method="post" class="space-y-5">
      <div>
        <label class="block text-sm font-medium text-gray-700">To</label>
        <input type="email" name="to"
          value="<?=h($data['person_email'] ?: $data['company_email'])?>"
          class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Subject</label>
        <input type="text" name="subject"
          value="<?=h($_POST['subject'] ?? $default_subject)?>"
          class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Body</label>
        <textarea name="body" rows="12"
          class="w-full mt-1 p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 font-mono text-sm"><?=h($_POST['body'] ?? $default_body)?></textarea>
      </div>

      <div class="flex gap-3">
        <button type="submit"
          class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold shadow">
          Send Email
        </button>
        <a href="dashboard.php"
          class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg font-semibold shadow">
          Back
        </a>
      </div>
    </form>
  </div>
</body>
</html>
