$(function () {

    // init the validator
    // validator files are included in the download package
    // otherwise download from http://1000hz.github.io/bootstrap-validator

    $('#login-form').validator();
    $('#register-form').validator();

    // when the form is submitted
    // $('#login-form').on('submit', function (e) {

    //     // if the validator does not prevent form submit
    //     if (!e.isDefaultPrevented()) {
    //         var url = "/signin";

    //         // POST values in the background the the script URL
    //         $.ajax({
    //             type: "POST",
    //             url: url,
    //             data: $(this).serialize(),
    //             success: function (data)
    //             {
    //                //
    //             }
    //         });
    //         return false;
    //     }
    // })

    // $('#register-form').on('submit', function (e) {

    //     // if the validator does not prevent form submit
    //     if (!e.isDefaultPrevented()) {
    //         var url = "/register";

    //         // POST values in the background the the script URL
    //         $.ajax({
    //             type: "POST",
    //             url: url,
    //             data: $(this).serialize(),
    //             success: function (data)
    //             {
    //                //
    //             }
    //         });
    //         return false;
    //     }
    // })
});