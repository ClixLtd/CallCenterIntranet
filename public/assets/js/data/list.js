$(function () {

    $('#softReset').click(function() {

        listID = $(this).attr('rel');

        $( "#dialog-confirm" ).dialog({
            resizable: false,
            height:180,
            width: 500,
            modal: true,
            buttons: {
                "Reset List": function() {
                    resetResult = $.getJSON('/data/softresetlist/'+listID +'.json');
                    $( this ).dialog( "close" );
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });

    })





});