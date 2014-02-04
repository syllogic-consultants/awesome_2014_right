/* hook up the Sidr functionality */

(function($) {

$(document).ready(function(){

// hook up the left side menu

$("#menu-toggle").sidr({
name: "slideout",
side: "left",
displace: false,
});

});

})(jQuery);