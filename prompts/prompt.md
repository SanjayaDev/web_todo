Halo saya sudah buat migrasi dan model project, bisa lihat di migrations & models

Buatkan saya module CRUD Project. 

Ketentuan
1. Buatkan di sidebar menu (refer /prompts/rules/layout.md) dibawah menu jabatan yaitu 'Projects' dengan icon dari fontawesome yang sesuai
2. Cek model dan migrasi table projects untuk lihat struktur nya
3. routing /app/projects
4. Buat controller 
Admin/ProjectController, ikuti gaya koding/pattern nya seperti controller yang sudah ada
5. File index resources/views/admin/projects/index -> Berisi extends layout dan content langsung menggunakan Livewire
6. Untuk seluruh konten Index menggunakan livewire
7. List project menggunakan paginasi dan search. Kolom nya
No, Project, Tanggal Mulai, Tanggal Selesai, Aksi
Dan untuk kolom start & end date menggunakan format 'j F Y'
Untuk kolom aksi ada edit dan hapus dengan ikon saja
8. Untuk tambah/edit data menggunakan livewire juga
9. Setelah penambahan/edit berhasil, gunakan LivewireAlert (Refer https://github.com/jantinnerezo/livewire-alert)
10. Untuk hapus data, gunakan alert confirm dari livewire alert dengan caption 'Yakin ingin menghapus project ini?' kalau yes, hapus dan notifikasi berhasil menggunakan livewire alert lagic