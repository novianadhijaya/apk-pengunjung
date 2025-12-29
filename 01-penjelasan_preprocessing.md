# Penjelasan Hasil Preprocessing Data

Dokumen ini menjelaskan hasil pada halaman **Preprocessing Data** yang menampilkan agregasi bulanan untuk regresi linier.

## 1. Tujuan Preprocessing

Preprocessing dilakukan agar data kunjungan siap dipakai untuk perhitungan regresi linier. Tahap ini menghasilkan:
- Data bersih (tanpa kosong/duplikat)
- Data numerik (X dan Y) untuk persamaan regresi
- Rekap kunjungan per bulan

## 2. Langkah Preprocessing yang Dijalanakan

1) **Pembersihan data**
   - Mengabaikan data dengan `visitor_name` kosong.
   - Mengabaikan data dengan `visit_date` kosong/invalid.
   - Menghapus duplikasi berdasarkan kombinasi:
     `member_id, visitor_name, membership_type, institution, room_name, visit_date, visit_time`.

2) **Transformasi data ke numerik**
   - X = urutan bulan (1..n) sesuai data yang tersedia.
   - Y = total kunjungan per bulan.

3) **Penentuan variabel X dan Y**
   - X (waktu) = urutan bulan.
   - Y (jumlah pengunjung) = total kunjungan per bulan.

4) **Tombol Proses Preprocessing**
   - Menjalankan proses agregasi dari tabel `visits` ke tabel `monthly_visits`.

## 3. Makna Kolom Hasil Preprocessing

- **Tahun**: tahun dari `visit_date`.
- **Bulan**: bulan dari `visit_date`.
- **X (Periode)**: urutan bulan (1 sampai n).
- **Y (Jumlah)**: total kunjungan pada bulan tersebut.

## 4. Contoh Membaca Hasil

Jika hasil menunjukkan:

| Tahun | Bulan | X (Periode) | Y (Jumlah) |
|------:|------:|------------:|-----------:|
| 2024  | 1     | 1           | 31         |
| 2024  | 2     | 2           | 50         |
| 2024  | 3     | 3           | 50         |

Maka artinya:
- Januari 2024 ada 31 kunjungan, dan menjadi periode X=1.
- Februari 2024 ada 50 kunjungan, dan menjadi periode X=2.
- Maret 2024 ada 50 kunjungan, dan menjadi periode X=3.

## 5. Hubungan dengan Regresi Linier

Data hasil preprocessing ini langsung dipakai untuk:
- **Prediksi** jumlah pengunjung bulan berikutnya (atau bulan tertentu)
- **Pengujian model** (R², MAE, MSE, RMSE, MAPE, SD, dan kategori hasil)

## 6. Ringkasan

Preprocessing memastikan data kunjungan:
- Bersih dari data kosong dan duplikat
- Terstruktur dalam format numerik
- Siap digunakan untuk analisis regresi linier

