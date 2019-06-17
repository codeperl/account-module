
/**
 *
 */
$(document).ready(function() {
    $(".delete").on("submit", function () {
        return confirm("Do you want to delete this item?");
    });

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