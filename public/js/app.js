$(document).ready(function () {
    $('.js-add-to-cart').on('click', function ($e) {

        $e.preventDefault();

        let uuid = $(this).data('uuid');
        let url = $(this).data('url');

        $.ajax({
            url: url,
            type: 'POST',
            data: {uuid: uuid},
            success: function (data) {
                $('#js-shopping-cart span.js-cart-total').text(data['total']);
                $('#js-shopping-cart span.js-cart-quantity').text(data['quantity']);
            }
        });
    });

    $('.js-add-coupon-code').on('click', function ($e) {

        $e.preventDefault();

        let url = $(this).data('url');
        let couponCode = $(this).parent().parent().find('.js-coupon-code').val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {couponCode: couponCode},
            success: function (data) {
                $('#js-shopping-cart span.js-cart-total').text(data['total']);
                $('#js-shopping-cart span.js-cart-quantity').text(data['quantity']);
            }
        });
    });
});