/**
 * Created by justin on 12/21/15.
 *
 * We fade things!
 */
$(document).ready(function() {
    $('.fader').hover(function() {
        $(this).find('span').animate({
            top: 50,
            left: 50,
            opacity: 1
        },250,function(){});

        $(this).find('img').animate({
            opacity: 0.25
        },250,function() {
            //done
        });

    }, function() {
        $(this).find('span').animate({
            top: 0,
            left: 0,
            opacity: 0
        },250,function(){});

        $(this).find('img').animate({
            opacity: 1
        },250,function() {
            //done
        });
    });


});
