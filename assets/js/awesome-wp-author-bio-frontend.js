/* This is frontend js */

jQuery(document).ready(function ($) {
      $('#jeweltheme-wp-author-tab').easyResponsiveTabs();

    // For Mouse Hover Effect        
      $('.jeweltheme-wp-author-image img').mousemove(function(event) { 
          var left = event.pageX - $(this).offset().left +50;
          var top = event.pageY - $(this).offset().top + -20;
          $('#hover-description').css({top: top,left: left}).show();
          console.log (left, top);
      });
      
      $('.jeweltheme-wp-author-image img').mouseout(function() {
         $('#hover-description').hide();
     });

});