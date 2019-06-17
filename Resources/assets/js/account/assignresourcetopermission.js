$(document).ready(function() {
    formSubmission('submit', "form[name='assign-resource-to-permission']", messageWrapper);
});

/**
 *
 * @param messageType
 * @param message
 * @returns {string}
 */
function messageWrapper(messageType, message)
{
    return "<div class=\"alert alert-"+messageType+" fade in alert-dismissible show\">\n" +
        "        <div>"+message+"</div>\n" +
        "        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
        "            <span aria-hidden=\"true\" style=\"font-size:20px\">×</span>\n" +
        "        </button>\n" +
        "    </div><br />";
}

/**
 *
 * @param evnt
 * @param elem
 * @param mssgWrapperCallback
 */
function formSubmission(evnt, elem, mssgWrapperCallback)
{
    $(""+elem).on(evnt, function(e) {
        e.preventDefault();
        var $this = $(this);
        var action = $this.attr('action');

        $.ajax({
            url: action,
            data: $this.serialize(),
            dataType: 'json',
            type: 'post',
            success: function(data) {
                $('#message').html(mssgWrapperCallback('success', data.message.success));
                $this.trigger("reset");
            },
            error: function(jqXhr, textStatus, errorThrown){
                var message = jqXhr.responseJSON.message;
                var specificMessages = jqXhr.responseJSON.errors.name;
                specificMessages.forEach(function(item, index) {
                    message+="<br />"+item;
                });

                $('#message').html(mssgWrapperCallback('danger', message));
            }
        });
    });
}