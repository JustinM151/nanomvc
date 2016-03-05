$(document).ready(function() {
    $('.click-show-hide').click(function(){

        $($(this).attr('targetid')).slideToggle();
    });

});
