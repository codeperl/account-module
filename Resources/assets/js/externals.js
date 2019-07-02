function showModal(elem)
{
    $(elem).modal({
        show : true
    });
}

function show(evnt, elem, modalElem, dynamicDataContainerElem)
{
    $(elem).on(evnt, function(e) {
        e.preventDefault();

        var $this = $(this);
        var href = $this.attr('data-href');

        $.ajax({
            url: href,
            dataType: 'json',
            type: 'get',
            success: function(data) {
                showModal(modalElem, $(modalElem+' '+dynamicDataContainerElem).html(data.html));
            },
            error: function(jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    });
}

$(document).ready(function() {
    $('[data-toggle="ajaxtab"]').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        var urlToLoad = $this.attr('data-href');
        var tabContent = $this.attr('data-target');

        $.get(urlToLoad, function (data) {
            $(tabContent).html(data);
        });

        $(this).tab('show');
    });

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
                $('#authorization-placeholder').html(data.resources);
            },
            error: function(jqXhr, textStatus, errorThrown){
                console.log(errorThrown);
            }
        });
    });

    show('click', '.show-resource', '#bootstrap-modal-placeholder-account', '#modal-content');
});