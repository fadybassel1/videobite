@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/min/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/dropzone.js"></script>

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous">
    </script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous">
    </script>


    <style>
        .dropzone {
            background: white;
            border-radius: 5px;
            border: 2px dashed rgb(0, 135, 247);
            border-image: none;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <div class="row mb-3">
        <div class="col-lg-12 margin-tb">
            <div class="text-center">
                <h2>Upload Your video </h2>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="message"></div>
        <div id="info"></div>
        <form method="post" action="{{ route('files.store') }}" enctype="multipart/form-data" class="dropzone" id="dropzone">
            @csrf
            <div class="dz-message needsclick">

                <h3>Drag and Drop files here or click to upload.</h3>
                <i class="fas fa-box-open fa-5x pull-r"></i>
                <br>
            </div>
        </form>
    </div>

    <script type="text/javascript">
        Dropzone.options.dropzone =
        {
            maxFilesize: 30,
            resizeQuality: 1.0,

            addRemoveLinks: true,
            timeout: 90000,
            removedfile: function(file) 
            {
                var name = file.upload.filename;
                $.ajax({
                    headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                    type: 'POST',
                    url: '{{ url("files/destroy") }}',
                    data: {filename: name},
                    success: function (data){
                        console.log("File has been successfully removed!!");
                    },
                    error: function(e) {
                        console.log(e);
                    }});
                    var fileRef;
                    return (fileRef = file.previewElement) != null ? 
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
            success: function (file, response) {
                document.getElementById('message').innerHTML ="<div class='alert alert-success text-center' >File uploaded successfully</div>"
                document.getElementById('info').innerHTML ="<div class='alert alert-info text-center' >"+response.message+"</div>"
            },
            error: function (file, response) {
                return false;
            }
        };
    </script>

@endsection
