Sekarang buatkan saya menu kalender

Table schedules, model dan migrasi sudah ada bisa cek di migrations dan model. Cek juga kolom-kolom yang nullable karena itu akan berdampak ke validasi

1. Buatkan menu 'Kalendar' dibawah Catatan
2. isi konten nya kalender, buat sendiri saja UI view nya. Bisa geser bulan juga tapi default bulan saat ini
3. Jika ada tanggal yang terisi/ada jadwal, maka munculkan list badge dari title schedule nya
4. Ketika tanggal di klik, akan muncul popup modal informasi kegiatan pada tanggal itu
Informasi kegiatan berupa list table aja
Project, Nama Kegiatan, Keterangan, Waktu (Gabungan start & end time. Kalau kosong dua-dua nya ganti '-', kalau hanya ada start nya aja munculkan start nya), Aksi (Ikon edit dan hapus)

Di modal itu juga ada tombol 'Tambah Jadwal'. Ketika di klik muncul popup baru untuk mengisi 
Piilh Project, Judul, Keterangan, Waktu Mulai, Waktu Selesai. Ketika klik save, maka popup inputan close tapi modal info kegiatan muncul

Ketika edit pun sama workflow nya seperti tambah

Ketika hapus, akan ada alert confirm dahulu, jika ok maka dihapus

5. Semua konten menggunakan Livewire
6. Buat controller Admin/ScheduleController
7. Viewe di admin/schedules/index -> berisi langsung extend livewire