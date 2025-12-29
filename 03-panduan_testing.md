Panduan Menu Testing (Pengujian)
================================

Lokasi menu
-----------
- URL: http://localhost/app_pengunjung/index.php/testing
- Controller: `application/controllers/Testing.php`
- View: `application/views/testing/index.php`
- Library regresi: `application/libraries/RegressionLinear.php`

Tujuan
------
Menu Testing/Pengujian dipakai untuk mengevaluasi seberapa baik model regresi
linier mengikuti data historis. Outputnya berisi metrik R2, MAE, MSE, RMSE,
MAPE, SD, serta SST/SSR/SSE.

Alur pengguna di halaman
------------------------
1) Buka menu Testing.
2) Sistem memeriksa data preprocessing.
3) Jika data kurang dari 2 bulan, tampil peringatan.
4) Jika data cukup, sistem menghitung metrik evaluasi dan menampilkannya.

Algoritma program (ringkas namun rinci)
---------------------------------------
Fungsi utama ada di `Testing::index()` dan memakai `RegressionLinear`.

1) Ambil data preprocessing
   - Ambil semua data `monthly_visits` urut tahun dan bulan.
   - Jika jumlah data < 2 bulan, tampilkan peringatan dan berhenti.

2) Bentuk data regresi
   - X diambil dari `x_period` (1..n).
   - Y diambil dari `y_total`.

3) Hitung parameter regresi (fit)
   - Hitung penjumlahan:
     - `sumX`, `sumY`, `sumX2`, `sumXY`, dan `n`
   - Hitung koefisien regresi:
     - `D = n*sumX2 - (sumX^2)`
     - `b = (n*sumXY - sumX*sumY) / D`
     - `a = (sumY*sumX2 - sumX*sumXY) / D`
   - Hitung Yhat untuk tiap data: `Yhat_i = a + b*X_i`

4) Hitung metrik evaluasi (evaluate)
   - Rata-rata Y:
     - `Ybar = sumY / n`
   - Hitung:
     - `SST = sum((Yi - Ybar)^2)`
     - `SSE = sum((Yi - Yhat_i)^2)`
     - `SSR = sum((Yhat_i - Ybar)^2)`
   - Metrik:
     - `R2   = 1 - (SSE / SST)`
     - `MAE  = sum(|Yi - Yhat_i|) / n`
     - `MSE  = sum((Yi - Yhat_i)^2) / n`
     - `RMSE = sqrt(MSE)`
     - `MAPE = (1/n) * sum(|(Yi - Yhat_i)/Yi|) * 100%`
       (Yi = 0 diabaikan agar tidak pembagian nol)
     - `SDpop = sqrt(SST / n)`
   - Kategori:
     - MAPE < 10% = sangat baik
     - 10% - 20% = baik
     - 20% - 50% = cukup
     - > 50% = buruk
     - RMSE < SDpop = baik
     - RMSE = SDpop = cukup
     - RMSE > SDpop = buruk

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
- Menu Testing tidak memakai data train/test terpisah; semua data dipakai.
