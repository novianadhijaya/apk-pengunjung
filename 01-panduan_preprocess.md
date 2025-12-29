Panduan Menu Preprocess
=======================

Lokasi menu
-----------
- URL: http://localhost/app_pengunjung/index.php/Preprocess
- Controller: `application/controllers/Preprocess.php`
- View: `application/views/preprocess/index.php`

Tujuan
------
Menu Preprocess dipakai untuk mengubah data kunjungan mentah (tabel `visits`)
menjadi agregasi bulanan (tabel `monthly_visits`) agar siap dipakai regresi.

Alur pengguna di halaman
------------------------
1) Buka menu Preprocess.
2) Klik tombol "Proses Preprocessing" dan konfirmasi.
3) Sistem menampilkan pesan "Preprocessing selesai."
4) Tabel "Hasil Preprocessing" menampilkan data hasil agregasi bulanan:
   - Tahun
   - Bulan
   - X (Periode)
   - Y (Jumlah)

Algoritma program (ringkas namun rinci)
---------------------------------------
Fungsi utama ada di `Preprocess::run()` dan memanggil
`Visit_model::monthly_counts_cleaned()` lalu menyimpan ke `Monthly_model`.

1) Ambil data kunjungan dan bersihkan (cleaning)
   - Hanya data yang punya tanggal dan nama pengunjung.
   - Tanggal kunjungan harus valid:
     - `visit_date IS NOT NULL`
     - `visit_date <> ''`
     - `visit_date <> '0000-00-00'`
   - Nama pengunjung harus valid:
     - `visitor_name IS NOT NULL`
     - `visitor_name <> ''`
   - Hapus duplikasi dengan `DISTINCT` pada kombinasi:
     - `member_id`, `visitor_name`, `membership_type`,
       `institution`, `room_name`, `visit_date`, `visit_time`

2) Agregasi per bulan
   - Dari data bersih, hitung total per bulan:
     - `YEAR(visit_date)` sebagai tahun (Y)
     - `MONTH(visit_date)` sebagai bulan (M)
     - `COUNT(*)` sebagai total kunjungan bulan itu
   - Urutkan naik berdasarkan tahun dan bulan.

3) Transformasi ke format regresi
   - Untuk setiap bulan hasil agregasi, bentuk baris:
     - `year`  = tahun hasil agregasi
     - `month` = bulan hasil agregasi
     - `y_total` = total kunjungan di bulan tersebut
     - `x_period` = nomor urut bulan (dimulai dari 1, naik 1 setiap baris)

4) Simpan hasil preprocessing
   - `monthly_visits` dikosongkan dulu (`TRUNCATE`).
   - Semua baris baru dimasukkan sekaligus (`insert_batch`).

Struktur data yang dipakai
--------------------------
- Sumber data: tabel `visits` (kunjungan mentah).
- Hasil akhir: tabel `monthly_visits` dengan kolom:
  - `year`, `month`, `x_period`, `y_total`.

Catatan
-------
- Data duplikat dihitung berdasarkan kombinasi identitas dan waktu kunjungan,
  jadi kunjungan yang sama persis hanya dihitung sekali.
- Hasil `monthly_visits` ini yang dipakai di fitur prediksi/regresi.
