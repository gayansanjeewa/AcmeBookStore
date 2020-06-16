$(document).ready(function () {
    $('.add-to-cart').on('click', function ($e) {

        $e.preventDefault();

        let uuid = $(this).data('uuid');
        let url = $(this).data('url');

        console.log(url);

        $.ajax({
            url: url,
            type: 'POST',
            data: {uuid: uuid},
            success: function (data) {

                console.log(data);

                $('#shopping-cart span.cart-total').text(data['total']);
                $('#shopping-cart span.cart-quantity').text(data['quantity']);
            }
        });
    });
});