@extends('layouts.app')

@section('custom-content')

    <div class="container">
        <div class=" main-container">
            {{--@if (Session::has('message'))--}}
                {{--<div class="alert alert-info">{{ Session::get('message') }}</div>--}}
            {{--@endif--}}

            <div class="col-md-12">
                <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <h3 class="text-center"><span class="fa fa-window-restore"></span>&nbsp;&nbsp; المحتوى</h3>
                    </div>
                    <div class="panel-body">
                        <br>


                        <div style="width: 100%" id="jsGrid"></div>


                        @endsection



                        @section("OldJqueryVersion")

                            @include("voice_sentences.partials.csspartials")


                            <script src="//code.jquery.com/jquery-1.10.2.js"></script>

                            <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
                            <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

                            {{--  <script src="{{URL::asset("js/soundPlugin/jsgrid.min.js")}}"></script>
                              <script src="{{URL::asset("js/soundPlugin/jsgrid-fr.js")}}"></script> --}}


                            <script type="text/javascript"
                                    src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>




                            <script>


                                // $(".jsgrid-filter-row").hide();


                                $("#jsGrid").jsGrid({


                                    width: "100%",

                                    pagerFormat: "الصفحات: {first} {prev} {pages} {next} {last} {itemCount} محتوى  {pageIndex} من {pageCount}",
                                    pagePrevText: "السابق",
                                    pageNextText: "التالى",
                                    pageFirstText: "الاولى",
                                    pageLastText: "الاخير",
                                    filtering: true,
                                    editing: true,
                                    sorting: true,
                                    paging: true,
                                    autoload: true,
                                    heading: true,
                                    pageSize: 15,


                                    deleteConfirm: function (item) {
                                        return "The sentence of second \"" + item.start + "\" will be removed. Are you sure?";
                                    },
                                    rowClick: function (args) {
                                        //$("#jsGrid").search();
                                        //showDetailsDialog("Edit", args.item);
                                    },
                                    //controller:db,
                                    controller: {
                                        loadData: function (filter) {


                                            return $.ajax({
                                                type: "GET",
                                                url: '{{url("QuestionsEditor/AjaxAllLessons")}}',
                                                data: filter,
                                                dataType: "json",

                                            });

                                        },


                                        deleteItem: function (item) {
                                            item["_token"] = '{{csrf_token()}}';
                                            return $.ajax({
                                                type: "POST",
                                                url: '{{url("/voiceSentences/ajax/deleteItem/contentid")}}',
                                                data: item,
                                                success: function (result, status, xhr) {
                                                    $("#jsGrid").jsGrid("render");
                                                }

                                            });
                                        }
                                    },
                                    rowClick: function (item) {

                                        window.location = <?=json_encode(url('content/'))?>+"/" + item.item.ID;
                                    },
                                    fields: [
                                        {


                                            align: "center",
                                            width: 10
                                        },
                                        {
                                            name: "content_name",
                                            type: "text",
                                            width: 30,
                                            editing: false,
                                            "title": "اسم الموضوع",
                                            align: "right",
                                            filtering: true,

                                        }, {
                                            name: "grade",
                                            type: "text",
                                            width: 30,
                                            editing: false,
                                            "title": "المستوى",
                                            align: "right"
                                        }, {
                                            name: "country",
                                            type: "text",
                                            width: 15,
                                            editing: false,
                                            "title": "البلد",
                                            align: "right"
                                        }, {
                                            name: "user",
                                            type: "text",
                                            width: 15,
                                            editing: false,
                                            "title": "الكاتب",
                                            align: "right",
                                            filtering: false,
                                        }, {
                                            name: "Created_at",
                                            type: "text",
                                            width: 25,
                                            editing: false,
                                            "title": "تاريخ الانشاء",
                                            align: "right",
                                            filtering: false,

                                        },


                                        {
                                            "title": "الاجراء",
                                            width: 90,
                                            filtering: false,
                                            sorting: false,
                                            itemTemplate: function (_, item) {
                                                View = <?=json_encode(url('content/'))?>+"/" + item.ID;

                                                Assign = <?=json_encode(url('QuestionsEditor/AssignLessonsToQuestionsEditor/'))?>+"/" + item.ID;

                                                return $('' +
                                                    '' +
                                                    '' +
                                                    '<a class="btn btn-primary btn-sm" style="display: inline;margin-left:5px ;" href="' + View + '"> <span class="fa fa-desktop" aria-hidden="true"></span> &nbsp;مشاهدة</a>' +

                                                    '<a class="btn btn-primary btn-sm"  style="display: inline;margin-left:5px ;" href="' + Assign + '"> <span class="fa fa-desktop" aria-hidden="true"></span> &nbsp;ادخال الاسئلة </a>' +
                                                    '' +
                                                    '' +
                                                    '');


                                            },


                                        },

                                        {
                                            type: "control",
                                            editButton: false,
                                            deleteButton: false,
                                            width: 10,
                                            autoload: true,

                                            filtering: true,
                                            _createFilterSwitchButton: function () {
                                                return this._createOnOffSwitchButton("filtering", this.searchModeButtonClass, false);
                                            },


                                        },

                                    ]
                                })
                                ;
                                $("#jsGrid").jsGrid("option", "filtering", false);


                                var selectedItems = [];

                                var selectItem = function (item) {

                                    selectedItems.push(item.ID);
                                };

                                var unselectItem = function (item) {
                                    selectedItems = $.grep(selectedItems, function (i) {
                                        return i !== item;
                                    });
                                };

                                var deleteSelectedItems = function () {

                                    if (!selectedItems.length || !confirm("Are you sure?"))
                                        return;


                                    deleteClientsFromDb(selectedItems);

                                    var $grid = $("#jsGrid");
                                    $grid.jsGrid("option", "pageIndex", 1);
                                    $grid.jsGrid("loadData");

                                    selectedItems = [];
                                };

                                var deleteClientsFromDb = function (deletingClients) {
                                    var X = deletingClients.toString();


                                    $.ajax({
                                        url: "{{url("delteseleteccontent?")}}",

                                        data: {Arr: X},

                                    });

                                    location.reload();

                                };
                                // $(".jsgrid-filter-row").css('display', 'none');

                            </script>

@endsection