$(document).ready(function () {
    $('#editaCredito').on('show.bs.modal', function (e) {
        var documento = $(e.relatedTarget).data('doc');
        $.ajax({
            type: 'post',
            url: 'editarDebito.php',
            data: 'documento=' + documento,
            success: function (data) {
                $('.fetched-data').html(data);
            }
        });
    });
});


