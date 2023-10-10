/* 
     $(document).bind("mobileinit", function(){
//        $.mobile.loadingMessageTheme = "b";
        $.mobile.loadingMessageTextVisible = true;
        $.mobile.loadingMessage = "loading...";

        $.mobile.listview.prototype.options.autodividersSelector = 
            function( elt ) {
                var text = $.trim( elt.text() ) || null;
                if ( !text ) {
                    return null;
                }
                if ( text.slice( 0, 1 )=="Š" ) {
                    return "S";
                //} 
                //else if ( text.slice( 0, 1 )=="Č" ) {
                //   return "C";
                } else {
                    text = text.slice( 0, 1 ).toUpperCase();
                    return text;
                }
            };                
    });
 */
$.mobile.loading("show", {
    text: 'loading...',
    textVisible: true,
    theme: 'a',
    html: '<img src="images/icons/favicon152x152.png> <br> loading..."'
});

// I am using this to reload maps because otherwise in some devices it won't start
// from Bologna
function reloadAfterTime(timesec = 1500) {
    console.log("reload");
    setTimeout(() => {
        location.reload();
    }, timesec);
}


// get specific talk
function getTalk(authornamesurname) {
    document.getElementById(authornamesurname).scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function getTalkLater(authornamesurname) {
    setTimeout(() => {
        getTalk(authornamesurname);
        $("#" + authornamesurname).css("background-color", "#FFFFCC");
    }, 1000);
    setTimeout(() => {
        $("#" + authornamesurname).css("background-color", "#FFFFFF");
    }, 3000);
}



$(document).ready(function () {
    //        $('.loginbutton').click(function() {  
    $(".loginbutton").on('click', function () {

        // since all login forms in all pages are rendered, we need to find the
        // relevant one

        // get me value of the item with "codeinput" in the parent <form>
        var inputvalue = $(this).closest('form').find("[name='p']").val();

        //var inputvalue = $("#input").val();
        window.location.replace("#/?p=" + inputvalue);

        location.href = "/?p=" + inputvalue;
    });
});
