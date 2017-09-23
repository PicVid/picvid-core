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
});

/**
 * Function to remove all state classes from an HTML element.
 * @param alertItem The HTML element to remove the classes.
 */
function removeAlertStateClasses(alertItem)
{
    alertItem.removeClass("alert-danger");
    alertItem.removeClass("alert-success");
    alertItem.removeClass("alert-info");
    alertItem.removeClass("alert-warning");
}