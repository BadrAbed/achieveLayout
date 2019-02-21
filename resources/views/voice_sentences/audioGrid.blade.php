@extends('layouts.app')





@section("custom-content")


    @if($type =="create")
        @include('inc.progress_bar')
    @endif
    <section class="content">
        <div class="container">
            <div class="container main-container">
                @if($type =="edit")
                    @include('inc.bar')
                @endif
                 <div class="panel panel-green">
                 <div class="panel-heading"><h3 class="text-center"><i class="fa fa-plus"></i> اضافة الجمل للمقاطع الصوتيه</h3></div>
                 <div class="panel-body"> 
                  
                <div class="q1">


                    <div class="row ">
                        <div class="col-md-5">
                            <audio id="mySound" style="width: 600px" controls>

                                <source src="{{$audio}}" type="{{$audioType}}">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    </div>

                    <Br>

                    <div class="row">
                        <div class="col-md-5">
                            <button type="button" class="btn btn-primary" onclick="getCurrentTime();">estimate start
                            </button>

                        </div>
                    </div>
                    


                    <div style="padding-bottom: 20px;
     padding-left: 297px;    padding-top: 40px;
 ">
                        <h3>{{$articleText}}</h3>

                    </div>


                   <div id="jsGrid" style="margin:  " ></div>  


                    <div style="display: none;background-color: #fff;color: #000;" id="detailsDialog">
                        <form id="detailsForm">

                            <div class="details-form-field">

                                <input id="start" style="float: left" name="start" type="text" disabled="disabled"/>
                                <label class="h4" for="start">الأسم</label>

                            </div>
                            <div class="details-form-field">
                                <input style="float: left" id="sentence" name="sentence" type="text"/>
                                <label class="h4" for="sentence">الجمله</label>

                            </div>

                            <div class="details-form-field">
                                <button type="submit" style="text-align: center" id="save">حفظ</button>
                            </div>
                        </form>
                    </div>

                     <br>
                    <div class="row">
                        <div class="col-md-12">

                            <a href="{{url("voiceSentences/finalize/$type/$audioID/$tn")}}"
                               class="btn btn-success pull-left" role="button"> التالي <i class="fa fa-share"></i></a>
                        </div>
                    </div></div></div>

                    @section("OldJqueryVersion")

                        @include("voice_sentences.partials.csspartials")


                        <script src="//code.jquery.com/jquery-1.10.2.js"></script>

                        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
                        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

                        <script src="{{URL::asset("js/soundPlugin/jsgrid.min.js")}}"></script>
                        <script src="{{URL::asset("js/soundPlugin/jsgrid-fr.js")}}"></script>



                        <script>

                            $("#jsGrid").jsGrid({
                                height: "auto",
                                width: "70%",
                                editing: true,
                                autoload: true,
                                paging: true,
                                deleteConfirm: function (item) {
                                    return "The sentence of second \"" + item.start + "\" will be removed. Are you sure?";
                                },
                                rowClick: function (args) {
                                    showDetailsDialog("Edit", args.item);
                                },
                                //controller:db,
                                controller: {
                                    loadData: function (filter) {

                                        return $.ajax({
                                            type: "GET",
                                            url: '{{url("/voiceSentences/ajax/items/$audioID")}}',
                                            data: filter,
                                            dataType: "json",
                                        });

                                    },
                                    insertItem: function (item) {
                                        $("#jsGrid").jsGrid("refresh");

                                        item["_token"] = '{{csrf_token()}}';
                                        return $.ajax({
                                            type: "POST",
                                            url: '{{url("/voiceSentences/ajax/addItem/$audioID/$contentID")}}',
                                            data: item,
                                            success: function (result, status, xhr) {
                                                $("#jsGrid").jsGrid("render");
                                            }

                                        });


                                    },
                                    updateItem: function (item) {

                                        item["_token"] = '{{csrf_token()}}';

                                        return $.ajax({
                                            type: "POST",
                                            url: '{{url("/voiceSentences/ajax/editItem/$audioID/$contentID")}}',
                                            data: item,
                                            success: function (result, status, xhr) {
                                                $("#jsGrid").jsGrid("render");
                                            }

                                        });

                                    },
                                    deleteItem: function (item) {
                                        item["_token"] = '{{csrf_token()}}';
                                        return $.ajax({
                                            type: "POST",
                                            url: '{{url("/voiceSentences/ajax/deleteItem/$audioID/$contentID")}}',
                                            data: item,
                                            success: function (result, status, xhr) {
                                                $("#jsGrid").jsGrid("render");
                                            }

                                        });
                                    }
                                },

                                fields: [
                                    {name: "sentence", type: "text", width: 200, "title": "الجمله", align: "right"},
                                    {
                                        name: "start",
                                        type: "text",
                                        width: 50,
                                        editing: false,
                                        "title": "بداية الجمله",
                                        align: "right",
                                    },


                                    {
                                        type: "control",
                                        modeSwitchButton: false,
                                        editButton: false,
                                        align: "center"

                                    }
                                ]
                            });

                            $("#detailsDialog").dialog({
                                autoOpen: false,
                                width: 400,
                                close: function () {
                                    $("#detailsForm").validate().resetForm();
                                    $("#detailsForm").find(".error").removeClass("error");
                                }
                            });

                            $("#detailsForm").validate({
                                rules: {
                                    sentence: "required",
                                },
                                messages: {
                                    sentence: "من فضلك ادخل الجمله",
                                },
                                submitHandler: function () {
                                    formSubmitHandler();
                                }
                            });

                            var formSubmitHandler = $.noop;

                            var showDetailsDialog = function (dialogType, client) {
                                $("#start").val(client.start);
                                $("#sentence").val(client.sentence);

                                formSubmitHandler = function () {
                                    saveClient(client, dialogType === "Add");
                                };

                                if (dialogType === "Add") {
                                    dialogTitle = "اضافة"
                                }
                                else {
                                    dialogTitle = "تعديل"
                                }

                                $("#detailsDialog").dialog("option", "title", dialogTitle + " الجمله ")
                                    .dialog("open");
                            };

                            var saveClient = function (client, isNew) {

                                $.extend(client, {
                                    start: $("#start").val(),
                                    sentence: $("#sentence").val(),
                                });

                                $("#jsGrid").jsGrid(isNew ? "insertItem" : "updateItem", client);

                                $("#detailsDialog").dialog("close");
                            };


                            function getCurrentTime() {

                                var obj = document.getElementById("mySound");

                                obj.pause();

                                var currentTime = obj.currentTime;

                                showDetailsDialog("Add", {
                                    "start": currentTime
                                });

                            }

                        </script>

                    @endsection
                </div>
            </div>
        </div>
    </section>

    @if(Session::get('normal')!=null)
        <script>
            var element1=document.getElementById("1");
            element1.classList.remove("active");
            element1.classList.add("done");
            var element2=document.getElementById("2");
            element2.classList.add("active");
        </script>
    @else
        <script>
            var element1=document.getElementById("1");
            element1.classList.remove("active");
            element1.classList.add("done");
            var element2=document.getElementById("2");
            element2.classList.remove("active");
            element2.classList.add("done");
            var element3=document.getElementById("3");
            element3.classList.remove("active");
            element3.classList.add("done");
            var element4=document.getElementById("4");
            element4.classList.add("active");

        </script>
    @endif
@endsection



