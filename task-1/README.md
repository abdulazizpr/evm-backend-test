# Backend Assesment

## Task 1: Online Store

Permasalahan di online store tersebut terjadi kemungkinan stok hanya ada dalam pengecekan ketika masuk ke dalam cart, akan tetapi, ketika dalam proses checkout hingga pembayaran tidak ada pengecekean stock dalam sistem sehingga ketika stok yang ada di sistem tersebut mengakibatkan pengurangan stok hingga stok itu minus atau negatif. Kemungkinan bisa terjadi ketika barang sudah masuk ke dalam cart, produk tersebut stok sudah mulai berkurang dalam sistem secara otomatis, dan ketika memulai proses checkout atapun pembayaran tidak dilakukan checking stock.

Solusi dari permasalahan tersebut perlu dilakukannya dari pertama definisi table product di kolom stock perlu di definisikan di database harus bernilai positif tidak boleh negatif. Kemudian pada pengembangan aplikasi, perlu adanya validasi stok di dalam sistem dengan cara mengecek stok kedalam database lalu tampilkan validasi bahwa stok benar-benar kosong sehingga tidak terjadi. Pengecekan bisa dilakukan ketika user melakukan checkout/pembayaran, jika stok nya tidak tersedia tampilkan validasi untuk meminimalisir penembakan API secara berkala.

Pada simulasi kali ini saya akan mencoba melakukannya ketika checkout dan melakukan pembayaran (dengan simulasi hit endpoint payment) dan setelah pembayaran baru ada pengurangan stok untuk kebutuhan demo ini menggunakan PHPUnit. Untuk simulasi ini di asumsikan 1 checkout dengan 1 barang dan utk pembayaran tersebut dianggap sudah membayar pada simulasi kali ini.

Untuk melakukan demonstrasi ini di lakukan beberapa tahap berikut.
1. create `.env` file (can copy from `.env.example`)
2. Setting database environtment on `env`
3. Run `composer install`
5. Run `php artisan key:generate`
6. Run `php artisan optimize`
7. Run `composer test`

Untuk menjalankan API tersendiri di lakukan beberapa command line berikut.
1. Run `php artisan migrate`
2. Run `php artisan serve`

Untuk mengakses log file bisa dilakukan dengan command.
```console
cat storage/logs/laravel.log
```
