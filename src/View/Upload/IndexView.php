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
        <div class="dz-remove badge badge-danger text-light" data-dz-remove>
            <i class="fas fa-trash" aria-hidden="true"></i>
        </div>
        <img data-dz-thumbnail src=""/>
    </div>
</div>

<!-- dropzone configuration -->
<script>
    //the elements of the upload form.
    var titleItem = $('#title');
    var descriptionItem = $('#description');
    var uploadItem = $('#image-upload');

    //do not automatically discover dropzone areas.
    Dropzone.autoDiscover = false;

    //set the dropzone object with configuration.
    var picvidDropzone = new Dropzone('div#image-upload', {
        url: '{{URL}}upload/upload',
        uploadMultiple: true,
        maxFilesize: '{{upload-max-filesize}}',
        paramName: 'image-upload',
        createImageThumbnails: true,
        filesizeBase: 1024,
        maxFiles: 10,
        ignoreHiddenFiles: true,
        acceptedFiles: '{{accepted-files}}',
        autoProcessQueue: false,
        autoQueue: true,
        addRemoveLinks: true,
        thumbnailWidth: 400,
        thumbnailHeight: 200,
        thumbnailMethod: 'crop',
        previewTemplate: $('.picvid-dropzone.template').html(),
        dictRemoveFile: '',
        dictDefaultMessage: '',
        dictCancelUploadConfirmation: '',
        dictCancelUpload: '',
        dictFileTooBig: 'Das Bild ist zu groß!',
        params: {
            token: '{{token}}'
        },
        init: function() {
            var _this = this;

            //add a event to start the upload of the dropzone.
            $('.upload-start').click(function() {
                _this.processQueue();
            });

            //add a event to clear the dropzone
            $('.upload-clear').click(function() {
                _this.removeAllFiles();
            });

            //on success process the queue automatically.
            this.on("success", function() {
                _this.options.autoProcessQueue = true;
            });

            //on completed queue stop the auto process.
            this.on("queuecomplete", function() {
                _this.options.autoProcessQueue = false;
            });
        },
        reset: function() {
            uploadItem.removeClass('dz-started');
            titleItem.val('');
            descriptionItem.val('');
        },
        sending: function(file, xhr, data) {
            data.append(titleItem.attr('name'), titleItem.val());
            data.append(descriptionItem.attr('name'), descriptionItem.val());
        }
    });

    //set the empty callbacks for used events (for IDE support / remove the warnings).
    picvidDropzone.init = function() { };
    picvidDropzone.sending = function() { };
    picvidDropzone.reset = function() { };
</script>