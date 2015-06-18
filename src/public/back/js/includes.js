$(document).ready(function() {

    //Medias modal
    $('body').on('click', '.open-medias-modal', function() {
        var modal = $('#medias-modal');
        modal.attr('data-div-id', $(this).attr('data-div-id'));
        $(modal).modal('show');
    });

    $('body').on('click', '.popup-media-id', function(e) {
        e.preventDefault();

        var media_id = $(this).attr('data-id');
        var media_name = $(this).attr('data-name');
        var media_src = $(this).attr('data-src');
        var div_id = $('#medias-modal').attr('data-div-id');

        var div = $('#' + div_id);
        div.find('.mediaID').val(media_id);
        div.find('.media-name').text(media_name);
        div.find('.thumbnail img').attr('src', media_src);
        $('#medias-modal').modal('hide');
    });
})