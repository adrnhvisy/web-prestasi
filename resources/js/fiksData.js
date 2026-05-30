

// Mencegah double click dan memberi feedback loading
document.querySelector('form').addEventListener('submit', function () {
    let btn = document.getElementById('btnSimpan');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';
});
