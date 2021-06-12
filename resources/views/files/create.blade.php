@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/min/dropzone.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/dropzone.js"></script>

<!-- Font Awesome JS -->
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"
    integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous">
</script>
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"
    integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous">
</script>
<form method="post" action="{{ route('files.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="container text-center">

        @if (session('info'))
        <div class="alert alert-info">
            {!! session('info') !!}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">
            {!! session('error') !!}
        </div>
        @endif

        <div class="col d-flex justify-content-center">
            <div style="width: 100%" class="row">

                <div class="drag-area">
                    <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                    <header>Upload File</header>
                  
                    <button type="button">Browse File</button>
                </div>

                <div style="width: 100%" class="row d-flex justify-content-center">
                    <div class="file">
                        <input type="file" name="file" accept=".mp4" hidden>
                        <br>
                        <div>
                            <input type="text" class="form-control" name="title" placeholder="Video Title"
                                style="display: none" required id="titleText">
                            <input type="submit" id="submitButton" class="btn btn-lg btn-primary" style="display: none"
                                value="Submit">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>












<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }

    .drag-area {
        border: 2px dashed rgb(148, 74, 209);
        border-radius: 5px;
        width: 60%;
        margin: auto;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .drag-area.active {
        border: 2px solid #646ecb
    }

    .drag-area .icon {
        font-size: 100px;
        color: #646ecb
    }

    .drag-area header {
        font-size: 30px;
        font-weight: 500;
        color: #646ecb
    }

    .drag-area span {
        font-size: 25px;
        font-weight: 500;
        color: #646ecb margin: 10px 0 15px 0;
    }

    .drag-area button {
        padding: 10px 25px;
        font-size: 20px;
        font-weight: 500;
        border: none;
        outline: none;
        background: rgb(73, 57, 214);
        color: #e1e1eb;
        border-radius: 5px;
        cursor: pointer;
    }

    .drag-area img {
        height: 100%;
        width: 100%;
        object-fit: cover;
        border-radius: 5px;
    }
</style>








<script type="text/javascript">
    //selecting all required elements
        const dropArea = document.querySelector(".drag-area"),
            dragText = dropArea.querySelector("header"),
            button = dropArea.querySelector("button");
        const filearea = document.querySelector(".file"),
            input = filearea.querySelector("input");
        let file; //this is a global variable and we'll use it inside multiple functions

        button.onclick = () => {
            input.click(); //if user click on the button then the input also clicked
        }

        input.addEventListener("change", function() {
            //getting user select file and [0] this means if user select multiple files then we'll select only the first one
            file = this.files[0];
            dropArea.classList.add("active");
            showFile(); //calling function
        });


        // //If user Drag File Over DropArea
        // dropArea.addEventListener("dragover", (event) => {
        //     event.preventDefault(); //preventing from default behaviour
        //     dropArea.classList.add("active");
        //     dragText.textContent = "Release to Upload File";
        // });

        // //If user leave dragged File from DropArea
        // dropArea.addEventListener("dragleave", () => {
        //     dropArea.classList.remove("active");
        //     dragText.textContent = "Drag & Drop to Upload File";
        // });

        // //If user drop File on DropArea
        // dropArea.addEventListener("drop", (event) => {
        //     event.preventDefault(); //preventing from default behaviour
        //     //getting user select file and [0] this means if user select multiple files then we'll select only the first one
        //     file = event.dataTransfer.files[0];
        //     showFile(); //calling function
        // });

        function showFile() {
            let fileType = file.type; //getting selected file type
            let validExtensions = ["video/mp4"]; //adding some valid image extensions in array
            if (validExtensions.includes(fileType)) { //if user selected file is an image file
                let fileReader = new FileReader(); //creating new FileReader object
                fileReader.onload = () => {
                    let fileURL = fileReader.result; //passing user file source in fileURL variable
                    // UNCOMMENT THIS BELOW LINE. I GOT AN ERROR WHILE UPLOADING THIS POST SO I COMMENTED IT
                    let imgTag =
                        `<video width="100%"> <source src ="${fileURL}"> </video>`; //creating an img tag and passing user selected file source inside src attribute
                    dropArea.innerHTML = imgTag; //adding that created img tag inside dropArea container
                }
                fileReader.readAsDataURL(file);
                document.getElementById('submitButton').style.display = "";
                document.getElementById('titleText').style.display = "";
            } else {
                alert("This is not a video File!");
                dropArea.classList.remove("active");
                dragText.textContent = "Upload File";
            }
        }

</script>







@endsection