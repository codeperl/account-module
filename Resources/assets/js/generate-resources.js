$('#generate-resources').on('click', function() {
    var $this = $(this);
    var href = $this.attr('data-href');

    $.ajax({
        url: href,
        data: {"_token": $('meta[name="csrf-token"]').attr('content')},
        dataType: 'json',
        type: 'post',
        success: function(data) {
            console.log('hello');
            $('#resources-placeholder').html(data.resources);
        },
        error: function(jqXhr, textStatus, errorThrown){
            console.log(errorThrown);
        }
    });
});