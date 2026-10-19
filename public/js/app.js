// Interaksi ringan: menu mobile, tutup notifikasi, preview foto, penghitung karakter,
// cegah kirim ganda, konfirmasi hapus, dan isi akun demo di halaman login
(function () {
    var body = document.body;

    var menuBtn = document.getElementById('menuBtn');
    var overlay = document.getElementById('overlay');
    if (menuBtn) menuBtn.addEventListener('click', function () { body.classList.toggle('sidebar-open'); });
    if (overlay) overlay.addEventListener('click', function () { body.classList.remove('sidebar-open'); });

    document.querySelectorAll('.alert-close').forEach(function (btn) {
        btn.addEventListener('click', function () { btn.closest('.alert').remove(); });
    });
    var sukses = document.querySelector('.alert-success');
    if (sukses) setTimeout(function () { if (sukses.parentNode) sukses.remove(); }, 6000);

    var foto = document.getElementById('foto');
    var preview = document.getElementById('foto-preview');
    if (foto && preview) {
        foto.addEventListener('change', function () {
            var file = foto.files[0];
            if (!file) { preview.hidden = true; return; }
            preview.src = URL.createObjectURL(file);
            preview.hidden = false;
        });
    }

    var desc = document.getElementById('description');
    var count = document.getElementById('desc-count');
    if (desc && count) {
        var update = function () { count.textContent = desc.value.length; };
        desc.addEventListener('input', update);
        update();
    }

    // Konfirmasi sebelum menghapus: <form data-confirm="Pesan...">
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!confirm(form.getAttribute('data-confirm'))) e.preventDefault();
        });
    });

    // Cegah klik ganda saat mengirim form: <form data-loading>
    document.querySelectorAll('form[data-loading]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (e.defaultPrevented) return;
            var btn = form.querySelector('button[type="submit"]');
            if (btn) { btn.disabled = true; btn.textContent = 'Memproses...'; }
        });
    });

    // Halaman login: klik akun demo untuk mengisi email, password, dan peran
    document.querySelectorAll('[data-fill-email]').forEach(function (el) {
        el.addEventListener('click', function () {
            var email = document.getElementById('email');
            var pass = document.getElementById('password');
            if (email) email.value = el.getAttribute('data-fill-email');
            if (pass) pass.value = 'password';
            var peran = document.querySelector('input[name="peran"][value="' + el.getAttribute('data-fill-peran') + '"]');
            if (peran) peran.checked = true;
        });
    });
})();
