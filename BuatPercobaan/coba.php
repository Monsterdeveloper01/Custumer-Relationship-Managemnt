<?php
require '../db.php';
require '../functions.php';

// Mengambil Semua Data Dari Database
$sql  = "SELECT * FROM crm";
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mengambil data hanya dari field marketing_id nya saja
$currentUserId = $_SESSION['user']['marketing_id']; // pastikan ini sesuai isi session

// Ambil semua data crm untuk user login
$sqlStats = "SELECT status FROM crm WHERE marketing_id = :mid";
$stmtStats = $pdo->prepare($sqlStats);
$stmtStats->execute(['mid' => $currentUserId]);
$userRows = $stmtStats->fetchAll(PDO::FETCH_ASSOC);

// Hitung
$totalCompanies = count($userRows);
$emailCount     = 0;
$contactedCount = 0;
$waCount        = 0;

foreach ($userRows as $row) {
    if ($row['status'] === 'emailed') {
        $emailCount++;
    } elseif ($row['status'] === 'contacted') {
        $contactedCount++;
    } elseif ($row['status'] === 'wa') {
        $waCount++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CRM Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

    <!-- Topbar -->
    <header class="flex justify-between items-center bg-white shadow px-6 py-4">
        <div class="flex items-center gap-4">
            <!-- Tombol toggle sidebar -->
            <button id="toggleSidebar" class="p-2 rounded-lg bg-gray-200 hover:bg-gray-300">
                ☰
            </button>
            <div>
                <img src="../img/rayterton-apps-software-logo.png" alt="Logo" class="w-13 h-12">
                <p class="text-sm text-gray-600">Customer Relationship Management</p>
            </div>
        </div>

        <div class="flex items-center gap-6">
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-700">Halo,<strong><?= h($_SESSION['user']['name']) ?></strong></span>
            </div>
            <a href="../logout.php"
                class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                Logout
            </a>
        </div>
    </header>

    <div class="flex">

        <aside id="sidebar"
            class="bg-black min-h-screen w-56 transition-all duration-300">
            <nav class="flex flex-col">
                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 text-white hover:bg-blue-700 transition rounded-md">
                    <span class="icon text-xl w-6 text-center">📇</span>
                    <span class="sidebar-text">Contact List</span>
                </a>
            </nav>
        </aside>


        <!-- Main Content -->
        <main id="mainContent" class="flex-1 p-6 transition-all duration-300 ml-0.5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Performance Section -->
                <section class="bg-white shadow rounded-xl p-6">
                    <h2 class="text-xl font-bold mb-4">Your Performance</h2>

                    <!-- Info -->
                    <div class="bg-gray-100 p-4 rounded-lg mb-4">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-white p-4 rounded-lg shadow text-center">
                                <p class="text-gray-500 text-sm">Total Perusahaan</p>
                                <h3 class="text-2xl font-bold text-gray-800"><?= $totalCompanies ?></h3>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow text-center">
                                <p class="text-gray-500 text-sm">Emailed</p>
                                <h3 class="text-2xl font-bold text-blue-600"><?= $emailCount ?></h3>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow text-center">
                                <p class="text-gray-500 text-sm">Contacted</p>
                                <h3 class="text-2xl font-bold text-green-600"><?= $contactedCount ?></h3>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow text-center">
                                <p class="text-gray-500 text-sm">Whatsapp</p>
                                <h3 class="text-2xl font-bold text-teal-600"><?= $waCount ?></h3>
                            </div>
                        </div>

                    </div>

                    <!-- Dummy Table for CRUD -->
                    <div class="overflow-x-auto">
                        <h3 class="text-lg font-semibold mb-2">Data Perusahaan</h3>
                        <table class="w-full border border-gray-300 rounded-lg overflow-hidden text-sm">
                            <thead class="bg-gray-200 text-gray-700">
                                <tr>
                                    <th class="px-3 py-2 border">NO.</th>
                                    <th class="px-3 py-2 border">COMPANY</th>
                                    <th class="px-3 py-2 border">COMPANY EMAIL</th>
                                    <th class="px-3 py-2 border">NAME PERSON</th>
                                    <th class="px-3 py-2 border">PERSON EMAIL</th>
                                    <th class="px-3 py-2 border">NUMBER PHONE</th>
                                    <th class="px-3 py-2 border">NUMBER PHONE 2</th>
                                    <th class="px-3 py-2 border">POSITION TITLE</th>
                                    <th class="px-3 py-2 border">POSITION CATEGORY</th>
                                    <th class="px-3 py-2 border">COMPANY WEBSITE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($rows)): ?>
                                    <?php foreach ($rows as $data => $row): ?>
                                        <tr>
                                            <td class="px-3 py-2 border text-center"><?= $data + 1 ?></td>
                                            <td class="px-3 py-2 border"><?= htmlspecialchars($row['company_name']) ?></td>
                                            <td class="px-3 py-2 border"><?= htmlspecialchars($row['company_email']) ?></td>
                                            <td class="px-3 py-2 border"><?= htmlspecialchars($row['name_person']) ?></td>
                                            <td class="px-3 py-2 border"><?= htmlspecialchars($row['person_email']) ?></td>
                                            <td class="px-3 py-2 border"><?= htmlspecialchars($row['phone_number']) ?></td>
                                            <td class="px-3 py-2 border"><?= htmlspecialchars($row['phone_number2']) ?></td>
                                            <td class="px-3 py-2 border"><?= htmlspecialchars($row['contact_person_position_title']) ?></td>
                                            <td class="px-3 py-2 border"><?= htmlspecialchars($row['contact_person_position_category']) ?></td>
                                            <td class="px-3 py-2 border"><?= htmlspecialchars($row['company_website']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="px-3 py-2 border text-center text-gray-500">Tidak ada data</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Send Email Section -->
                <section class="bg-white shadow rounded-xl p-6">
                    <h2 class="text-xl font-bold mb-4">Send Email</h2>

                    <!-- Select Contact -->
                    <label class="block mb-2 text-gray-700 font-medium">Select a contact:</label>
                    <select id="contactSelect" class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-4">
                        <option value="">-- Pilih Kontak --</option>
                        <option value="contact1@example.com">Contact 1</option>
                        <option value="contact2@example.com">Contact 2</option>
                    </select>

                    <!-- To Field -->
                    <label class="block mb-2 text-gray-700 font-medium">To:</label>
                    <input type="email" id="to" class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-4" placeholder="Email tujuan">

                    <!-- Email Form -->
                    <label class="block mb-2 text-gray-700 font-medium">Subject:</label>
                    <input type="text" id="subject" class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-4" placeholder="Enter subject">

                    <label class="block mb-2 text-gray-700 font-medium">Body:</label>
                    <textarea id="body" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-4" placeholder="Write your message..."></textarea>

                    <button onclick="sendEmail()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Send</button>
                </section>

            </div>
        </main>
    </div>

    <!-- Modal Confirm -->
    <div id="confirmModal" class="fixed inset-0 hidden bg-black bg-opacity-40 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-lg p-6 w-96 text-center">
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