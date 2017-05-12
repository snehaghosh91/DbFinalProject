$(document).ready(function() {

    // process the form
    $('form').submit(function(event) {

        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
        event.preventDefault();
        var $form    = $(event.target),
        formData = new FormData(),   
        params   = $form.serializeArray(),
        files    = $form.find('[name="projmedia"]')[0].files,
        countoffiles = 0;

        $.each(files, function(i, file) {
            countoffiles += 1;
            formData.append('projmedia' + i, file);
        });
        formData.append('countoffiles', countoffiles);
        $.each(params, function(i, val) {
            formData.append(val.name, val.value);
        });
        
        // process the form
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'addupdate.php', // the url where we want to POST
            data        :  formData,
            cache       :  false,
            contentType :  false,
            processData :  false
        })
            // using the done promise callback
            .done(function(data) {

                // log data to the console so we can see
                console.log(data); 

                // here we will handle errors and validation messages
            });

        
    });

});