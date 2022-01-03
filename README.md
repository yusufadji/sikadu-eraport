Tugas Besar Rekayasa Web

Changelog:
1. Ubah tabel guru -> nip, no_telp menjadi varchar
2. Ubah tabel siswa -> nip, no_telp menjadi varchar
3. Ubah tabel raport -> kolom nilai_rata-rata menjadi nilai_avg
4. Ubah tabel nilai -> tambahin kolom untuk nilai uas
5. Tambah tabel admin (id_admin,nama_admin,email,password)
6. Update tabel siswa -> password jadi 255 (untuk hash)
7. Update tabel guru -> password jadi 255 (untuk hash)

Todo List :
1. (+)Fungsi hitung rata2 nilai
2. (+)Fungsi hitung nilai akhir
3. (+)Scheduled backup
4. (+)Admin Page