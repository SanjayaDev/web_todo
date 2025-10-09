<div>

  <!-- Calendar Header -->
  <div class="card mb-3">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center">
        <button wire:click="previousMonth" class="btn btn-outline-secondary btn-sm">
          <i class="fa-solid fa-chevron-left"></i>
        </button>
        <h4 class="mb-0">
          {{ \Carbon\Carbon::create($currentYear, $currentMonth, 1)->locale('id')->translatedFormat('F Y') }}
        </h4>
        <button wire:click="nextMonth" class="btn btn-outline-secondary btn-sm">
          <i class="fa-solid fa-chevron-right"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Calendar Grid -->
  <div class="card">
    <div class="card-body">
      <div class="calendar-grid">
        <!-- Day headers -->
        <div class="calendar-day-header">Min</div>
        <div class="calendar-day-header">Sen</div>
        <div class="calendar-day-header">Sel</div>
        <div class="calendar-day-header">Rab</div>
        <div class="calendar-day-header">Kam</div>
        <div class="calendar-day-header">Jum</div>
        <div class="calendar-day-header">Sab</div>

        <!-- Calendar days -->
        @foreach($calendarDays as $dayData)
          @if($dayData['day'])
            <div class="calendar-day {{ $dayData['date'] == now()->format('Y-m-d') ? 'today' : '' }}" wire:click="openDailyModal('{{ $dayData['date'] }}')">
              <div class="day-number">{{ $dayData['day'] }}</div>
              @if(isset($schedules[$dayData['date']]))
                <div class="schedule-badges">
                  @foreach($schedules[$dayData['date']] as $schedule)
                    <span class="badge bg-primary text-white schedule-badge">{{ $schedule->title }}</span>
                  @endforeach
                </div>
              @endif
            </div>
          @else
            <div class="calendar-day empty"></div>
          @endif
        @endforeach
      </div>
    </div>
  </div>

  <!-- Modal Daily Schedule -->
  @if($showDailyModal)
  <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            Jadwal {{ \Carbon\Carbon::parse($selectedDate)->locale('id')->translatedFormat('d F Y') }}
          </h5>
          <button type="button" class="btn-close" wire:click="closeDailyModal"></button>
        </div>

        <div class="modal-body">
          <button class="btn btn-success btn-sm mb-3" wire:click="openFormModal('{{ $selectedDate }}')">
            <i class="fa-solid fa-plus me-1"></i> Tambah Jadwal
          </button>

          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Project</th>
                  <th>Nama Kegiatan</th>
                  <th>Keterangan</th>
                  <th>Waktu</th>
                  <th width="100">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($dailySchedules as $schedule)
                  <tr>
                    <td>{{ $schedule->project ? $schedule->project->project_name : '-' }}</td>
                    <td>{{ $schedule->title }}</td>
                    <td>{{ $schedule->description ?? '-' }}</td>
                    <td>
                      @if($schedule->time_start && $schedule->time_end)
                        {{ \Carbon\Carbon::parse($schedule->time_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->time_end)->format('H:i') }}
                      @elseif($schedule->time_start)
                        {{ \Carbon\Carbon::parse($schedule->time_start)->format('H:i') }}
                      @else
                        -
                      @endif
                    </td>
                    <td>
                      <button wire:click="edit({{ $schedule->id }})" class="btn btn-sm btn-warning">
                        <i class="fa-solid fa-edit"></i>
                      </button>
                      <button wire:click="confirmDelete({{ $schedule->id }})" class="btn btn-sm btn-danger">
                        <i class="fa-solid fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center">Tidak ada jadwal</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" wire:click="closeDailyModal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  @endif

  <!-- Modal Form Schedule -->
  @if($showFormModal)
  <div class="modal fade show d-block" style="background: rgba(0,0,0,0.6); z-index: 1060;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $isEdit ? 'Edit Jadwal' : 'Tambah Jadwal' }}</h5>
          <button type="button" class="btn-close" wire:click="closeFormModal"></button>
        </div>

        <div class="modal-body">
          <form wire:submit.prevent="save">

            <div class="form-group mb-3">
              <label>Project</label>
              <select wire:model="project_id" class="form-select @error('project_id') is-invalid @enderror">
                <option value="">Pilih Project (Opsional)</option>
                @foreach($projects as $project)
                  <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                @endforeach
              </select>
              @error('project_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
              <label>Judul <span class="text-danger">*</span></label>
              <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" placeholder="Masukkan judul kegiatan">
              @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
              <label>Keterangan</label>
              <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Masukkan keterangan"></textarea>
              @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
              <label>Tanggal <span class="text-danger">*</span></label>
              <input type="date" wire:model="scheduled_at" class="form-control @error('scheduled_at') is-invalid @enderror">
              @error('scheduled_at') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label>Waktu Mulai</label>
                  <input type="time" wire:model="time_start" class="form-control @error('time_start') is-invalid @enderror">
                  @error('time_start') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label>Waktu Selesai</label>
                  <input type="time" wire:model="time_end" class="form-control @error('time_end') is-invalid @enderror">
                  @error('time_end') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-success btn-sm">{{ $isEdit ? 'Update' : 'Simpan' }} Jadwal</button>
          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" wire:click="closeFormModal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  @endif

  <style>
  .calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 5px;
  }

  .calendar-day-header {
    text-align: center;
    font-weight: bold;
    padding: 10px;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
  }

  .calendar-day {
    min-height: 100px;
    padding: 8px;
    border: 1px solid #dee2e6;
    cursor: pointer;
    transition: background-color 0.2s;
    position: relative;
  }

  .calendar-day:hover {
    background-color: #f8f9fa;
  }

  .calendar-day.today {
    background-color: #e3f2fd;
    border: 2px solid #2196f3;
  }

  .calendar-day.today:hover {
    background-color: #bbdefb;
  }

  .calendar-day.today .day-number {
    color: #1976d2;
  }

  .calendar-day.empty {
    background-color: #f8f9fa;
    cursor: default;
  }

  .calendar-day.empty:hover {
    background-color: #f8f9fa;
  }

  .day-number {
    font-weight: bold;
    margin-bottom: 5px;
  }

  .schedule-badges {
    display: flex;
    flex-direction: column;
    gap: 3px;
  }

  .schedule-badge {
    font-size: 0.7rem;
    padding: 2px 5px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;
  }
  </style>

</div>
