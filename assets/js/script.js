$(document).ready(function () {

    flatpickr("#bkDate", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today",
    });

    var modal = document.getElementById("modal");
    var btn = document.querySelector(".demo-btn");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function () {
        modal.style.display = "block";
    }

    span.onclick = function () {
        modal.style.display = "none";
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    var form = document.getElementById("demo-form");
    form.addEventListener("submit", function (event) {
        event.preventDefault();

        var formData = new FormData(form);

        // var templateParams = {
        //     from_name: formData.get("name"),
        //     from_email: formData.get("email"),
        //     book_date: formData.get("bkDate"),
        //     message:
        //         "Name: " +
        //         formData.get("name") +
        //         "\n" +
        //         "Email: " +
        //         formData.get("email") +
        //         "\n" +
        //         "Date Booked: " +
        //         formData.get("bkDate") +
        //         "\n" +
        //         "Company: " +
        //         formData.get("company"),
        // };

        // var loader = document.getElementById("loader");
        // loader.style.display = "block";

        // emailjs
        //     .send(
        //         "service_ljxpc0l",
        //         "template_yv0qmdm",
        //         templateParams,
        //         "cFE64iG9AMWFFEHhp"
        //     )
        //     .then(
        //         function (response) {
        //             loader.style.display = "none";
        //             Toastify({
        //                 text: "Booked successfully.",
        //                 duration: 3000,
        //                 close: true,
        //                 backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
        //             }).showToast();
        //             form.reset();
        //             modal.style.display = "none";
        //         },
        //         function (error) {
        //             loader.style.display = "none";
        //             Toastify({
        //                 text: "Unable to complete booking",
        //                 duration: 3000,
        //                 close: true,
        //                 gravity: "top",
        //                 position: "center",
        //                 backgroundColor: "linear-gradient(to right, #FF3E4D, #FFA34F)",
        //             }).showToast();
        //         }
        //     );

        var loader = document.getElementById("loader");
        loader.style.display = "block";

        $.ajax({
            type: 'POST',
            url: './email_handler?action=booking',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                loader.style.display = "none";
                if (response.success) {

                    Toastify({
                        text: response.message,
                        duration: 3000,
                        close: true,
                        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                    }).showToast();
                    form.reset();
                    modal.style.display = "none";

                } else {
                    Toastify({
                        text: response.message,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "linear-gradient(to right, #FF3E4D, #FFA34F)",
                    }).showToast();
                }
            },
            error: function (xhr, status, error) {
                loader.style.display = "none";
                // console.log(xhr);
                Toastify({
                    text: "An unexpected error occurred.",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "linear-gradient(to right, #FF3E4D, #FFA34F)",
                }).showToast();
            }
        });
    });
});