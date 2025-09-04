<?php
// dashboard.php
require_once 'db.php';
require_once 'functions.php';
require_login();
$mid = current_marketing_id();

// pencarian sederhana & filter status
$q = $_GET['q'] ?? '';
$status = $_GET['status'] ?? '';

$sql = "SELECT * FROM crm WHERE marketing_id = :mid";
$params = ['mid' => $mid];

if ($q !== '') {
    $sql .= " AND (company_name LIKE :q OR company_email LIKE :q OR contact_person LIKE :q)";
    $params['q'] = '%'.$q.'%';
}
if ($status !== '') {
    $sql .= " AND status = :status";
    $params['status'] = $status;
}
$sql .= " ORDER BY updated_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Dashboard CRM</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Tailwind via CDN -->
  <link href="css/output.css" rel="stylesheet">
  <!-- Alpine.js -->
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50 min-h-screen" x-data="{ sidebarOpen: false }">

  <!-- Navbar -->
    <?php include("partials/Header.html"); ?>

  <!-- Sidebar -->

  <!-- Konten Utama -->
  <main class="max-w-6xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-xl font-bold text-gray-700">Data Kontak</h2>
      <a href="add_contact.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow">
        + Add Contact
      </a>
    </div>

    <!-- (filter form dan tabel tetap sama) -->
    <form method="get" class="bg-white p-4 rounded-lg shadow mb-6 flex flex-col sm:flex-row gap-4 sm:items-end">
      <div class="flex-1">
        <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
        <input name="q" placeholder="Nama / Email / Contact" value="<?=h($q)?>"
          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <select name="status"
          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          <option value="">-- semua status --</option>
          <?php
          $statuses = ['input','wa','emailed','contacted','replied','presentation','CLIENT'];
          foreach($statuses as $s) {
              $sel = $s === $status ? 'selected' : '';
              echo "<option value=\"".h($s)."\" $sel>".h(ucfirst($s))."</option>";
          }
          ?>
        </select>
      </div>
      <div>
        <button class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
          Filter
        </button>
      </div>
    </form>

    <!-- Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left font-medium text-gray-600">Company</th>
            <th class="px-4 py-2 text-left font-medium text-gray-600">Contact</th>
            <th class="px-4 py-2 text-left font-medium text-gray-600">WA</th>
            <th class="px-4 py-2 text-left font-medium text-gray-600">Status</th>
            <th class="px-4 py-2 text-left font-medium text-gray-600">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
        <?php if (!$rows): ?>
          <tr>
            <td colspan="5" class="px-4 py-3 text-center text-gray-500">Tidak ada data</td>
          </tr>
        <?php endif; ?>
        <?php foreach($rows as $r): ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-3">
              <div class="font-medium text-gray-800"><?=h($r['company_name'])?></div>
              <div class="text-gray-500 text-xs"><?=h($r['company_email'])?></div>
            </td>
            <td class="px-4 py-3">
              <div><?=h($r['contact_person'])?></div>
              <div class="text-gray-500 text-xs"><?=h($r['contact_person_position_title'])?></div>
            </td>
            <td class="px-4 py-3"><?=h($r['phone_wa'])?></td>
            <td class="px-4 py-3">
              <span class="px-2 py-1 rounded-full text-xs font-semibold
                <?= $r['status']==='CLIENT' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' ?>">
                <?=h($r['status'])?>
              </span>
            </td>
            <td class="px-4 py-3 space-x-2">
              <a href="view_contact.php?email=<?=urlencode($r['company_email'])?>" class="text-blue-600 hover:underline">View</a>
              <a href="edit_contact.php?email=<?=urlencode($r['company_email'])?>" class="text-yellow-600 hover:underline">Edit</a>
              <a href="send_email.php?email=<?=urlencode($r['company_email'])?>" class="text-green-600 hover:underline">Send Email</a>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>

