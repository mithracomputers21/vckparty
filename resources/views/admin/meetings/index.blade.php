@extends('layouts.admin')
@section('content')
@can('meeting_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.meetings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.meeting.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.meeting.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Meeting">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.meeting.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.meeting.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.meeting.fields.father_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.meeting.fields.educational_qualification') }}
                    </th>
                    <th>
                        {{ trans('cruds.meeting.fields.photo') }}
                    </th>
                    <th>
                        {{ trans('cruds.meeting.fields.block_area_town_vattam') }}
                    </th>
                    <th>
                        {{ trans('cruds.meeting.fields.district') }}
                    </th>
                    <th>
                        {{ trans('cruds.meeting.fields.state') }}
                    </th>
                    <th>
                        {{ trans('cruds.meeting.fields.country') }}
                    </th>
                    <th>
                        {{ trans('cruds.meeting.fields.current_post') }}
                    </th>
                    <th>
                        {{ trans('cruds.meeting.fields.profession') }}
                    </th>
                    <th>
                        {{ trans('cruds.meeting.fields.twitter') }}
                    </th>
                    <th>
                        {{ trans('cruds.meeting.fields.facebook') }}
                    </th>
                    <th>
                        {{ trans('cruds.meeting.fields.whatsapp_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.meeting.fields.instagram') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('meeting_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.meetings.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.meetings.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'father_name', name: 'father_name' },
{ data: 'educational_qualification', name: 'educational_qualification' },
{ data: 'photo', name: 'photo', sortable: false, searchable: false },
{ data: 'block_area_town_vattam', name: 'block_area_town_vattam' },
{ data: 'district', name: 'district' },
{ data: 'state', name: 'state' },
{ data: 'country', name: 'country' },
{ data: 'current_post', name: 'current_post' },
{ data: 'profession', name: 'profession' },
{ data: 'twitter', name: 'twitter' },
{ data: 'facebook', name: 'facebook' },
{ data: 'whatsapp_number', name: 'whatsapp_number' },
{ data: 'instagram', name: 'instagram' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Meeting').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection