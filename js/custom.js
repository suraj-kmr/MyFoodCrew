/* Navigation */

$(document).ready(function(){
   $(".has_sub > a").click(function(e){
    e.preventDefault();
    var menu_li = $(this).parent("li");
    var menu_ul = $(this).next("ul");

    if(menu_li.hasClass("open")){
      menu_ul.slideUp(350);
      menu_li.removeClass("open")
    }
    else{
      $("#nav > li > ul").slideUp(350);
      $("#nav > li").removeClass("open");
      menu_ul.slideDown(350);
      menu_li.addClass("open");
    }
  });
});

$(document).ready(function(){
  $(".sidebar-dropdown a").on('click',function(e){
      e.preventDefault();

      if(!$(this).hasClass("open")) {
        // open our new menu and add the open class
        $(".sidebar #nav").slideDown(350);
        $(this).addClass("open");
      }
      
      else{
        $(".sidebar #nav").slideUp(350);
        $(this).removeClass("open");
      }
  });
    $('.wclose').click(function(e){
        e.preventDefault();
        var $wbox = $(this).parent().parent().parent();
        $wbox.fadeOut(100);
    });
    /* Widget minimize */
    $('.wminimize').click(function(e){
        e.preventDefault();
        var $wcontent = $(this).parent().parent().next('.widget-content');
        if($wcontent.is(':visible'))
        {
            $(this).children('i').removeClass('fa fa-chevron-up');
            $(this).children('i').addClass('fa fa-chevron-down');
        }
        else
        {
            $(this).children('i').removeClass('fa fa-chevron-down');
            $(this).children('i').addClass('fa fa-chevron-up');
        }
        $wcontent.toggle(500);
    });
});
