$(document).ready(function() {

    //define the ajax object.
    var msgObject = {};
    msgObject.redirect = "";
    msgObject.state = "";
    msgObject.message = "";
    msgObject.field = "";

    //the submit event.
    $("form.ajax").on("submit", function(e) {
        e.preventDefault();

        //get the alert item on the form to outut the messages.
        var itemFormAlert = $(this).find(".alert");

        //the ajax call.
        $.ajax({

            //the settings of the ajax call.
            method: "POST",
            url: $(this).attr("data-action"),
            data: $(this).serialize(),
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

            //remove all the password values of the form.
            removePasswordValues($("form.ajax"));
        }).fail(function(xhr, status, error) {

            //output the error details on console.
            console.log(status, error, xhr);

            //the ajax call was not successfully.
            itemFormAlert.addClass("alert-danger").html("Something went wrong. Try again later!");
            itemFormAlert.show();

            //remove all the password values of the form.
            removePasswordValues($("form.ajax"));
        });
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

/**
 * Function to remove all values on the password fields of a form.
 * @param formElement The form element to remove all the values of the password fields.
 * @return void
 */
function removePasswordValues(formElement)
{
    $(formElement).find("input[type=password]").val('');
}