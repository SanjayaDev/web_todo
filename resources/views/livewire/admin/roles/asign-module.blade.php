<div>

  {{-- <div class="row">
    <div class="col-md-4">
      <label>Filter Module</label>
      <select class="form-control" wire:model="module_parent">
        <option value="">Semua</option>
        @foreach ($modules_header as $item)
          <option value="{{ $item->module_parent }}">{{ $item->module_parent }}</option>
        @endforeach
      </select>
    </div>
  </div> --}}

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Module</th>
        <th>Keterangan</th>
        <th>Assign Date</th>
        <th>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" wire:model.live="checked_all">
            <label class="form-check-label">Assign Semua</label>
          </div>
        </th>
      </tr>
    </thead>
    <tbody>
      @foreach ($modules as $module)
        <tr>
          <th colspan="4">{{ $module->module_name }}</th>
        </tr>
        @foreach ($module->childs as $item)
          <tr>
            <td>{{ $item->module_name }}</td>
            <td>{{ $item->module_description }}</td>
            <td>{{ isset($item->roles[0]->created_at) ? date("j F Y H:i", strtotime($item->roles[0]->created_at)) : "-" }}</td>
            <td>
              @if (isset($item->roles[0]))
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" checked wire:click="check_module({{ $role->id }}, {{ $item->id }}, false)">
                  <label class="form-check-label">Assign</label>
                </div>
              @else
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" wire:click="check_module({{ $role->id }}, {{ $item->id }}, true)">
                  <label class="form-check-label">Assign</label>
                </div>
              @endif
            </td>
          </tr>
        @endforeach
      @endforeach
    </tbody>
  </table>

</div>
