Panduan Menu Perhitungan
========================

Lokasi menu
-----------
- URL: http://localhost/app_pengunjung/index.php/perhitungan
- Controller: `application/controllers/Perhitungan.php`
- View: `application/views/perhitungan/index.php`
- Library regresi: `application/libraries/RegressionLinear.php`

Tujuan
------
Menu Perhitungan menampilkan:
- Data X dan Y beserta Yhat (hasil regresi).
- Perhitungan regresi (ΣX, ΣY, ΣX2, ΣXY, a, b).
- Pengujian model (R2, MAE, MSE, RMSE, MAPE, SD, SST/SSR/SSE).
- Grafik aktual, prediksi, dan perbandingan.

Alur pengguna di halaman
------------------------
1) Buka menu Perhitungan.
2) Sistem memeriksa data preprocessing.
3) Jika data < 2 bulan, tampil peringatan.
4) Jika data cukup, sistem menghitung regresi, evaluasi, dan menampilkan grafik.

Algoritma program (ringkas namun rinci)
---------------------------------------
Fungsi utama ada di `Perhitungan::index()` dan memakai `RegressionLinear`.

1) Ambil data preprocessing
   - Ambil semua data `monthly_visits` urut tahun dan bulan.
   - Jika jumlah data < 2 bulan, tampilkan peringatan dan berhenti.

2) Siapkan data regresi
   - X diambil dari `x_period` (1..n).
   - Y diambil dari `y_total`.

3) Hitung parameter regresi (fit)
   - Hitung penjumlahan:
     - `sumX`, `sumY`, `sumX2`, `sumXY`, dan `n`
   - Hitung koefisien:
     - `D = n*sumX2 - (sumX^2)`
     - `b = (n*sumXY - sumX*sumY) / D`
     - `a = (sumY*sumX2 - sumX*sumXY) / D`
   - Hitung Yhat untuk tiap X: `Yhat_i = a + b*X_i`

4) Hitung evaluasi model (evaluate)
   - `Ybar = sumY / n`
   - `SST = sum((Yi - Ybar)^2)`
   - `SSE = sum((Yi - Yhat_i)^2)`
   - `SSR = sum((Yhat_i - Ybar)^2)`
   - `R2   = 1 - (SSE / SST)`
   - `MAE  = sum(|Yi - Yhat_i|) / n`
   - `MSE  = sum((Yi - Yhat_i)^2) / n`
   - `RMSE = sqrt(MSE)`
   - `MAPE = (1/n) * sum(|(Yi - Yhat_i)/Yi|) * 100%`
     (Yi = 0 diabaikan)
   - `SDpop = sqrt(SST / n)`
   - Kategori MAPE dan SD sesuai `RegressionLinear`.

5) Siapkan data grafik
   - `labels` = daftar bulan `YYYY-MM`.
   - `y_actual` = array Y aktual.
   - `y_pred` = array Yhat.
   - Grafik: aktual, prediksi, dan perbandingan.

Data saat ini (hasil preprocessing)
-----------------------------------
Data `monthly_visits` saat ini berisi 12 bulan (2025-01 s/d 2025-12):

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

Hasil perhitungan regresi:
- ΣX = 78
- ΣY = 501
- ΣX2 = 650
- ΣXY = 3197
- a = 44.454545
- b = -0.416084
- Rumus: Yhat = 44.454545 - 0.416084X

Hasil pengujian yang tampil di menu (pembulatan sesuai UI):
- R2 = 0.054262
- MAE = 4.540793
- MSE = 35.957751
- RMSE = 5.996478
- MAPE = 10.74% (baik)
- SD(Y) Populasi = 6.166104
- Kategori SD = baik
- SST = 456.25
- SSR = 24.756993
- SSE = 431.493007

Catatan
-------
- Menu Perhitungan dan Testing memakai data dan rumus yang sama.
