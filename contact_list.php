<?php
require_once 'db.php';
require_once 'functions.php';
require_login();
$mid = current_marketing_id();

$stmt = $pdo->prepare("SELECT company_email, company_name FROM crm WHERE marketing_id = :mid");
$stmt->execute(['mid' => $mid]);
$contacts = $stmt->fetchAll();
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Contact List</title>
  <link href="css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">

<!-- Navbar copy dari dashboard -->
<header class="bg-white text-black shadow-md">
  <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
    <div class="flex flex-col items-start">
      <img src="img/rayterton-apps-software-logo.png" style="width:125px;height:45px;">
      <h1 class="text-xl font-semibold tracking-wide text-indigo-600">Contact List</h1>
    </div>
    <div class="text-sm">
      Halo, <strong><?=h($_SESSION['user']['name'])?></strong>
    </div>
  </div>
</header>

<main class="max-w-3xl mx-auto px-4 py-6">
  <h2 class="text-lg font-bold mb-4">Send Email</h2>
  <form action="send_email.php" method="post" onsubmit="return confirmSend()" class="bg-white p-6 rounded-lg shadow space-y-4">
    <div>
      <label class="block text-sm font-medium">Pilih Kontak</label>
      <select name="to" id="contact" class="w-full border rounded px-3 py-2" required>
        <option value="">-- Pilih Kontak --</option>
        <?php foreach($contacts as $c): ?>
          <option value="<?=h($c['company_email'])?>">
            <?=h($c['company_name'])?> (<?=h($c['company_email'])?>)
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium">Subject</label>
      <input type="text" name="subject" class="w-full border rounded px-3 py-2" required>
    </div>

    <div>
      <label class="block text-sm font-medium">Body</label>
      <textarea name="body" rows="5" class="w-full border rounded px-3 py-2" required></textarea>
    </div>

    <div class="flex space-x-3">
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Kirim</button>
      <button type="reset" class="bg-gray-400 text-white px-4 py-2 rounded">Batal</button>
    </div>
  </form>
</main>

<script>
function confirmSend(){
  let select = document.getElementById('contact');
  let contact = select.options[select.selectedIndex].text;
  return confirm("Yakin mengirim email ke " + contact + "?");
}
</script>

</body>
</html>
