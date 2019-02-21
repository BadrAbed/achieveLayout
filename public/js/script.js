var i = 0;
$(document).ready(function () {
    console.log('ready from script');
    $('label.tree-toggler').click(function () {
        $(this).parent().children('ul.tree').fadeToggle(150);
    });

    $('.ui.dropdown').dropdown();
    new WOW().init();

    //Start Adding Questions
    var linkIndex = 1;
    newQuestion = 1;
    newdiv = 1;
    indexOfArr = 0;
    $("#addQuestion_f").click(function (e) {
        e.preventDefault();
        newQuestion++;
        indexOfArr++;
        newdiv++;
        $("#newquest").append("<div id=\"links[" + linkIndex + "]\"><div class='row form-group' ><div class='col-md-2'><label for='question' class='col-form-label' >السؤال</label></div><div class='col-md-10'><input required  oninvalid=\"this.setCustomValidity('من فضلك ادخل اسم السوال   ')\" oninput=\"setCustomValidity('')\" class='form-control' name='questions[" + indexOfArr + "][question]' type='text' value='' id='question' ></div> </div> <div class='row form-group'><div class='col-md-2'><label for='ans1' class='col-form-label'>الاختيار الاول</label></div><div class='col-md-4'><input required  oninvalid=\"this.setCustomValidity('من فضلك الاجابه الاولى   ')\" oninput=\"setCustomValidity('')\" class='form-control' name='questions[" + indexOfArr + "][ans1]' type='text' value='' id='ans1' required></div><div class='col-md-2 text-left'><label for='ans2' class='col-form-label'>الاختيار الثانى</label></div><div class='col-md-4'><input required oninvalid=\"this.setCustomValidity('من فضلك الاجابه الثانيه   ')\" oninput=\"setCustomValidity('')\" class='form-control' name='questions[" + indexOfArr + "][ans2]' type='text' value='' id='ans2' required></div> </div> <div class='row form-group'><div class='col-md-2'><label for='ans3' class='col-form-label'>الاختيار الثالث</label></div><div class='col-md-4'><input class='form-control' name='questions[" + indexOfArr + "][ans3]' type='text' value='' id='ans3'></div><div class='col-md-2 text-left'><label for='ans4' class='col-form-label'>الاختيار الرابع</label></div><div class='col-md-4'><input class='form-control' name='questions[" + indexOfArr + "][ans4]' type='text' value='' id='ans4'></div></div><div class='row form-group'><div class='col-md-2'><label for='true_answer' class='col-form-label'>الاجابه الصحيحه</label></div><div class='col-md-4'><select name='questions[" + indexOfArr + "][true_answer]'>\n" +
            "  <option value=\"ans1\" >الاجابه الاولى </option>\n" +
            "  <option value=\"ans2\" >الاجابه الثانيه </option>\n" +
            "  <option value=\"ans3\">الاجابه الثالثه</option>\n" +
            "  <option value=\"ans4\">الاجابه الرابعه</option>\n" +
            "</select></div>" +

            " </div>" +
            "<a href='#' id=\"links[" + linkIndex + "]\" onclick='remove()'><span class='fa fa-link'></span>&nbsp;حذف</a> </br>" +
            "</div> </br>");

    });
    //End Adding Questions
    var index = 1;

    $("#addVocab").click(function (e) {
        e.preventDefault();


        $("div.mainDiv").append(" <div id=\"links[" + linkIndex + "]\"><div class=\"row form-group\" >\n" +
            "                    <div class=\"col-md-2\">\n" +
            "                        <label for=\"word\" class=\"col-form-label\">مصطلح</label>\n" +
            "                    </div>\n" +
            "                    <div class=\"col-md-10\">\n" +
            "                        <div class=\"ui input  fluid \">\n" +
            "                            <input   class=\"form-control\" name=\"vocab[" + index + "][word]\" type=\"text\" id=\"word\">\n" +
            "                        </div>\n" +
            "                    </div>\n" +
            "\n" +
            "                </div>\n" +
            "                <div class=\"row form-group\" id=\"links[" + linkIndex + "]\">\n" +
            "                    <div class=\"col-md-2\">\n" +
            "\n" +
            "                        <label for=\"meaning\" class=\"col-form-label\">معني مصطلح</label>\n" +
            "                    </div>\n" +
            "                    <div class=\"col-md-10\">\n" +
            "\n" +
            "\n" +
            "                        <div class=\"ui input  fluid \">\n" +
            "                            <input  class=\"form-control\" name=\"vocab[" + index + "][meaning]\" type=\"text\" id=\"meaning\">\n" +
            "                        </div>\n" +

            "                    </div>\n" +


            "               </div>" +
            "<a href='#' id=\"links[" + linkIndex + "]\" onclick='remove()'><span class='fa fa-link'></span>&nbsp;حذف</a>" +
            " </div>\n<hr>");
        index++;
        linkIndex++;

    });
    var index = 1;

    $("#addgoal").click(function (e) {
        e.preventDefault();


        $("div.mainDiv").append("<div class=\"row form-group\" id=\"links[" + linkIndex + "]\">\n" +
            "                    <div class=\"col-md-2\">\n" +
            "                        <label for=\"word\" class=\"col-form-label\">ناتج تعلم </label>\n" +
            "                    </div>\n" +
            "                    <div class=\"col-md-10\">\n" +
            "                        <div class=\"ui input  fluid \">\n" +
            "                            <input  required  oninvalid=\"this.setCustomValidity('من فضلك اسم ناتج التعلم    ')\" oninput=\"setCustomValidity('')\" class=\"form-control\" name=\"goal[" + index + "][name]\" type=\"text\" id=\"word\">\n" +
            "                        </div>\n" +
            "                    </div>\n" +
            "\n" +
            "<a href='#' id=\"links[" + linkIndex + "]\" onclick='remove()'><span class='fa fa-link'></span>&nbsp;حذف</a>" +
            "                </div>\n" +

            "               </div> </div>\n<hr>");
        index++;
        linkIndex++;

    });


    $("#addLinks").click(function (e) {

        e.preventDefault();


        var expression = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
        var regex = new RegExp(expression);

        console.log(linkIndex);
        $("div#links").append("<div class=\"row form-group\" id=\"links[" + linkIndex + "]\" >\n" +
            "     <div class=\"col-md-2 \">\n" +
            "         <label for=\"link\">الاسم</label>\n" +
            "     </div>\n" +
            "     <div class=\"col-md-4\">\n" +
            "         <input class=\"form-control \" name=\"links[" + linkIndex + "][link]\" type=\"text\" value='' id=\"link[" + linkIndex + "]\" >\n" +
            "     </div>\n" +
            "     <div class=\"col-md-2 \">\n" +
            "         <label for=\"href\">الرابط</label>\n" +
            "     </div>\n" +
            "     <div class=\"col-md-4\">\n" +
            "         <input class=\"form-control \" name=\"links[" + linkIndex + "][href]\" type=\"text\" value='' onblur='ckeckhref();' id=\"href[" + linkIndex + "]\">\n" +
            "<a  id=\"links[" + linkIndex + "]\" onclick='remove()'><span class='fa fa-link'></span>&nbsp;حذف</a>" +

            "     </div>\n" +


            " </div>");
        linkIndex++;


    });


});

function remove() {

    var id = event.target.id;
    var remove = document.getElementById(id);

    remove.remove();

}

