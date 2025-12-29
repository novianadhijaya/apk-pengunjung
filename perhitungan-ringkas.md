Perhitungan Regresi Ringkas
===========================

Tujuan: memberi gambaran cepat cara hitung regresi linier dan hasil saat ini.

1) Singkatan penting
--------------------
- X = urutan bulan.
- Y = jumlah pengunjung.
- n = jumlah data.
- sumX, sumY, sumX2, sumXY = jumlah masing-masing.
- a, b = koefisien regresi.
- Yhat = prediksi.

2) Data saat ini (ringkas)
--------------------------
- n = 12 (2025-01 s/d 2025-12)
- sumX = 78
- sumY = 501
- sumX2 = 650
- sumXY = 3197

3) Rumus utama
--------------
```
D = n*sumX2 - (sumX^2)
b = (n*sumXY - sumX*sumY) / D
a = (sumY*sumX2 - sumX*sumXY) / D
Yhat = a + bX
```

4) Hasil koefisien
------------------
- D = 1716
- a = 44.454545
- b = -0.416084
- Persamaan: Yhat = 44.454545 - 0.416084X

5) Contoh prediksi
------------------
- Data terakhir: 2025-12 (X=12)
- Bulan berikutnya: X=13
- Yhat = 39.05

6) Evaluasi singkat (saat ini)
------------------------------
- R2 = 0.054262
- MAE = 4.540793
- MSE = 35.957751
- RMSE = 5.996478
- MAPE = 10.74% (baik)
- SDpop = 6.166104 (RMSE < SDpop = baik)
