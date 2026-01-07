# Perhitungan Matematika Pengujian Regresi Linier (Halaman `Testing`)

Dokumen ini menjelaskan perhitungan yang menghasilkan nilai seperti di halaman:
`http://localhost/pengunjung/index.php/testing`.

Sumber rumus dan cara hitung mengikuti kode:
- `application/controllers/Testing.php` (mengambil data + memanggil evaluasi)
- `application/libraries/RegressionLinear.php` (rumus regresi + metrik)

---

## 1) Data yang dipakai (dari tabel `monthly_visits`)

Halaman `Testing` mengambil data dari tabel `monthly_visits` berdasarkan filter periode:
`(year * 100 + month)` berada di antara periode awal dan akhir, lalu diurutkan.

Contoh (sesuai data yang tampil pada hasil di screenshot):
- Dari: Jan 2025
- Sampai: Des 2026
- Tetapi data `monthly_visits` yang tersedia hanya sampai Jan 2026, sehingga yang terambil = Jan 2025 s.d Jan 2026 (13 baris).

Tabel data (X = `x_period`, Y = `y_total`):

| No | Periode | X | Y | X·Y | X² |
|---:|:-------:|--:|--:|----:|---:|
| 1 | 2025-01 | 70 | 174 | 12180 | 4900 |
| 2 | 2025-02 | 71 | 163 | 11573 | 5041 |
| 3 | 2025-03 | 72 | 181 | 13032 | 5184 |
| 4 | 2025-04 | 73 | 190 | 13870 | 5329 |
| 5 | 2025-05 | 74 | 160 | 11840 | 5476 |
| 6 | 2025-06 | 75 | 185 | 13875 | 5625 |
| 7 | 2025-07 | 76 | 137 | 10412 | 5776 |
| 8 | 2025-08 | 77 | 135 | 10395 | 5929 |
| 9 | 2025-09 | 78 | 149 | 11622 | 6084 |
| 10 | 2025-10 | 79 | 139 | 10981 | 6241 |
| 11 | 2025-11 | 80 | 134 | 10720 | 6400 |
| 12 | 2025-12 | 81 | 148 | 11988 | 6561 |
| 13 | 2026-01 | 82 | 150 | 12300 | 6724 |
|  | **Σ (jumlah)** | **988** | **2045** | **154788** | **75270** |

Sehingga:
- `n = 13`
- `ΣX = 988`
- `ΣY = 2045`
- `ΣX² = 75270`
- `Σ(X·Y) = 154788`

---

## 2) Membentuk model regresi linier: Ŷ = a + bX

### Rumus koefisien (sesuai `RegressionLinear::fit`)

Denominator:

\[
\text{den} = (n \cdot \sum X^2) - (\sum X)^2
\]

Koefisien:

\[
a = \frac{(\sum Y \cdot \sum X^2) - (\sum X \cdot \sum XY)}{\text{den}}
\]

\[
b = \frac{(n \cdot \sum XY) - (\sum X \cdot \sum Y)}{\text{den}}
\]

### Substitusi angka

Denominator:
- `den = (13 * 75270) - (988^2)`
- `den = 978510 - 976144`
- `den = 2366`

Koefisien `a`:
- Pembilang `a = (2045 * 75270) - (988 * 154788)`
- Pembilang `a = 153,927,150 - 152,930,544`
- Pembilang `a = 996,606`
- `a = 996,606 / 2366 = 421.219780`

Koefisien `b`:
- Pembilang `b = (13 * 154788) - (988 * 2045)`
- Pembilang `b = 2,012,244 - 2,020,460`
- Pembilang `b = -8,216`
- `b = -8,216 / 2366 = -3.472527`

Jadi persamaan regresinya:

\[
\hat{Y} = 421.219780 + (-3.472527 \cdot X)
\]

---

## 3) Menghitung prediksi (Ŷ), error, dan komponen metrik

Definisi (sesuai `RegressionLinear::evaluate`):
- Error (residual): \(\;e_i = Y_i - \hat{Y_i}\)
- Absolute error: \(\;|e_i| = |Y_i - \hat{Y_i}|\)
- Squared error: \(\;e_i^2 = (Y_i - \hat{Y_i})^2\)
- Absolute percentage error (APE): \(\;\text{APE}_i = \left|\frac{Y_i - \hat{Y_i}}{Y_i}\right|\)

Rata-rata Y:

\[
\bar{Y} = \frac{\sum Y}{n} = \frac{2045}{13} = 157.307692
\]

Tabel ringkas per baris (pembulatan 6 desimal):

