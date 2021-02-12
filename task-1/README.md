##Task 1: Online Store

Permasalahan di online store tersebut terjadi dikarenakan tidak adanya pengecekean stok di dalam sistem sehingga ketika stok yang ada di sistem tersebut mengakibatkan pengurangan stok hingga stok itu minus atau negatif.

Solusi dari permasalahan tersebut perlu dilakukannya validasi stok di dalam sistem dengan cara mengecek stok kedalam database lalu tampilkan validasi bahwa stok benar-benar kosong sehingga tidak terjadi. Pengecekan bisa dilakukan ketika user mengklik checkout/pembayaran, jika stok nya tidak tersedia tampilkan validasi untuk meminimalisir penembakan API secara berkala.

Pada simulasi kali ini saya akan mencoba melakukannya ketika checkout dan anggap saja pembayaran sudah lunas untuk kebutuhan demo ini menggunakan PHPUnit.

Untuk melakukan demonstrasi ini di lakukan beberapa command line berikut.
1. create .env file (can copy from .env.example)
2. setting database environtment on env
3. composer install
4. php artisan migrate --seed
5. php artisan key:generate
6. php artisan optimize
7. phpunit
