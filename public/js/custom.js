// Script konfirmasi sebelum delete

function confirmDelete() {
    Swal.fire({
        title: 'Anda yakin ingin menghapus data ini?',
        text: 'Data yang sudah terhapus tidak bisa dipulihkan kembali',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete_form').submit();
        }
    });
}