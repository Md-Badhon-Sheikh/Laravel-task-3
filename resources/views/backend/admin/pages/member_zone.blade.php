@extends('backend.admin.includes.admin_layout')
@section('content')
<div class="page-content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center mb-2">Member Zone</h3>
                    <div style="text-align: right">
                        <button type="button" class="btn btn-success btn-xs addButton" data-bs-toggle="modal"
                            data-bs-target="#AddDivision"><i class="fa-solid fa-plus"></i> Add </button>
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
                                    <th style="">Zone Name (Bangla)</th>
                                    <th style="">Zilla</th>
                                    <th style="">Division</th>
                                    <th style="">Zone Type</th>
                                    <th style="">Members</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td>
                                        <a data-bs-toggle="modal" data-bs-target="#EditMemberZone"
                                            data-id=""
                                            data-name=""
                                            data-priority=""
                                            class="edit btn btn-success btn-icon"><i class="fa-solid fa-edit"></i></a>

                                        <a class="btn btn-danger btn-icon" data-delete=""
                                            id="delete"><i class="fa-solid fa-trash"></i> </a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="AddDivision" tabindex="-1" aria-labelledby="AddDivision" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h6 class="title" id="defaultModalLabel">ADD Member Zone</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action=" " method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="">Zone Name (Bangla)*</label>
                            <input type="text" class="form-control" placeholder="Enter Name" name="name" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="division_id" class="form-label">Zilla*</label>
                            <select name="zilla" id="edit_zilla_id" class="form-control" required>
                                <option value="">-- Select Zilla --</option>

                            </select>
                            @error('zilla_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="division_id" class="form-label">Division*</label>
                            <select name="division" id="edit_division_id" class="form-control" required>
                                <option value="">-- Select Division --</option>
                             
                            </select>
                            @error('division_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="division_id" class="form-label">Member Zone Type*</label>
                            <select name="division" id="edit_division_id" class="form-control" required>
                                <option value="">-- Member Zone Type --</option>
                             
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


<div class="modal fade" id="EditMemberZone" tabindex="-1" aria-labelledby="EditMemberZone" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h6 class="title" id="defaultModalLabel">Update Division</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action=" " method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="">Name (Bangla)*</label>
                            <input type="text" class="form-control" placeholder="Enter Zone Name" name="name" id="name" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="">Priority *</label>
                            <input type="number" class="form-control" placeholder="Enter Priority" name="priority" id="priority" required>
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
        var name = $(this).data('name');
        var priority = $(this).data('priority');

        $('#id').val(id);
        $('#name').val(name);
        $('#priority').val(priority);

    })
</script>
<script>
    $(document).on('click', '#delete', function() {
        if (confirm('Are You Sure ?')) {
            let id = $(this).attr('data-delete');
            let row = $(this).closest('tr');
            $.ajax({
                url: '/admin/member-zone-type/delete/' + id,
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
</script>
@endpush