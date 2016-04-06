$(document).ready(function() {
    // Variable to hold request
    var request;
    // Bind to the submit product information process
    $("#product-information-form").submit(function(event){
        // Abort any pending request
        if (request) {
            request.abort();
        }

        var $form = $(this);
        // select and cache all the fields
        var $inputs = $form.find("input, select, button, textarea");
        // Serialize the data in the form
        var formData = new FormData($(this)[0]);


        $inputs.prop("disabled", true);
        //get csrf-token from meta
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        request = $.ajax({
            url: "/productInformationPostRequest",
            type: "POST",
            data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData: false        // To send DOMDocument or non processed data file it is set to false
        });
        // Callback handler that will be called on success
        request.done(function (response){

            //$('#product-info-response').html(response);
             $('#debug-box').html(response);

        });
        // Callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown){
            // Log the error to the console
            $('#debug-box').append(
                "The following error occurred: "+
                textStatus, errorThrown
            );
        });
        // Callback handler that will be called regardless
        // if the request failed or succeeded
        request.always(function () {
            // Reenable the inputs
            $inputs.prop("disabled", false);
        });
        // Prevent default posting of form
        event.preventDefault();
    });

    $("#shipment-information-form").submit(function(event){
        // Abort any pending request
        if (request) {
            request.abort();
        }

        var $form = $(this);
        // select and cache all the fields
        var $inputs = $form.find("input, select, button, textarea");
        // Serialize the data in the form
        var formData = new FormData($(this)[0]);


        $inputs.prop("disabled", true);
        //get csrf-token from meta
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        request = $.ajax({
            url: "/shipmentInformationPostRequest",
            type: "POST",
            data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData: false        // To send DOMDocument or non processed data file it is set to false
        });
        // Callback handler that will be called on success
        request.done(function (response){

            $('#shipment-info-response').html(response);
            $('#debug-box').html(
                '<div class="alert alert-success fade in">'+
                    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                    '<strong>Success</strong>'+
                '</div>'
                );
        });
        // Callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown){
            // Log the error to the console
            $('#debug-box').html(
                '<div class="alert alert-danger fade in">'+
                    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                    '<strong>Failed</strong>'+ textStatus, errorThrown +
                '</div>'
            );
        });
        // Callback handler that will be called regardless
        // if the request failed or succeeded
        request.always(function () {
            // Reenable the inputs
            $inputs.prop("disabled", false);
        });
        // Prevent default posting of form
        event.preventDefault();
    });

});