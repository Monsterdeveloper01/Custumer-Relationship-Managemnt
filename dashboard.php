<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
// Ambil semua data
$sql  = "SELECT * FROM crm";
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Data user login
$currentUserId = $_SESSION['user']['marketing_id'] ?? null;

// Ambil data berdasarkan user login
$sqlStats = "SELECT status FROM crm WHERE marketing_id = :mid";
$stmtStats = $pdo->prepare($sqlStats);
$stmtStats->execute(['mid' => $currentUserId]);
$userRows = $stmtStats->fetchAll(PDO::FETCH_ASSOC);

// Hitung
$totalCompanies = count($userRows);
$emailCount     = count(array_filter($userRows, fn($r) => $r['status'] === 'emailed'));
$contactedCount = count(array_filter($userRows, fn($r) => $r['status'] === 'contacted'));
$waCount        = count(array_filter($userRows, fn($r) => $r['status'] === 'wa'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CRM Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Header -->
  <?php include("partials/Header.html"); ?>

  <!-- Sidebar -->
  <?php include("partials/sidebar.html"); ?>

  <div class="flex">
    <!-- Main Content -->
    <main id="mainContent" class="flex-1 p-8 transition-all duration-300 ml-0.5">
      <br><br><br>
      <!-- Performance Section -->
      <section class="bg-white shadow-lg rounded-2xl p-6 mb-8">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">📊 Your Performance</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
          <div class="bg-gradient-to-br from-indigo-500 to-indigo-700 text-white p-6 rounded-xl shadow text-center">
            <p class="text-sm opacity-80">Total Perusahaan</p>
            <h3 class="text-3xl font-extrabold mt-2"><?= $totalCompanies ?></h3>
          </div>
          <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white p-6 rounded-xl shadow text-center">
            <p class="text-sm opacity-80">Emailed</p>
            <h3 class="text-3xl font-extrabold mt-2"><?= $emailCount ?></h3>
          </div>
          <div class="bg-gradient-to-br from-green-500 to-green-700 text-white p-6 rounded-xl shadow text-center">
            <p class="text-sm opacity-80">Contacted</p>
            <h3 class="text-3xl font-extrabold mt-2"><?= $contactedCount ?></h3>
          </div>
          <div class="bg-gradient-to-br from-teal-500 to-teal-700 text-white p-6 rounded-xl shadow text-center">
            <p class="text-sm opacity-80">Whatsapp</p>
            <h3 class="text-3xl font-extrabold mt-2"><?= $waCount ?></h3>
          </div>
        </div>
      </section>

      <!-- Table Section -->
      <section class="bg-white shadow-lg rounded-2xl p-6 mb-8">
        <h3 class="text-xl font-semibold mb-4 text-gray-800">🏢 Data Perusahaan</h3>
        <div class="overflow-x-auto rounded-lg border border-gray-200">
          <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
              <tr>
                <th class="px-4 py-3 border">NO.</th>
                <th class="px-4 py-3 border">Company</th>
                <th class="px-4 py-3 border">Company Email</th>
                <th class="px-4 py-3 border">Name Person</th>
                <th class="px-4 py-3 border">Person Email</th>
                <th class="px-4 py-3 border">Phone</th>
                <th class="px-4 py-3 border">Phone 2</th>
                <th class="px-4 py-3 border">Position Title</th>
                <th class="px-4 py-3 border">Position Category</th>
                <th class="px-4 py-3 border">Website</th>
              </tr>
            </thead>
            <tbody class="text-gray-700 divide-y divide-gray-200">
              <?php if (!empty($rows)): ?>
                <?php foreach ($rows as $i => $row): ?>
                  <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 border text-center"><?= $i + 1 ?></td>
                    <td class="px-4 py-3 border"><?= htmlspecialchars($row['company_name']) ?></td>
                    <td class="px-4 py-3 border"><?= htmlspecialchars($row['company_email']) ?></td>
                    <td class="px-4 py-3 border"><?= htmlspecialchars($row['name_person']) ?></td>
                    <td class="px-4 py-3 border"><?= htmlspecialchars($row['person_email']) ?></td>
                    <td class="px-4 py-3 border"><?= htmlspecialchars($row['phone_number']) ?></td>
                    <td class="px-4 py-3 border"><?= htmlspecialchars($row['phone_number2']) ?></td>
                    <td class="px-4 py-3 border"><?= htmlspecialchars($row['contact_person_position_title']) ?></td>
                    <td class="px-4 py-3 border"><?= htmlspecialchars($row['contact_person_position_category']) ?></td>
                    <td class="px-4 py-3 border"><?= htmlspecialchars($row['company_website']) ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="10" class="px-4 py-6 text-center text-gray-400">🚫 Tidak ada data</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </section>

      <!-- Send Email Section -->
      <section class="bg-white shadow-lg rounded-2xl p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">📧 Send Email</h2>
        <div class="space-y-4">
          <div>
            <label class="block mb-1 text-gray-700 font-medium">Select a contact:</label>
            <select id="contactSelect" class="w-full border border-gray-300 rounded-lg px-3 py-2">
              <option value="">-- Pilih Kontak --</option>
              <option value="contact1@example.com">Contact 1</option>
              <option value="contact2@example.com">Contact 2</option>
            </select>
          </div>
          <div>
            <label class="block mb-1 text-gray-700 font-medium">To:</label>
            <input type="email" id="to" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Email tujuan">
          </div>
          <div>
            <label class="block mb-1 text-gray-700 font-medium">Subject:</label>
            <input type="text" id="subject" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Enter subject">
          </div>
          <div>
            <label class="block mb-1 text-gray-700 font-medium">Body:</label>
            <textarea id="body" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Write your message..."></textarea>
          </div>
          <button onclick="sendEmail()" class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition">Send</button>
        </div>
      </section>

    </main>
  </div>

  <!-- Modal Confirm -->
  <div id="confirmModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl p-6 w-96 text-center">
      <h3 class="text-lg font-semibold mb-4">Konfirmasi</h3>
      <p id="confirmText" class="mb-6 text-gray-700"></p>
      <div class="flex justify-center gap-4">
        <button onclick="confirmSend()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Kirim</button>
        <button onclick="closeModal()" class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400">Batal</button>
      </div>
    </div>
  </div>

  <script src="../js/coba.js"></script>
</body>
</html>
