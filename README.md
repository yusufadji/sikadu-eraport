<h1>Tugas Besar Rekayasa Web</h1>

Changelog:
1. Ubah tabel guru -> nip, no_telp menjadi varchar
2. Ubah tabel siswa -> nip, no_telp menjadi varchar
3. Ubah tabel raport -> kolom nilai_rata-rata menjadi nilai_avg
4. Ubah tabel nilai -> tambahin kolom untuk nilai uas
5. Tambah tabel admin (id_admin,nama_admin,email,password)
6. Update tabel siswa -> password jadi 255 (untuk hash)
7. Update tabel guru -> password jadi 255 (untuk hash)
8. Perbarui database -> (stored pocedure fitur chat)
9. Tambah function -> hitung_nilai_akhir
10. Perbarui database :
    - hapus kolom nilai_avg,nilai_huruf,keterangan di tabel raport
    - hapus kolom keterangan di tabel nilai
11. Tambah pagination -> Admin pages

Todo List :
1. (+)Scheduled backup