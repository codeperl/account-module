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
 * @param httpCommand
 * @param mssgWrapperCallback
 */
function formSubmission(evnt, elem, httpCommand, mssgWrapperCallback)
{
    $(""+elem).on(evnt, function(e) {
        e.preventDefault();
        var $this = $(this);
        var action = $this.attr('action');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: action,
            data: $this.serialize(),
            dataType: 'json',
            type: httpCommand,
            success: function(data) {
                $('#message').html(mssgWrapperCallback('success', data.message.success));
                $this.trigger("reset");
            },
            error: function(jqXhr, textStatus, errorThrown){
                var message = jqXhr.responseJSON.message;
                if(jqXhr.responseJSON.errors !== undefined) {
                    var specificMessages = jqXhr.responseJSON.errors;

                    for (var obj1 in specificMessages) {
                        var obj2 = specificMessages[obj1];
                        if(obj2 !== undefined) {
                            for(var obj3 in obj2) {
                                var obj4 = obj2[obj3];
                                if(obj4) {
                                    message+="<br />"+obj4;
                                }
                            }
                        }

                    }
                }

                $('#message').html(mssgWrapperCallback('danger', message));
            }
        });
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

function showModal(elem)
{
    $(elem).modal({
        show : true
    });
}

$(document).ready(function() {
    $(".delete").on("submit", function () {
        return confirm("Do you want to delete this item?");
    });

    formSubmission('submit', "form[name='assign-resource-to-permission']", 'post', messageWrapper);
});
