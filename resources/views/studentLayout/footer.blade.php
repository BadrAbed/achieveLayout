<div id="exampleModalLive" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 1200px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel"> معنى الكلمة </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                <div id="asd">

                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    <div class="row">
        <div class="col-md-6">
            <h5>جميع الحقوق محفوظة © kalemon 2017</h5>
        </div>
        <div class="col-md-6 social">
            <a href="">
                <i class="fa fa-facebook" aria-hidden="true"></i>
            </a>
            <a href="">
                <i class="fa fa-google-plus" aria-hidden="true"></i>
            </a>
            <a href="">
                <i class="fa fa-linkedin" aria-hidden="true"></i>
            </a>
            <a href="">
                <i class="fa fa-twitter" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</div>
<a href="javascript:" id="return-to-top">
    <i class="fa fa-angle-up" aria-hidden="true"></i>
</a>


<div id="exampleModalLive" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 1200px; ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel"> معنى الكلمة </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                <div id="asd">

                </div>
            </div>
        </div>
    </div>
</div>


<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{asset('Studentpublic/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('Studentpublic/js/popper.js')}}"></script>
<script src="{{asset('Studentpublic/js/bootstrap.min.js')}}"></script>
<script src="{{asset('Studentpublic/js/stellar.js')}}"></script>
<script src="{{asset('Studentpublic/js/countdown.js')}}"></script>
<script src="{{asset('Studentpublic/plugins/nice-select/js/jquery.nice-select.min.js')}}"></script>
<script src="{{asset('Studentpublic/plugins/owl-carousel/owl.carousel.min.js')}}"></script>
<script src="{{asset('Studentpublic/js/owl-carousel-thumb.min.js')}}"></script>
<script src="{{asset('Studentpublic/js/jquery.ajaxchimp.min.js')}}"></script>
<script src="{{asset('Studentpublic/plugins/counter-up/jquery.counterup.js')}}"></script>
<script src="{{asset('Studentpublic/js/mail-script.js')}}"></script>
<!--gmaps Js-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
<script src="{{asset('Studentpublic/js/gmaps.min.js')}}"></script>
<script src="{{asset('Studentpublic/js/theme.js')}}"></script>
<script src="{{asset('Studentpublic/js/main.js')}}"></script>

{{--  --}}
<script>
// document.ready(function () {
//      var x = document.getElementsByTagName('body').innerHTML;
//      x = x.replace("","ﷺ");
//     document.getElementsByTagName('body').innerHTML = x;
// });
    // $('body').bind("contextmenu", function (e) {
    //     e.preventDefault();
    //     var top = e.pageY;
    //     $("#cntnr").css("left", e.pageX);
    //     $("#cntnr").css("top", top);
    //     // $("#cntnr").hide(100);
    //     $("#cntnr").fadeIn(200, startFocusOut());
    //
    //
    // });
    $('body').bind("contextmenu", function (e) {
        e.preventDefault();
        var top = e.pageY;

        $("#cntnr").css("left", e.clientX);
        $("#cntnr").css("top", e.clientY);
        // $("#cntnr").hide(100);
        $("#cntnr").fadeIn(200, startFocusOut());


    });

    function startFocusOut() {
        $(document).on("click", function () {
            $("#cntnr").hide();
            $(document).off("click");
        });
        $(window).scroll(function () {
            $('#cntnr').fadeOut();
        })
    }


    $("#items > li").click(function () {
        $("#op").text("You have selected " + $(this).text());
    });

</script>

<script>
    if (!window.x) {
        x = {};
    }
    x.Selector = {};
    x.Selector.getSelected = function () {
        var t = '';
        if (window.getSelection) {
            t = window.getSelection();
        } else if (document.getSelection) {
            t = document.getSelection();
        } else if (document.selection) {
            t = document.selection.createRange().text;
        }
        return t;
    };

    function a() {
        console.log("as");
        var mytext = x.Selector.getSelected();
        $.ajax({
            type: "GET",
            url: "http://www.analyzer.ga:8082/WebApplication1/faces/Api.xhtml?pram=" + encodeURIComponent(mytext),
            crossDomain: true,
            async: true,
            success: function (data) {

                $("#asd").html(data);
                $("#exampleModalLive").modal();
            }
        });
    }

</script>
@yield('js')


</body>
</html>