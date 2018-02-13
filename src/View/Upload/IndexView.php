<div class="d-flex justify-content-center my-3">
    <div class="col col-12 col-lg-8 col-xl-6">
        <div class="form-group">
            <label class="sr-only" for="title">Titel</label>
            <input class="form-control" id="title" type="text" name="image_title" placeholder="Titel"/>
        </div>
        <div class="form-group">
            <label class="sr-only" for="description">Beschreibung</label>
            <textarea class="form-control" id="description" name="image_description" placeholder="Beschreibung" rows="3"></textarea>
        </div>
        <div class="form-group picvid-dropzone dropzone" id="image-upload">
            <i class="fas fa-upload" aria-hidden="true"></i>
        </div>
        <noscript>
            <div class="alert alert-warning"><strong>Hinweis:</strong> Für den Upload muss JavaScript aktiviert werden. Aktiviere JavaScript in deinem Browser um den Upload verwenden zu können.</div>
        </noscript>
        <button type="button" class="btn btn-success btn-sm-block upload-start mr-2">
            <i class="fas fa-upload" aria-hidden="true"></i>
            <span>Upload</span>
        </button>
        <button type="reset" class="btn btn-secondary btn-sm-block upload-clear">
            <i class="fas fa-times" aria-hidden="true"></i>
            <span>Leeren</span>
        </button>
    </div>
</div>

<!-- custom template for dropzone -->
<div class="picvid-dropzone template">
    <div class="dz-preview dz-file-preview">
        <div class="uploading"><i class="far fa-clock" aria-hidden="true"></i></div>
        <div class="dz-success-mark"><i class="fas fa-check" aria-hidden="true"></i></div>
        <div class="dz-error-mark"><i class="fas fa-times" aria-hidden="true"></i></div>
        <div class="dz-error-message badge badge-danger text-light" data-dz-errormessage></div>
        <div class="dz-filename badge badge-light" data-dz-name></div>
        <div class="dz-size badge badge-light" data-dz-size></div>
        <img data-dz-thumbnail src=""/>
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
        previewTemplate: $('.picvid-dropzone.template').html(),
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