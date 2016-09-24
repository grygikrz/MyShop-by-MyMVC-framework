$(".pop").each(function() {
    var $pElem= $(this);
    $pElem.popover(
        {
        html: true,
        container: 'body',
		placement: 'bottom',
		animation: false,
        content: getPopContent($pElem.attr("id"))
        }
    );
});
		
function getPopContent(target) {
    return $("#" + target + "_content > div.popContent").html();
};

$('button').on('click', function() {
    whichtab = $(this).data('opentab');
    $('#myModal').modal('show');
    $('.nav-tabs li:eq('+whichtab+') a').tab('show');
});