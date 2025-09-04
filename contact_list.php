<?php
require_once 'db.php';
require_once 'functions.php';
session_start(); // pastikan session aktif

// Ambil marketing_id dari user login
$marketingId = $_SESSION['user']['marketing_id'] ?? null;
if (!$marketingId) {
    die("Unauthorized: Anda harus login sebagai marketing.");
}

// Pagination
$limit = 5;
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Hitung total data (khusus marketing_id yang login)
$stmtTotal = $pdo->prepare("SELECT COUNT(*) AS total FROM crm WHERE marketing_id = :marketing_id");
$stmtTotal->execute(['marketing_id' => $marketingId]);
$total = $stmtTotal->fetch()['total'];
$pages = ceil($total / $limit);

// Ambil data sesuai marketing_id
$sql = "SELECT * FROM crm WHERE marketing_id = :marketing_id LIMIT :start, :limit";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':marketing_id', $marketingId, PDO::PARAM_STR); // pakai STR, bukan INT
$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetchAll();


// Jika ada email (Edit mode) — tetap filter biar aman
$editData = null;
if (isset($_GET['email'])) {
    $stmtEdit = $pdo->prepare("SELECT * FROM crm WHERE company_email = :email AND marketing_id = :marketing_id");
    $stmtEdit->execute([
        'email' => $_GET['email'],
        'marketing_id' => $marketingId
    ]);
    $editData = $stmtEdit->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contact List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<script>
function confirmDelete(email) {
  Swal.fire({
    title: 'Yakin hapus kontak ini?',
    text: "Data akan terhapus permanen!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "delete_contact.php?email=" + encodeURIComponent(email);
    }
  });
}
</script>
<body class="bg-gray-50 min-h-screen" x-data="{ sidebarOpen: false }">
    <!-- Header -->
    <?php include("partials/Header.html"); ?>

    <!-- Sidebar -->
    <?php include("partials/sidebar.html"); ?>

    <!-- Konten utama -->
    <div class="pt-32 container mx-auto p-6">
        <!-- form & table kamu tetap di sini -->

        <!-- Input / Edit Form -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-lg font-semibold mb-4">
                <?= $editData ? "Edit Contact" : "Add New Contact" ?>
            </h2>

            <form action="<?= $editData ? 'update_contact.php' : 'save_contact.php' ?>" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <?php if ($editData): ?>
                    <input type="hidden" name="company_email" value="<?= h($editData['company_email']); ?>">
                <?php endif; ?>

                <input type="text" name="company_name" placeholder="Company Name"
                    value="<?= $editData ? h($editData['company_name']) : '' ?>"
                    class="border rounded-lg p-2 w-full" required>

                <input type="text" name="contact_person" placeholder="Contact Person"
                    value="<?= $editData ? h($editData['contact_person']) : '' ?>"
                    class="border rounded-lg p-2 w-full" required>

                <input type="email" name="company_email" placeholder="Company Email"
                    value="<?= $editData ? h($editData['company_email']) : '' ?>"
                    class="border rounded-lg p-2 w-full" required>

                <input type="email" name="contact_person_email" placeholder="Contact Person Email"
                    value="<?= $editData ? h($editData['contact_person_email']) : '' ?>"
                    class="border rounded-lg p-2 w-full">

                <input type="text" name="phone_wa" placeholder="WhatsApp"
                    value="<?= $editData ? h($editData['phone_wa']) : '' ?>"
                    class="border rounded-lg p-2 w-full">

                <input type="text" name="contact_person_position_title" placeholder="Position Title"
                    value="<?= $editData ? h($editData['contact_person_position_title']) : '' ?>"
                    class="border rounded-lg p-2 w-full">

                <input type="text" name="company_website" placeholder="Company Website"
                    value="<?= $editData ? h($editData['company_website']) : '' ?>"
                    class="border rounded-lg p-2 w-full">

                <input type="text" name="company_category" placeholder="Company Category"
                    value="<?= $editData ? h($editData['company_category']) : '' ?>"
                    class="border rounded-lg p-2 w-full">

                <input type="text" name="contact_person_position_category" placeholder="Position Category"
                    value="<?= $editData ? h($editData['contact_person_position_category']) : '' ?>"
                    class="border rounded-lg p-2 w-full">

                <input type="text" name="company_industry_type" placeholder="Industry Type"
                    value="<?= $editData ? h($editData['company_industry_type']) : '' ?>"
                    class="border rounded-lg p-2 w-full">

                <input type="text" name="address" placeholder="Address"
                    value="<?= $editData ? h($editData['address']) : '' ?>"
                    class="border rounded-lg p-2 w-full">

                <input type="text" name="city" placeholder="City"
                    value="<?= $editData ? h($editData['city']) : '' ?>"
                    class="border rounded-lg p-2 w-full">

                <input type="text" name="postcode" placeholder="Postcode"
                    value="<?= $editData ? h($editData['postcode']) : '' ?>"
                    class="border rounded-lg p-2 w-full">

                <select name="status" class="border rounded-lg p-2 w-full" required>
                    <?php
                    $statuses = ["-- Pilih Status --", "input", "wa", "emailed", "contacted", "replied", "presentation", "client"];
                    foreach ($statuses as $s):
                        $selected = ($editData && $editData['status'] == $s) ? "selected" : "";
                        echo "<option value='$s' $selected>" . ucfirst($s) . "</option>";
                    endforeach;
                    ?>
                </select>

                <button type="submit" class="col-span-1 md:col-span-4 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    <?= $editData ? "Update Contact" : "Add Contact" ?>
                </button>
            </form>
        </div>


        <!-- Table -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold mb-4">All Contacts</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="py-2 px-4 border">#</th>
                            <th class="py-2 px-4 border">Company</th>
                            <th class="py-2 px-4 border">Contact Person</th>
                            <th class="py-2 px-4 border">Company Email</th>
                            <th class="py-2 px-4 border">Contact Person Email</th>
                            <th class="py-2 px-4 border">WhatsApp</th>
                            <th class="py-2 px-4 border">Position Title</th>
                            <th class="py-2 px-4 border">Company Website</th>
                            <th class="py-2 px-4 border">Company Category</th>
                            <th class="py-2 px-4 border">Position Category</th>
                            <th class="py-2 px-4 border">Industry Type</th>
                            <th class="py-2 px-4 border">Address</th>
                            <th class="py-2 px-4 border">City</th>
                            <th class="py-2 px-4 border">Postcode</th>
                            <th class="py-2 px-4 border">Status</th>
                            <th class="py-2 px-4 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = $start + 1;
                        foreach ($data as $row): ?>
                            <tr class="text-center">
                                <td class="py-2 px-4 border"><?= $no++; ?></td>
                                <td class="py-2 px-4 border"><?= h($row['company_name']); ?></td>
                                <td class="py-2 px-4 border"><?= h($row['contact_person']); ?></td>
                                <td class="py-2 px-4 border"><?= h($row['company_email']); ?></td>
                                <td class="py-2 px-4 border"><?= h($row['contact_person_email']); ?></td>
                                <td class="py-2 px-4 border"><?= h($row['phone_wa']); ?></td>
                                <td class="py-2 px-4 border"><?= h($row['contact_person_position_title']); ?></td>
                                <td class="py-2 px-4 border"><?= h($row['company_website']); ?></td>
                                <td class="py-2 px-4 border"><?= h($row['company_category']); ?></td>
                                <td class="py-2 px-4 border"><?= h($row['contact_person_position_category']); ?></td>
                                <td class="py-2 px-4 border"><?= h($row['company_industry_type']); ?></td>
                                <td class="py-2 px-4 border"><?= h($row['address']); ?></td>
                                <td class="py-2 px-4 border"><?= h($row['city']); ?></td>
                                <td class="py-2 px-4 border"><?= h($row['postcode']); ?></td>
                                <td class="py-2 px-4 border"><?= h($row['status']); ?></td>
                                <td class="py-2 px-4 border">
                                    <a href="contact_list.php?email=<?= urlencode($row['company_email']); ?>"
                                        class="text-blue-600 hover:underline">Edit</a>
                                    <a href="javascript:void(0);"
                                        onclick="confirmDelete('<?= urlencode($row['company_email']); ?>')"
                                        class="text-red-600 hover:underline">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-between items-center mt-4">
                <p class="text-sm text-gray-600">
                    Showing <?= $start + 1; ?> to <?= min($start + $limit, $total); ?> of <?= $total; ?> contacts
                </p>
                <div class="flex space-x-2">
                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <a href="?page=<?= $i; ?>"
                            class="px-3 py-1 border rounded-lg <?= ($i == $page) ? 'bg-blue-600 text-white' : 'hover:bg-gray-100'; ?>">
                            <?= $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
<?php if (isset($_SESSION['toast'])): ?>
<script>
Swal.fire({
  toast: true,
  position: 'top-end',
  icon: 'success',
  title: '<?= $_SESSION['toast']; ?>',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true
});
</script>
<?php unset($_SESSION['toast']); endif; ?>

</body>

</html>