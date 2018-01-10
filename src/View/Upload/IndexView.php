<nav class="navbar navbar-expand-md navbar-dark bg-dark" role="navigation">
    <a class="navbar-brand" href="{{URL}}">
        <img src="{{LOGO_URL}}" height="30" class="d-inline-block align-top" alt="Logo of PicVid">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <div class="navbar-nav mr-auto">
            <a class="nav-item nav-link active" href="{{URL}}upload"><i class="fas fa-upload" aria-hidden="true"></i>Upload</a>
            <a class="nav-item nav-link" href="{{URL}}images"><i class="far fa-image" aria-hidden="true"></i>Bilder</a>
        </div>
        <div class="navbar-nav">
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user" aria-hidden="true"></i>{{username}}</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{URL}}profile"><i class="fas fa-id-card" aria-hidden="true"></i>Profil</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{URL}}auth/logout"><i class="fas fa-sign-out-alt" aria-hidden="true"></i>Abmelden</a>
                </div>
            </div>
        </div>
    </div>
</nav>
<div class="d-flex justify-content-center my-3">
    <div class="col col-12 col-lg-8 col-xl-6">
        <form>
            <div class="form-group">
                <label class="sr-only" for="title">Titel</label>
                <input class="form-control" id="title" type="text" name="image_title" placeholder="Titel"/>
            </div>
            <div class="form-group">
                <label class="sr-only" for="description">Beschreibung</label>
                <textarea class="form-control" id="description" name="image_description" placeholder="Beschreibung" rows="3"></textarea>
            </div>
            <div class="form-group dropzone" id="image-upload">
                <i class="fas fa-cloud-upload-alt" aria-hidden="true"></i>
            </div>
            <button type="button" class="btn btn-success btn-sm-block upload-start">
                <i class="fas fa-upload" aria-hidden="true"></i>Upload
            </button>
            <button type="reset" class="btn btn-secondary btn-sm-block upload-clear">
                <i class="fas fa-times" aria-hidden="true"></i>Leeren
            </button>
        </form>
    </div>
</div>

<!-- custom template for dropzone -->
<div class="picvid-dropzone">
    <div class="dz-preview dz-file-preview">
        <div class="dz-details">
            <div class="uploading"><i class="far fa-clock" aria-hidden="true"></i></div>
            <div class="dz-success-mark"><i class="fas fa-check" aria-hidden="true"></i></div>
            <div class="dz-error-mark"><i class="fas fa-times" aria-hidden="true"></i></div>
            <div class="dz-error-message badge badge-danger" data-dz-errormessage></div>
            <div class="dz-filename badge badge-light" data-dz-name></div>
            <div class="dz-size badge badge-light" data-dz-size></div>
            <img data-dz-thumbnail src="" class="img-transparent"/>
        </div>
    </div>
</div>

<!-- dropzone configuration -->
<script>
    //the elements of the upload form.
    var titleItem = $('#title');
    var descriptionItem = $('#description');

    //the configuration of the Dropzone element.
    Dropzone.options.imageUpload = {
        dictDefaultMessage: '',
        url: "{{URL}}upload/upload",
        paramName: "image_upload",
        uploadMultiple: true,
        autoProcessQueue: false,
        maxFilesize: 5,
        parallelUploads: 5,
        thumbnailWidth: 400,
        thumbnailHeight: 200,
        method: "post",
        maxFiles: 5,
        acceptedFiles: "{{accepted_files}}",
        previewTemplate: $('.picvid-dropzone').html(),
        init: function() {
            var myDropzone = this;

            //upload on button click.
            $('.upload-start').click(function() {
                myDropzone.processQueue();
            });

            //clear dropzone area.
            $('.upload-clear').click(function() {
                myDropzone.removeAllFiles();
            });
        },
        sending: function(file, xhr, formData) {
            formData.append('token', '{{token}}');
            formData.append(titleItem.attr('name'), titleItem.val());
            formData.append(descriptionItem.attr('name'), descriptionItem.val());
        }
    };
</script>