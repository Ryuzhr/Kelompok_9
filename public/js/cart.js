$(document).ready(function() {
    $('.btn-tambah-keranjang').click(function(e) {
        e.preventDefault();

        var productId = $(this).data('product-id');

        $.ajax({
            url: '{{ route("cart.add") }}',
            method: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                'product_id': productId,
                'quantity': 1 // bisa disesuaikan dengan kebutuhan
            },
            success: function(response) {
                alert('Produk berhasil ditambahkan ke keranjang!');
                // Tambahkan logika lain jika diperlukan, misalnya update tampilan keranjang
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Terjadi kesalahan saat menambahkan produk ke keranjang!');
            }
        });
    });
});
