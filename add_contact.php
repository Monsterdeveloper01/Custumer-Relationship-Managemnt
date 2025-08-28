<?php
// add_contact.php
require_once 'db.php';
require_once 'functions.php';
require_login();
$mid = current_marketing_id();
$mpname = $_SESSION['user']['name'];

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'company_email' => trim($_POST['company_email'] ?? ''),
        'contact_person_email' => trim($_POST['contact_person_email'] ?? ''),
        'company_name' => trim($_POST['company_name'] ?? ''),
        'contact_person' => trim($_POST['contact_person'] ?? ''),
        'contact_person_position_title' => trim($_POST['contact_person_position_title'] ?? ''),
        'phone_wa' => trim($_POST['phone_wa'] ?? ''),
        'company_website' => trim($_POST['company_website'] ?? ''),
        'company_category' => trim($_POST['company_category'] ?? ''),
        'contact_person_position_category' => trim($_POST['contact_person_position_category'] ?? ''),
        'company_industry_type' => trim($_POST['company_industry_type'] ?? ''),
        'address' => trim($_POST['address'] ?? ''),
        'city' => trim($_POST['city'] ?? ''),
        'postcode' => trim($_POST['postcode'] ?? ''),
        'status' => $_POST['status'] ?? 'input'
    ];
    if (!filter_var($data['company_email'], FILTER_VALIDATE_EMAIL)) $errors[] = "Company email tidak valid.";
    if ($data['company_name'] === '') $errors[] = "Company name wajib diisi.";

    if (empty($errors)) {
        // cek existing PK
        $stmt = $pdo->prepare("SELECT 1 FROM crm WHERE company_email = ?");
        $stmt->execute([$data['company_email']]);
        if ($stmt->fetch()) {
            $errors[] = "Company email sudah terdaftar.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO crm (
                company_email, marketing_id, marketing_person_name, contact_person_email,
                company_name, contact_person, contact_person_position_title, phone_wa,
                company_website, company_category, contact_person_position_category,
                company_industry_type, address, city, postcode, status
            ) VALUES (
                :company_email, :marketing_id, :marketing_person_name, :contact_person_email,
                :company_name, :contact_person, :contact_person_position_title, :phone_wa,
                :company_website, :company_category, :contact_person_position_category,
                :company_industry_type, :address, :city, :postcode, :status
            )");
            $params = $data + ['marketing_id'=>$mid, 'marketing_person_name'=>$mpname];
            $stmt->execute($params);
            header('Location: dashboard.php');
            exit;
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Add Contact | CRM</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Tailwind CDN -->
  <link href="css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6">

  <div class="w-full max-w-4xl bg-white rounded-2xl shadow-lg p-8">
    <h2 class="text-2xl font-bold text-blue-700 mb-6">Tambah Kontak Baru</h2>

    <?php if($errors): ?>
      <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
        <ul class="list-disc list-inside text-sm">
          <?php foreach($errors as $e): ?>
            <li><?=h($e)?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="post" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
      <div>
        <label class="block text-sm font-medium text-gray-700">Company Email (unique)</label>
        <input name="company_email" value="<?=h($_POST['company_email'] ?? '')?>" type="email"
          class="mt-1 w-full px-3 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Contact Person Email</label>
        <input name="contact_person_email" value="<?=h($_POST['contact_person_email'] ?? '')?>" type="email"
          class="mt-1 w-full px-3 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Company Name</label>
        <input name="company_name" value="<?=h($_POST['company_name'] ?? '')?>"
          class="mt-1 w-full px-3 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Contact Person</label>
        <input name="contact_person" value="<?=h($_POST['contact_person'] ?? '')?>"
          class="mt-1 w-full px-3 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Position Title</label>
        <input name="contact_person_position_title" value="<?=h($_POST['contact_person_position_title'] ?? '')?>"
          class="mt-1 w-full px-3 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Phone WA</label>
        <input name="phone_wa" value="<?=h($_POST['phone_wa'] ?? '')?>"
          class="mt-1 w-full px-3 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Website</label>
        <input name="company_website" value="<?=h($_POST['company_website'] ?? '')?>"
          class="mt-1 w-full px-3 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Company Category</label>
        <input name="company_category" value="<?=h($_POST['company_category'] ?? '')?>"
          class="mt-1 w-full px-3 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Position Category</label>
        <input name="contact_person_position_category" value="<?=h($_POST['contact_person_position_category'] ?? '')?>"
          class="mt-1 w-full px-3 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Industry Type</label>
        <input name="company_industry_type" value="<?=h($_POST['company_industry_type'] ?? '')?>"
          class="mt-1 w-full px-3 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Address</label>
        <textarea name="address" rows="3"
          class="mt-1 w-full px-3 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"><?=h($_POST['address'] ?? '')?></textarea>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">City</label>
        <input name="city" value="<?=h($_POST['city'] ?? '')?>"
          class="mt-1 w-full px-3 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Postcode</label>
        <input name="postcode" value="<?=h($_POST['postcode'] ?? '')?>"
          class="mt-1 w-full px-3 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Status</label>
        <select name="status"
          class="mt-1 w-full px-3 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          <?php foreach(['input','wa','emailed','contacted','replied','presentation','CLIENT'] as $s): ?>
            <option value="<?=h($s)?>" <?= (($_POST['status'] ?? '')==$s)?'selected':'' ?>><?=h($s)?></option>
          <?php endforeach; ?>
        </select>
      </div>
          <div class="mt-6 flex justify-between items-center">
      <a href="dashboard.php" class="text-gray-600 hover:underline text-sm">← Back</a>
      <button type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold shadow">
        Save
      </button>
    </div>
  </div>

    </form>


</body>
</html>
