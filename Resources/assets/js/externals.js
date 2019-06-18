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
});