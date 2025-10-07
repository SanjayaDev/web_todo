Sekarang buatkan saya module Catatan

Model dan migrations sudah ada, cek folder models & migrations

1. Buat menu 'Catatan' dengan ikon catat di sidebar dibawah menu project
2. Buat controller 
Admin/NoteController, ikuti gaya koding/pattern nya seperti controller yang sudah ada
3. File index resources/views/admin/notes/index
4. UI index seperti Google Keep, lihat di prompts/images/index-notes.png, beda nya tiap card tampilkan Title dan Konten nya. Jika konten melebihi 2 baris, maka lanjutkan ... (truncate). Ada filter projects juga. Dan di card tiap catatan, jika filter project tidak jalan, maka tambahkan badge dibawah title untuk info nama project nya. Jika filter jalan, hilangkan badge nya.
Filter otomatis jalan ketika di select filter (tanpa klik submit/tombol). Dan select pertama adalah 'Semua Project'
5. Ada tombol 'Tambah Catatan', ketika di klik akan muncul popup modal inputan select project, title, konten menggunakan WYSIWYG CKEditor5
6. Ketika card di klik, muncul modal popup untuk keterangan lebih lengkap
Ketika title di klik, berubah jadi inputan dan bisa edit. Lalu tinggal klik enter untuk update.
Ketika konten di klik, berubah jadi inputan WYSIWYG juga dan ada tombol save untuk menyimpan konten
7. Refer ke prompts/rules/crud.md untuk rules penulisan kode nya. Terutama ini menggunakan konsep service pattern dan logic menggunakan try catch