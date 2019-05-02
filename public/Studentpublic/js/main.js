$(document).ready(function() {
    console.log("ready!");
    //=====  Fixed Header ===== 
    $(window).scroll(function() {
        if ($(window).scrollTop() >= 10) {
            $('#header').addClass('fixed-header');
            // $('nav div').addClass('visible-title');
        } else {
            $('#header').removeClass('fixed-header');
            // $('nav div').removeClass('visible-title');
        }
    });
    //=====  #Fixed Header ===== 
    //=====  Table ===== 
    $(".table-users tr td i.fa-spinner").parent().parent().addClass("progress2");
    $(".table-users tr td i.fa-times-circle").parent().parent().addClass("disabled");
    $(".table-users tr").each(function() {
        if ($(this).hasClass("disabled")) {
            $(this).removeAttr("onclick");
        }
    });
    //=====   #Table ===== 
    //=====  Slider Arrows ===== 
    $(".next").click(function() {
        $(".imgs").append($(".imgs a:first-of-type"));
    });

    $(".prev").click(function() {
        $(".imgs").prepend($(".imgs a:last-of-type"));
    });
    // 
    $(".points .left").click(function() {
        $(".points_slide").append($(".points_slide .point:first-of-type"));
    });

    $(".points .right").click(function() {
        $(".points_slide").prepend($(".points_slide .point:last-of-type"));
    });
    //=====  #Slider Arrows ===== 
    //===== Slider Dots ===== 
    $(".dots .dot").hover(
        function() {
            $(this).append($("<span></span>"));
        },
        function() {
            $(this).find("span:last").remove();
        }
    );
    $(".dots .dot").click(function() {
        $(".imgs").append($(".imgs a:first-of-type"));
    });
    $(".dots .dot.first:child").click(function() {
        $(".imgs").prepend($(".imgs a:last-of-type"));
    });
    //===== #Slider Dots =====
    // ===== Scroll to Top ====
    // $(window).scroll(function() {
    //     if ($(this).scrollTop() >= 50) { // If page is scrolled more than 50px
    //         $('#return-to-top').fadeIn(200); // Fade in the arrow
    //     } else {
    //         $('#return-to-top').fadeOut(200); // Else fade out the arrow
    //     }
    // });
    $('#return-to-top').click(function() { // When arrow is clicked
        $('body,html').animate({
            scrollTop: 0 // Scroll to top of body
        }, 500);
    });
    // ===== #Scroll to Top ====
    // ===== Tabs ====
    $('.article ul.tabs li').click(function() {
        var tab_id = $(this).attr('data-tab');

        $('.article ul.tabs li').removeClass('current');
        $('.article ul.tabs li.current span.current').removeClass('current');
        //
        $('.article .tab-content').removeClass('current');
        //
        // // this = ul.tabs li
        $(this).addClass('current');
       $("#" + tab_id).addClass('current');
    });
    // ===== #Tabs ====
    // ===== Nxt_Tab ====
    $('#nxt_tab').click(function() {
        $('.s_viewLesson ul.tabs > .current ').next('li').toggleClass('current');
    });
    // ===== #Nxt_Tab ====
    //  ===== Increase/descrease font size ====
    $('#increasetext').click(function() {
        curSize = parseInt($('#content p').css('font-size')) + 2;
        if (curSize <= 32)
            $('#content p').css('font-size', curSize);
    });

    $('#resettext').click(function() {
        if (curSize != 18)
            $('#content p').css('font-size', 18);
    });

    $('#decreasetext').click(function() {
        curSize = parseInt($('#content p').css('font-size')) - 2;
        if (curSize >= 14)
            $('#content p').css('font-size', curSize);
    });
    // ===== #Increase/descrease font size ====

});