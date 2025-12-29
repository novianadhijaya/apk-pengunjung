Perhitungan Regresi dari Awal (Singkat + Detail)
================================================

Dokumen ini menjelaskan singkatan yang dipakai dan cara hitung regresi linier
secara runtut, memakai data saat ini di `monthly_visits`.

1) Singkatan yang dipakai
-------------------------
- X = periode (urutan bulan, mulai dari 1).
- Y = jumlah pengunjung per bulan.
- n = jumlah data.
- sumX  = jumlah seluruh X.
- sumY  = jumlah seluruh Y.
- sumX2 = jumlah seluruh X^2 (X kuadrat).
- sumXY = jumlah seluruh (X * Y).
- a = konstanta (intercept).
- b = koefisien (kemiringan).
- Yhat = nilai prediksi dari persamaan regresi.
- Ybar = rata-rata Y.
- SST = total variasi data Y.
- SSE = total error (selisih Y dan Yhat).
- SSR = variasi yang dijelaskan model.

2) Data yang dipakai (saat ini)
-------------------------------
Data dari tabel `monthly_visits`:

```
Bulan    X  Y
2025-01  1  44
2025-02  2  46
2025-03  3  38
2025-04  4  58
2025-05  5  39
2025-06  6  35
2025-07  7  37
2025-08  8  34
2025-09  9  45
2025-10  10 41
2025-11  11 44
2025-12  12 40
```

Jumlah data: n = 12.

3) Buat tabel bantu (X^2 dan X*Y)
---------------------------------

```
Bulan    X  Y  X^2  X*Y
2025-01  1  44   1   44
2025-02  2  46   4   92
2025-03  3  38   9  114
2025-04  4  58  16  232
2025-05  5  39  25  195
2025-06  6  35  36  210
2025-07  7  37  49  259
2025-08  8  34  64  272
2025-09  9  45  81  405
2025-10  10 41 100  410
2025-11  11 44 121  484
2025-12  12 40 144  480
```

4) Hitung jumlah (sum)
----------------------
- sumX  = 78
- sumY  = 501
- sumX2 = 650
- sumXY = 3197
- n = 12

5) Hitung koefisien a dan b
----------------------------
Rumus:

```
D = n*sumX2 - (sumX^2)
b = (n*sumXY - sumX*sumY) / D
a = (sumY*sumX2 - sumX*sumXY) / D
```

Hitung D:

```
D = 12*650 - 78^2
  = 7800 - 6084
  = 1716
```

Hitung b:

```
b = (12*3197 - 78*501) / 1716
  = (38364 - 39078) / 1716
  = -714 / 1716
  = -0.416084
```

Hitung a:

```
a = (501*650 - 78*3197) / 1716
  = (325650 - 249366) / 1716
  = 76284 / 1716
  = 44.454545
```

6) Persamaan regresi
--------------------

```
Yhat = 44.454545 - 0.416084X
```

Artinya:
- Jika X naik 1 bulan, prediksi Y turun sekitar 0.416.
- Nilai awal (saat X=0) sekitar 44.45.

7) Hitung Yhat untuk tiap bulan
-------------------------------

```
X=1  => Yhat = 44.454545 - 0.416084*1  = 44.04
X=2  => Yhat = 44.454545 - 0.416084*2  = 43.62
X=3  => Yhat = 44.454545 - 0.416084*3  = 43.21
X=4  => Yhat = 44.454545 - 0.416084*4  = 42.79
X=5  => Yhat = 44.454545 - 0.416084*5  = 42.37
X=6  => Yhat = 44.454545 - 0.416084*6  = 41.96
X=7  => Yhat = 44.454545 - 0.416084*7  = 41.54
X=8  => Yhat = 44.454545 - 0.416084*8  = 41.13
X=9  => Yhat = 44.454545 - 0.416084*9  = 40.71
X=10 => Yhat = 44.454545 - 0.416084*10 = 40.29
X=11 => Yhat = 44.454545 - 0.416084*11 = 39.88
X=12 => Yhat = 44.454545 - 0.416084*12 = 39.46
```

Contoh prediksi bulan berikutnya:
- Bulan berikutnya dari 2025-12 adalah 2026-01.
- X target = 13.

```
Yhat = 44.454545 - 0.416084*13 = 39.05
```

8) Pengujian model (evaluasi)
-----------------------------
Rumus:

```
Ybar = sumY / n
SST = sum((Yi - Ybar)^2)
SSE = sum((Yi - Yhat)^2)
SSR = sum((Yhat - Ybar)^2)

R2   = 1 - (SSE / SST)
MAE  = sum(|Yi - Yhat|) / n
MSE  = sum((Yi - Yhat)^2) / n
RMSE = sqrt(MSE)
MAPE = (1/n) * sum(|(Yi - Yhat) / Yi|) * 100%
SDpop = sqrt(SST / n)
```

Hasil dari data saat ini:
- Ybar = 41.75
- SST = 456.25
- SSE = 431.493007
- SSR = 24.756993
- R2 = 0.054262
- MAE = 4.540793
- MSE = 35.957751
- RMSE = 5.996478
- MAPE = 10.74%
- SDpop = 6.166104

Ringkas makna angka:
- R2 kecil berarti model belum menjelaskan variasi data dengan baik.
- MAPE 10.74% masuk kategori "baik".
- RMSE < SDpop berarti kategori SD "baik".

Catatan
-------
- Semua hitungan di atas mengikuti `RegressionLinear` pada aplikasi.
- Jika ada Yi = 0, MAPE dihitung tanpa data tersebut agar tidak pembagian nol.
