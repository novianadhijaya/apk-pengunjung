Panduan Menu Prediction
=======================

Lokasi menu
-----------
- URL: http://localhost/app_pengunjung/index.php/prediction
- Controller: `application/controllers/Prediction.php`
- View: `application/views/prediction/index.php`
- Library regresi: `application/libraries/RegressionLinear.php`

Tujuan
------
Menu Prediction dipakai untuk memprediksi jumlah pengunjung pada bulan target
berdasarkan data hasil preprocessing (tabel `monthly_visits`) dengan regresi
linier sederhana.

Parameter input
---------------
- `month` (query string) dengan format `YYYY-MM`
  - Contoh: `http://localhost/app_pengunjung/index.php/prediction?month=2024-11`
- Jika `month` kosong, sistem otomatis memakai bulan berikutnya dari data
  terakhir di `monthly_visits`.

Alur pengguna di halaman
------------------------
1) Buka menu Prediction.
2) Pilih bulan target (atau biarkan default).
3) Klik tombol "Prediksi".
4) Sistem menampilkan persamaan regresi, nilai a dan b, X target, dan Yhat.
5) Tabel menampilkan data X, Y, dan Yhat untuk seluruh bulan historis.

Data saat ini (hasil preprocessing)
-----------------------------------
Data `monthly_visits` saat ini berisi 12 bulan (2025-01 s/d 2025-12):

| Bulan   | X  | Y  |
|---------|---:|---:|
| 2025-01 | 1  | 44 |
| 2025-02 | 2  | 46 |
| 2025-03 | 3  | 38 |
| 2025-04 | 4  | 58 |
| 2025-05 | 5  | 39 |
| 2025-06 | 6  | 35 |
| 2025-07 | 7  | 37 |
| 2025-08 | 8  | 34 |
| 2025-09 | 9  | 45 |
| 2025-10 | 10 | 41 |
| 2025-11 | 11 | 44 |
| 2025-12 | 12 | 40 |

Hasil regresi dari data di atas:
- ΣX = 78
- ΣY = 501
- ΣX2 = 650
- ΣXY = 3197
- a = 44.454545
- b = -0.416084

Contoh hasil prediksi default (tanpa parameter `month`):
- Data terakhir: 2025-12 dengan X=12
- Bulan target default: 2026-01 (bulan berikutnya)
- X target = 13
- Yhat target = 39.05

Nilai Yhat yang tampil pada tabel (pembulatan 2 desimal):

| Bulan   | X  | Y  | Yhat |
|---------|---:|---:|-----:|
| 2025-01 | 1  | 44 | 44.04 |
| 2025-02 | 2  | 46 | 43.62 |
| 2025-03 | 3  | 38 | 43.21 |
| 2025-04 | 4  | 58 | 42.79 |
| 2025-05 | 5  | 39 | 42.37 |
| 2025-06 | 6  | 35 | 41.96 |
| 2025-07 | 7  | 37 | 41.54 |
| 2025-08 | 8  | 34 | 41.13 |
| 2025-09 | 9  | 45 | 40.71 |
| 2025-10 | 10 | 41 | 40.29 |
| 2025-11 | 11 | 44 | 39.88 |
| 2025-12 | 12 | 40 | 39.46 |

Algoritma program (ringkas namun rinci)
---------------------------------------
Fungsi utama ada di `Prediction::index()` dan memakai `RegressionLinear`.

1) Ambil data preprocessing
   - Ambil semua data `monthly_visits` urut tahun dan bulan.
   - Jika jumlah data < 2 bulan, tampilkan peringatan dan berhenti.

2) Siapkan data regresi
   - X diambil dari `x_period` (1..n).
   - Y diambil dari `y_total`.
   - Hitung penjumlahan:
     - `sumX`, `sumY`, `sumX2`, `sumXY`, dan `n`
   - Hitung koefisien regresi:
     - `D = n*sumX2 - (sumX^2)`
     - `b = (n*sumXY - sumX*sumY) / D`
     - `a = (sumY*sumX2 - sumX*sumXY) / D`
   - Bentuk persamaan `Yhat = a + bX` untuk semua data historis.

3) Tentukan bulan target dan X target
   - Ambil input `month` atau pakai default bulan berikutnya.
   - Validasi format `YYYY-MM` dengan regex `^\d{4}-\d{2}$`.
   - Konversi ke indeks bulan:
     - `index = (tahun * 12) + bulan`
   - Hitung selisih bulan:
     - `delta = index_target - index_last`
     - `X_target = X_last + delta`
   - Jika `X_target < 1`, tampilkan peringatan karena target lebih awal dari
     data pertama.

4) Hitung prediksi bulan target
   - `Yhat_target = a + b * X_target`
   - Tampilkan hasil prediksi pada halaman.

Struktur data yang dipakai
--------------------------
- Tabel `monthly_visits`: `year`, `month`, `x_period`, `y_total`
- Output prediksi: `month` target, `X_target`, `Yhat_target`

Catatan
-------
- Prediksi berjalan jika data preprocessing minimal 2 bulan.
- Format bulan wajib `YYYY-MM`.
