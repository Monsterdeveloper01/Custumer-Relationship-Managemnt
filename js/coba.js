function sendEmail() {
  const contact = document.getElementById("contactSelect").value;
  const to = document.getElementById("to").value;
  if (!contact || !to) {
    alert("Pilih kontak dan isi alamat email tujuan!");
    return;
  }
  const subject = document.getElementById("subject").value;

  document.getElementById(
    "confirmText"
  ).innerText = `Yakin mengirim email ke ${to}? \nSubject: ${subject}`;
  document.getElementById("confirmModal").classList.remove("hidden");
}

function confirmSend() {
  alert("Email berhasil dikirim (dummy)!");
  closeModal();
}

function closeModal() {
  document.getElementById("confirmModal").classList.add("hidden");
}

const sidebar = document.getElementById("sidebar");
const mainContent = document.getElementById('mainContent');
const textEls = document.querySelectorAll(".sidebar-text");

let collapsed = false;
document.getElementById("toggleSidebar").addEventListener("click", () => {
  collapsed = !collapsed;

  if (collapsed) {
     mainContent.classList.replace('ml-0.5', 'ml-0');
    sidebar.classList.replace("w-56", "w-16");
    textEls.forEach((el) => el.classList.add("hidden"));
    // bikin ikon di-center
    document.querySelectorAll("#sidebar a").forEach((el) => {
      el.classList.remove("gap-3", "px-4");
      el.classList.add("justify-center");
    });
  } else {
     mainContent.classList.replace('ml-0', 'ml-0.5');
    sidebar.classList.replace("w-16", "w-56");
    textEls.forEach((el) => el.classList.remove("hidden"));
    // balikin spacing normal
    document.querySelectorAll("#sidebar a").forEach((el) => {
      el.classList.add("gap-3", "px-4");
      el.classList.remove("justify-center");
    });
  }
});
