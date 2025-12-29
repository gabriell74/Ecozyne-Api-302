// Script konfirmasi sebelum delete

function confirmDelete(formId) {
    Swal.fire({
        title: 'Anda yakin ingin menghapus data ini?',
        text: 'Data yang sudah terhapus tidak bisa dipulihkan kembali',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}

function confirmAccept(formId) {
    Swal.fire({
        title: 'Anda yakin ingin setujui?',
        text: 'Data yang sudah disetujui tidak bisa diubah kembali',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Ya, setujui!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}

function confirmReject(formId) {
    Swal.fire({
        title: 'Anda yakin ingin menolak?',
        text: 'Data yang sudah ditolak tidak bisa diubah kembali',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, tolak!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}