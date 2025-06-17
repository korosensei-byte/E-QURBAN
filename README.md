# 🔐 CI4 Login App with Myth-Auth

Proyek ini dibangun menggunakan **CodeIgniter 4** dan menggunakan library **Myth:Auth** untuk manajemen autentikasi.  
Status: 🚧 **Masih dalam tahap pengembangan**

---

## ⚙️ Konfigurasi SESSION

Lokasi penyimpanan session berada di:

C:/xampp/tmp

Pastikan Anda telah mengatur file berikut:

- `app/Config/App.php`
- `app/Config/Session.php`

Contoh konfigurasi:

```php
public string $sessionSavePath = 'C:\xampp\tmp';

Ubah konfigurasi .env sesuai kebutuhan Anda, khususnya untuk koneksi database dan port server. Contoh default:

database.default.hostname = 127.0.0.1
database.default.database = ci4login
