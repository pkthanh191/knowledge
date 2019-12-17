jQuery(document).ready(function(){
    jQuery(".submenu-indicator").click(function() {
        if (!jQuery(this).hasClass('expand')) {
            jQuery(this).parent().addClass( "active");
            jQuery(this).parent().children('ul').css( "display","block");
            jQuery(this).addClass('expand');
            jQuery(this).html('<i class="fa fa-minus"></i>');
        }
        else {
            jQuery(this).parent().removeClass( "active");
            jQuery(this).parent().children('ul').css( "display","none");
            jQuery(this).removeClass('expand');
            jQuery(this).html('<i class="fa fa-plus"></i>');
        }
    });

});