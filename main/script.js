jQuery(document).ready(function() {
    jQuery(".zappkacode_block").each(function(index) {
        jQuery(this).dblclick(function(event) {
            var id = jQuery(this).data("kodid");
            var usesleft = jQuery(this).data("usesleft");
            var info = jQuery(this).data("info");
            var left = usesleft-1;

            jQuery(this).data("usesleft", left);

            $.get("?lowid=" + id, function(data) { console.log(data) });

            if(left == 0) {
                jQuery(".updateme").text(jQuery(".updateme").text()-1);

                const fade = { opacity: 0, transition: 'opacity 400ms' };
                jQuery(this).css(fade).slideUp();
            } else {
                jQuery(this).find("span").text("" + info + " - " + left)
            }
        }); 
    })
})