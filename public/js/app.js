function toggleTab(item) {
    document.getElementById(item).classList.toggle('hidden');
}

function timeout(item) {
    let elem = document.getElementById(item);
    setTimeout(function () {
        elem.hide();
    }, 1000);
}

function checkEmailAvailability(email) {
    $.ajax({
        url: "/check-email-availability",
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            email: email
        },
        success: function (response) {
            if (response.available) {
                $('#email-availability-message').text('Email is available!');
                $('#email-availability-message').css('color', 'green');
            } else {
                $('#email-availability-message').text('Email is already in use!');
                $('#email-availability-message').css('color', 'red');
            }
        },
        error: function (error) {
            console.error("Error checking email availability:", error);
            $('#email-availability-message').text('Error checking email availability.');
            $('#email-availability-message').css('color', 'red');
        }
    });
}
function findEmail(email) {
    $.ajax({
        url: "/find-email",
        method: "GET",
        data: {
            email: email
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.available) {
                $('#email-find-message').text('Email found!');
                $('#email-find-message').css('color', 'green');
            } else {
                $('#email-find-message').text('Email not found!');
                $('#email-find-message').css('color', 'red');
            }
        },
        error: function (error) {
            console.error("Error finding email:", error);
            $('#email-find-message').text('Error finding email!');
            $('#email-find-message').css('color', 'red');
        }
    });
}

function findStockId(stockId) {
    $.ajax({
        url: "/find-stock-id",
        method: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            stockId: stockId
        },
        success: function (response) {
            if (response.available) {
                $('#stockid-find-message').text('Stock Id Found!');
                $('#stockid-find-message').css('color', 'green');
            } else {
                $('#stockid-find-message').text('Stock Id not found or already reserved!');
                $('#stockid-find-message').css('color', 'red');
            }
        },
        error: function (error) {
            console.error("Error finding email:", error);
            $('#stockid-find-message').text('');
            $('#stockid-find-message').css('color', 'red');
        }
    });
}