| No | Periode | X | Y | Ŷ = a + bX | e = Y-Ŷ | \|e\| | e² | APE (%) |
|---:|:-------:|--:|--:|-----------:|--------:|-----:|----:|--------:|
| 1 | 2025-01 | 70 | 174 | 178.142857 | -4.142857 | 4.142857 | 17.163265 | 2.380952 |
| 2 | 2025-02 | 71 | 163 | 174.670330 | -11.670330 | 11.670330 | 136.196595 | 7.159711 |
| 3 | 2025-03 | 72 | 181 | 171.197802 | 9.802198 | 9.802198 | 96.083082 | 5.415579 |
| 4 | 2025-04 | 73 | 190 | 167.725275 | 22.274725 | 22.274725 | 496.163386 | 11.723540 |
| 5 | 2025-05 | 74 | 160 | 164.252747 | -4.252747 | 4.252747 | 18.085859 | 2.657967 |
| 6 | 2025-06 | 75 | 185 | 160.780220 | 24.219780 | 24.219780 | 586.597754 | 13.091773 |
| 7 | 2025-07 | 76 | 137 | 157.307692 | -20.307692 | 20.307692 | 412.402367 | 14.823133 |
| 8 | 2025-08 | 77 | 135 | 153.835165 | -18.835165 | 18.835165 | 354.763434 | 13.951974 |
| 9 | 2025-09 | 78 | 149 | 150.362637 | -1.362637 | 1.362637 | 1.856781 | 0.914522 |
| 10 | 2025-10 | 79 | 139 | 146.890110 | -7.890110 | 7.890110 | 62.253834 | 5.676338 |
| 11 | 2025-11 | 80 | 134 | 143.417582 | -9.417582 | 9.417582 | 88.690859 | 7.028047 |
| 12 | 2025-12 | 81 | 148 | 139.945055 | 8.054945 | 8.054945 | 64.882140 | 5.442530 |
| 13 | 2026-01 | 82 | 150 | 136.472527 | 13.527473 | 13.527473 | 182.992513 | 9.018315 |
|  | **Jumlah (Σ)** |  |  |  |  | **155.758242** | **2518.131868** |  |

Keterangan:
- `Σ|e| = 155.758242`
- `Σe² = 2518.131868` (ini juga sama dengan `SSE`)

---

## 4) Menghitung SST, SSE, SSR, R²

### Rumus (sesuai `RegressionLinear::evaluate`)

\[
\text{SST} = \sum (Y_i - \bar{Y})^2
\]

\[
\text{SSE} = \sum (Y_i - \hat{Y_i})^2
\]

\[
\text{SSR} = \sum (\hat{Y_i} - \bar{Y})^2
\]

Koefisien determinasi:

\[
R^2 = 1 - \left(\frac{\text{SSE}}{\text{SST}}\right)
\]

### Hasil perhitungan

- `Ȳ = 157.307692`
- `SST = 4712.769231`
- `SSE = 2518.131868`
- `SSR = 2194.637363`

Cek konsistensi (dekomposisi variasi):
- `SST ≈ SSR + SSE`
- `4712.769231 ≈ 2194.637363 + 2518.131868`

R²:
- `R² = 1 - (2518.131868 / 4712.769231) = 0.465679`

---

## 5) Menghitung MAE, MSE, RMSE, MAPE

### MAE

Rumus:

\[
\text{MAE} = \frac{1}{n} \sum |Y_i - \hat{Y_i}|
\]

Substitusi:
- `MAE = 155.758242 / 13 = 11.981403`

### MSE

\[
\text{MSE} = \frac{1}{n} \sum (Y_i - \hat{Y_i})^2
\]

Substitusi:
- `MSE = 2518.131868 / 13 = 193.702451`

### RMSE

\[
\text{RMSE} = \sqrt{\text{MSE}}
\]

Substitusi:
- `RMSE = sqrt(193.702451) = 13.917703`

### MAPE

Rumus (di kode: hanya dihitung untuk Y≠0, dan dirata-ratakan per jumlah data Y≠0):

\[
\text{MAPE} = \left(\frac{1}{n} \sum \left|\frac{Y_i - \hat{Y_i}}{Y_i}\right|\right)\times 100\%
\]

Hasil:
- `MAPE = 7.637260%` → dibulatkan tampil: `7.64%`

---

## 6) SD(Y) Populasi (sesuai tampilan)

Di kode:

\[
\text{Var}_{pop} = \frac{\text{SST}}{n}, \quad \text{SD}_{pop} = \sqrt{\text{Var}_{pop}}
\]

Substitusi:
- `SD_pop = sqrt(4712.769231 / 13) = 19.039977`

---

## 7) Ringkasan hasil (pembulatan sesuai UI)

- `R² = 0.465679`
- `MAE = 11.981403`
- `MSE = 193.702451`
- `RMSE = 13.917703`
- `MAPE = 7.64%`
- `SST = 4712.769231`
- `SSR = 2194.637363`
- `SSE = 2518.131868`
- `SD(Y) Populasi = 19.039977`

