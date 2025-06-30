@extends('backend.admin.includes.admin_layout')
@push('css')
@endpush
@section('content')
    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class=" text-center mb-2">Important Link Add</h3>
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
                        <form action="{{route('admin.link.add')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="" class="form-label"> Title *</label>
                                    <input type="text" class="form-control" name="title"
                                        placeholder="Enter Advocate Name" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="">Site Link*</label>
                                    <input type="text" name="site_link" class="form-control"
                                        placeholder="Enter Site Link" required>
                                </div>
                       
                                
                                <div class="col-md-3 mb-3">
                                    <div class="mb-3">
                                        <label class="form-label">Your Photo</label>
                                        <input name="photo" class="form-control" type="file" id="imgPreview"
                                            onchange="readpicture(this, '#imgPreviewId');">
                                    </div>
                                    <div class="text-center">
                                        <img id="imgPreviewId" onclick="image_upload()"
                                            src="{{ asset('backend_assets/images/uploads_preview.png') }}">
                                    </div>
                                </div>


                                 <div class="col-md-3 mb-3">
                                    <label for="issue_date" class="form-label">Priority</label>
                                    <input type="number" name="priority" class="form-control" >
                                </div>

                                 <div class="col-md-3 mb-3">
                                    <label for="issue_date" class="form-label">Link Type</label>
                                    <input type="text" name="link_type" class="form-control" placeholder="Enter link type">
                                </div>
                               
                            </div>
                            <div class="text-center mt-2">
                                <button class="btn btn-xs btn-primary" type="submit">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function image_upload() {

            $('#imgPreview').trigger('click');
        }

        function readpicture(input, preview_id) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $(preview_id)
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }

        }
    </script>
@endpush
