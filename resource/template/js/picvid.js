$(document).ready(function() {

    //define the ajax object.
    var msgObject = {};
    msgObject.redirect = "";
    msgObject.state = "";
    msgObject.message = "";
    msgObject.field = "";

    //get the form and the alert element.
    var itemForm = $("form.ajax");
    var itemFormAlert = itemForm.find(".alert");

    //the submit event.
    itemForm.on("submit", function(e) {
        e.preventDefault();

        //the ajax call.
        $.ajax({

            //the settings of the ajax call.
            method: "POST",
            url: itemForm.attr("data-action"),
            data: itemForm.serialize(),
            timeout: 3000,
            dataType: "json",
            encode: true
        }).done(function(msg) {

            //the ajax call is successfully done.

            //check if a redirect URL is available.
            if (msg.redirect.toString().trim() !== "") {
                $(location).attr("href", msg.redirect);
            } else {

                //set the available bootstrap log levels.
                var bootstrapLogLevel = ["success", "info", "warning", "danger"];

                //show the alert of the form with color of log level.
                if (msg.state === "error") {
                    removeAlertStateClasses(itemFormAlert);
                    itemFormAlert.addClass("alert-danger").html(msg.message);
                } else if (bootstrapLogLevel.indexOf(msg.state) > -1) {
                    removeAlertStateClasses(itemFormAlert);
                    itemFormAlert.addClass("alert-" + msg.state).html(msg.message);
                } else {
                    removeAlertStateClasses(itemFormAlert);
                    itemFormAlert.addClass("alert-info").html(msg.message);
                }

                //show the alert with warning (only if a message is available).
                if (itemFormAlert.html.toString().trim() !== "") {
                    itemFormAlert.show();
                }

                //additionaly set the focus if a field is available.
                if (msg.field.toString().trim() !== "") {
                    $("input[name='" + msg.field + "']").focus();
                }
            }
        }).fail(function() {

            //the ajax call was not successfully.
            itemFormAlert.addClass("alert-danger").html("Something went wrong. Try again later!");
            itemFormAlert.show();
        });
    });

    //get the upload element, if available.
    var inputImageUpload = $("form.picvid-file-upload input#files");

    //check whether the upload exists.
    if (inputImageUpload !== undefined) {
        console.log(inputImageUpload);
        var inputImageLabel = $("label[for='files']");
        var labelDefaultValue = inputImageLabel.html();

        //on change of the upload we update the label.
        inputImageUpload.bind("change", function(e) {
            var filename = "";

            //check whether multiple files are available.
            if (this.files && this.files.length > 1) {
                filename = this.files.length + " files selected";
            } else {
                filename = e.target.value.split("\\").pop();
            }

            //check whether a filename exists.
            if (filename) {
                inputImageLabel.find("span").text(filename);
            } else {
                inputImageLabel.html(labelDefaultValue);
            }
        });
    }

    /** code to upload the images with additional information with AJAX. */
    var formUploadImage = $('form.picvid-file-upload');
    var uploadAlert = $('form.picvid-file-upload div.alert');
    uploadAlert.hide();

    //remove the state classes.
    removeAlertStateClasses(uploadAlert);

    //the function which is called on submit.
    formUploadImage.on('submit', function(event) {
        event.preventDefault();

        //get the form items.
        var btnUpload = $('form.picvid-file-upload button');
        var spanUploadInfo = $('form.picvid-file-upload label span');
        var inpUpload = $('form.picvid-file-upload input#files');
        var inpImageTitle = $("form.picvid-file-upload input[name='image_title']");
        var inpImageDescription = $("form.picvid-file-upload textarea[name='image_description']");
        var inpToken = $("form.picvid-file-upload input[name='token']");

        //while uploading the file rename the button.
        btnUpload.html('Uploading...');

        //get the images of the input item and init the form data.
        var files = inpUpload[0].files;
        var formData = new FormData();

        //run through all images of the input.
        for (var i = 0; i < files.length; i++) {
            var file = files[i];

            //check the file type of the image.
            if (!file.type.match('image.*')) {
                continue;
            }

            //add the file to the request.
            formData.append('image_upload[]', file, file.name);
        }

        //set the additional information of the upload.
        formData.set('image_title', inpImageTitle.val());
        formData.set('image_description', inpImageDescription.val());
        formData.set('token', inpToken.val());

        //set up the request to send the information to the backend.
        var xhr = new XMLHttpRequest();
        xhr.open('POST', formUploadImage.attr('data-action'), true);

        //on success of the request do the following stuff.
        xhr.onload = function () {
            if (xhr.status === 200) {
                btnUpload.html('Upload');
                spanUploadInfo.html('Choose a file...');
                uploadAlert.html('Upload was sucessfull!');
                uploadAlert.addClass('alert-success');
                uploadAlert.show();
            } else {
                uploadAlert.html('Upload was not sucessfull!');
                uploadAlert.addClass('alert-danger');
                uploadAlert.show();
            }
        };

        //on error of the request do the following stuff.
        xhr.onerror = function () {
            uploadAlert.html('An error occured!');
            uploadAlert.addClass('alert-danger');
            uploadAlert.show();
        };

        //send the request with files and additional information.
        xhr.send(formData);
    });
});

/**
 * Function to remove all state classes from an HTML element.
 * @param alertItem The HTML element to remove the classes.
 * @return void
 */
function removeAlertStateClasses(alertItem)
{
    alertItem.removeClass('alert-primary');
    alertItem.removeClass('alert-secondary');
    alertItem.removeClass('alert-success');
    alertItem.removeClass('alert-danger');
    alertItem.removeClass('alert-warning');
    alertItem.removeClass('alert-info');
    alertItem.removeClass('alert-light');
    alertItem.removeClass('alert-dark');
}