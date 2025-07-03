@extends('backend.admin.includes.admin_layout')
@section('content')
<div class="page-content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center mb-2">Zilla</h3>
                    <div style="text-align: right">
                        <button type="button" class="btn btn-success btn-xs addButton" data-bs-toggle="modal"
                            data-bs-target="#AddZilla"><i class="fa-solid fa-plus"></i> Add </button>
                    </div>

                    <div class="mt-3">
                        @if (session('success'))
                        <div style="width:100%" class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong> Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="btn-close"></button>
                        </div>
                        @elseif(session('error'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Failed!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="btn-close"></button>
                        </div>
                        @endif
                        <div id="success"></div>
                        <div id="failed"></div>
                    </div>
                    <div class="table-responsive" id="print_data">
                        <table id="dataTableExample" class="table tableSmall" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="">SL</th>
                                    <th style="">Name </th>
                                    <th style="">Name (Bangla)</th>
                                    <th style="">Priority</th>
                                    <th style="">Division</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['zilla_list'] as $key => $single_zilla)
                                <tr>
                                    <td>{{ $key + 1 }}</td>


                                    <td>
                                        {{ $single_zilla->name_en }}

                                    </td>
                                    <td>
                                        {{ $single_zilla->name_bn }}

                                    </td>
                                    <td>
                                        {{ $single_zilla->priority}}

                                    </td>
                                    <td>
                                       {{ $single_zilla->division_name ?? 'N/A' }}

                                    </td>
                                    <td>
                                        <a data-bs-toggle="modal" data-bs-target="#EditDivision"
                                            data-id="{{ $single_zilla->id }}"
                                            data-name_en="{{ $single_zilla->name_en }}"
                                            data-name_bn="{{ $single_zilla->name_bn }}"
                                            data-priority="{{ $single_zilla->priority}}"
                                            data-division="{{ $single_zilla->division_id }}"
                                            class="edit btn btn-success btn-icon"><i class="fa-solid fa-edit"></i></a>

                                        <a class="btn btn-danger btn-icon" data-delete="{{ $single_zilla->id }}"
                                            id="delete"><i class="fa-solid fa-trash"></i> </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="AddZilla" tabindex="-1" aria-labelledby="AddZilla" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h6 class="title" id="defaultModalLabel">ADD Division</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.zilla')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label" for="">Name (English)*</label>
                            <input type="text" class="form-control" placeholder="Enter Name" name="name_en" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="">Name (Bangla)*</label>
                            <input type="text" class="form-control" placeholder="Enter Name" name="name_bn" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="">Priority *</label>
                            <input type="number" class="form-control" placeholder="Enter Priority" name="priority" required>
                        </div>
                        <div class="mb-3">
                            <label for="division_id" class="form-label">Select Division</label>
                            <select name="division" id="division_id" class="form-control" required>
                                <option value="">-- Select Division --</option>
                                @foreach($data['divisions'] as $division)
                                <option value="{{ $division->id }}">{{ $division->name_en }}</option>
                                @endforeach
                            </select>
                            @error('division_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12 text-center mt-3">
                            <button class="btn btn-xs btn-success" type="submit">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="EditDivision" tabindex="-1" aria-labelledby="EditDivision" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h6 class="title" id="defaultModalLabel">Update Division</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.zilla')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Name (English)*</label>
                            <input type="hidden" name="id" id="id">

                            <input type="text" class="form-control" placeholder="Enter Division Name" name="name_en" id="name_en" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="">Name (Bangla)*</label>
                            <input type="text" class="form-control" placeholder="Enter Name" name="name_bn" id="name_bn" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="">Priority *</label>
                            <input type="number" class="form-control" placeholder="Enter Priority" name="priority" id="priority" required>
                        </div>
                        <div class="mb-3">
                            <label for="division_id" class="form-label">Select Division</label>
                            <select name="division" id="division_id" class="form-control" required>
                                <option value="">-- Select Division --</option>
                                @foreach($data['divisions'] as $division)
                                <option value="{{ $division->id }}">{{ $division->name_en }}</option>
                                @endforeach
                            </select>
                            @error('division_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12 text-center mt-3">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script>
    $(document).on('click', '.edit', function() {
        var id = $(this).data('id');
        var name_en = $(this).data('name_en');
        var name_bn = $(this).data('name_bn');
        var priority = $(this).data('priority');
        var division = $(this).data('division');

        $('#id').val(id); 
        $('#name_en').val(name_en);
        $('#name_bn').val(name_bn);
        $('#priority').val(priority);
       $('#division_id').val(division);

    })
</script>
<script>
    $(document).on('click', '#delete', function() {
        if (confirm('Are You Sure ?')) {
            let id = $(this).attr('data-delete');
            let row = $(this).closest('tr');
            $.ajax({
                url: '/admin/zilla/delete/' + id,
                success: function(data) {
                    var data_object = JSON.parse(data);
                    if (data_object.status == 'SUCCESS') {
                        row.remove();
                        $('#Table tbody tr').each(function(index) {
                            $(this).find('td:first').text(index + 1);
                        });
                        $('#success').css('display', 'block');
                        $('#success').html(
                            '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success! </strong>' +
                            data_object.message +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button></div>'
                        );
                    } else {
                        $('#failed').html('display', 'block');
                        $('#failed').html(
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed! </strong>' +
                            data_object.message +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button></div>'
                        );
                    }

                }
            });
        }
    });
    $(function() {
        $('#division_id').select2({
            dropdownParent: $('#AddZilla')
        });
    });
</script>

@endpush