// apostropheReady is called at domReady
// it hooks into the a_js javascript framework
// it can be used for progressive enhancements at runtime
// such as Cufon text replacement

function apostropheReady()
{
    // Alice
    //$('#alice').addClass('eclatee');
    $('#alice').animate({'opacity':1}, {
        duration: 5000,
        complete: function(){

        }
    });


    window.setTimeout(
        function() {
            $('#alice').removeClass('eclatee');
        },
        2000
    );


    $('#ni_menu .itm_cont').bind('mouseenter', function(){
        $('#alice').addClass('eclatee');
    });

    $('#ni_menu .itm_cont').bind('mouseleave', function(){
        $('#alice').removeClass('eclatee');
    });

    //$('#alice').removeClass('eclatee').delay(5000);

}

