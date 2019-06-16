$('#generate-resources').on('click', function(e) {
    e.preventDefault();
    var $this = $(this);
    var href = $this.attr('data-href');

    $.ajax({
        url: href,
        data: {"_token": $('meta[name="csrf-token"]').attr('content')},
        dataType: 'json',
        type: 'post',
        success: function(data) {
            $('#resources-placeholder').html(data.resources);
        },
        error: function(jqXhr, textStatus, errorThrown){
            console.log(errorThrown);
        }
    });
});