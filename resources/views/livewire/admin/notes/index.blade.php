<div>

  <div class="mb-4 d-flex justify-content-between align-items-center">
    <button class="btn btn-success btn-sm" wire:click="openModal">
      <i class="fa-solid fa-plus me-1"></i> Tambah Catatan
    </button>
    <div style="width: 250px;">
      <select wire:model.live="selectedProjectId" class="form-select form-select-sm">
        <option value="">Semua Project</option>
        @foreach($projects as $project)
          <option value="{{ $project->id }}">{{ $project->project_name }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <!-- Google Keep Style Grid -->
  <div class="row g-3">
    @forelse ($notes as $note)
      <div class="col-md-3">
        <div class="card note-card" style="cursor: pointer; min-height: 150px;" wire:click="viewDetail({{ $note->id }})">
          <div class="card-body">
            <h6 class="card-title fw-bold mb-2">{{ $note->title }}</h6>

            @if(!$selectedProjectId)
              <span class="badge bg-secondary mb-2" style="font-size: 0.7rem;">{{ $note->project->project_name }}</span>
            @endif

            <p class="card-text text-muted small" style="
              display: -webkit-box;
              -webkit-line-clamp: 2;
              -webkit-box-orient: vertical;
              overflow: hidden;
              text-overflow: ellipsis;
            ">
              {!! strip_tags($note->content) !!}
            </p>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="text-center text-muted py-5">
          <i class="fa-solid fa-note-sticky fa-3x mb-3"></i>
          <p>Belum ada catatan</p>
        </div>
      </div>
    @endforelse
  </div>

  <!-- Modal Create/Edit -->
  @if($showModal)
  <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $isEdit ? 'Edit Catatan' : 'Tambah Catatan Baru' }}</h5>
          <button type="button" class="btn-close" wire:click="closeModal"></button>
        </div>

        <div class="modal-body">
          <form wire:submit.prevent="save">

            <div class="form-group mb-3">
              <label>Project <span class="text-danger">*</span></label>
              <select wire:model="project_id" class="form-select @error('project_id') is-invalid @enderror">
                <option value="">Pilih Project</option>
                @foreach($projects as $project)
                  <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                @endforeach
              </select>
              @error('project_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
              <label>Judul <span class="text-danger">*</span></label>
              <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" placeholder="Masukkan judul catatan">
              @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3" wire:ignore>
              <label>Konten <span class="text-danger">*</span></label>
              <textarea id="editor" class="form-control @error('content') is-invalid @enderror" rows="10">{{ $content }}</textarea>
              @error('content') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-success btn-sm">{{ $isEdit ? 'Update' : 'Tambah' }} Catatan</button>
          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" wire:click="closeModal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  @endif

  <!-- Modal Detail -->
  @if($showDetailModal)
  <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          @if($editingTitle)
            <input
              type="text"
              wire:model="title"
              wire:keydown.enter="updateTitle"
              wire:keydown.escape="cancelTitleEdit"
              class="form-control form-control-sm @error('title') is-invalid @enderror"
              autofocus
            >
            @error('title') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
          @else
            <h5 class="modal-title" wire:click="enableTitleEdit" style="cursor: pointer;" title="Klik untuk edit">{{ $title }}</h5>
          @endif
          <button type="button" class="btn-close" wire:click="closeDetailModal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <small class="text-muted">
              <i class="fa-solid fa-diagram-project me-1"></i>
              {{ $projects->find($project_id)?->project_name }}
            </small>
          </div>

          @if($editingContent)
            <div wire:key="editor-content-{{ $noteId }}" wire:ignore>
              <textarea id="editorDetail" class="form-control @error('content') is-invalid @enderror" rows="15">{{ $content }}</textarea>
              @error('content') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
            </div>
            <div class="mt-2">
              <button type="button" wire:click="updateContent" class="btn btn-primary btn-sm">Simpan</button>
              <button type="button" wire:click="cancelContentEdit" class="btn btn-secondary btn-sm">Batal</button>
            </div>
          @else
            <div wire:key="content-view-{{ $noteId }}" wire:click="enableContentEdit" style="cursor: pointer; min-height: 200px; padding: 15px; border: 1px solid #dee2e6; border-radius: 5px;" title="Klik untuk edit">
              {!! $content !!}
            </div>
          @endif
        </div>

        <div class="modal-footer d-flex justify-content-between">
          <button type="button" wire:click="confirmDelete({{ $noteId }})" class="btn btn-danger btn-sm">
            <i class="fa-solid fa-trash me-1"></i> Hapus
          </button>
          <button type="button" class="btn btn-secondary btn-sm" wire:click="closeDetailModal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  @endif

  <style>
  .note-card {
    transition: transform 0.2s, box-shadow 0.2s;
    border: 1px solid #e0e0e0;
  }

  .note-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }
  </style>

  @push('scripts')
  <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
  <script>
    let editorInstance = null;
    let editorDetailInstance = null;

    function initEditor() {
      const editorEl = document.getElementById('editor');
      if (editorEl && !editorInstance) {
        ClassicEditor
          .create(editorEl)
          .then(editor => {
            editorInstance = editor;
            editor.model.document.on('change:data', () => {
              @this.set('content', editor.getData());
            });
          })
          .catch(error => console.error('Editor error:', error));
      }
    }

    function initEditorDetail() {
      const editorDetailEl = document.getElementById('editorDetail');
      if (editorDetailEl && !editorDetailInstance) {
        ClassicEditor
          .create(editorDetailEl)
          .then(editor => {
            editorDetailInstance = editor;
            editor.model.document.on('change:data', () => {
              @this.set('content', editor.getData());
            });
          })
          .catch(error => console.error('Editor detail error:', error));
      }
    }

    function destroyEditor() {
      if (editorInstance) {
        editorInstance.destroy()
          .then(() => {
            editorInstance = null;
          })
          .catch(error => console.error('Destroy editor error:', error));
      }
    }

    function destroyEditorDetail() {
      if (editorDetailInstance) {
        editorDetailInstance.destroy()
          .then(() => {
            editorDetailInstance = null;
          })
          .catch(error => console.error('Destroy editor detail error:', error));
      }
    }

    // Initialize editor when modal opens
    document.addEventListener('DOMContentLoaded', () => {
      const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
          if (mutation.addedNodes.length) {
            mutation.addedNodes.forEach((node) => {
              if (node.nodeType === 1) {
                // Editor for create/edit modal
                const editor = node.querySelector ? node.querySelector('#editor') : null;
                if (editor || node.id === 'editor') {
                  setTimeout(() => initEditor(), 150);
                }

                // Editor for detail modal
                const editorDetail = node.querySelector ? node.querySelector('#editorDetail') : null;
                if (editorDetail || node.id === 'editorDetail') {
                  setTimeout(() => initEditorDetail(), 150);
                }
              }
            });
          }

          // Clean up editor when modal closes
          if (mutation.removedNodes.length) {
            mutation.removedNodes.forEach((node) => {
              if (node.nodeType === 1) {
                if (node.querySelector) {
                  if (node.querySelector('#editor') || node.id === 'editor') {
                    destroyEditor();
                  }
                  if (node.querySelector('#editorDetail') || node.id === 'editorDetail') {
                    destroyEditorDetail();
                  }
                }
              }
            });
          }
        });
      });

      observer.observe(document.body, {
        childList: true,
        subtree: true
      });
    });

    // Livewire hooks
    document.addEventListener('livewire:init', () => {
      Livewire.hook('morph.updated', () => {
        // Check if editor elements exist after Livewire updates
        setTimeout(() => {
          if (document.getElementById('editor') && !editorInstance) {
            initEditor();
          }
          if (document.getElementById('editorDetail') && !editorDetailInstance) {
            initEditorDetail();
          }
        }, 150);
      });

    });
  </script>
  @endpush

</div>
