@extends('layouts.app')

@section('custom-content')

    <div class="container">
        <div class=" main-container">


            <div class="col-md-12">
                <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <h3 class="text-center"><span class="fa fa-window-restore"></span>&nbsp;&nbsp; الاختبارات</h3>
                    </div>
                    <div class="panel-body">
                        <br>


                        <div style="width: 100%" id="jsGrid"></div>


                        <br>
                        <center class="btnscontainer">
                            <a class="btn btn-success " href="{{ URL::to('admin/placement_test/create ') }}"><span
                                        class="fa fa-plus-circle"></span>&nbsp;اضافة اختبار</a>

                        </center>
                        <br><br>
                    </div>
                </div>
                <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">تاكيد المسح</h4>
                </div>

                <div class="modal-body">
                    <p>هل تريد المسح؟ </p>
                    <p class="debug-url"></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                    <a class="btn btn-danger btn-ok">مسح</a>
                </div>
            </div>
        </div>
    </div>


@endsection



@section("OldJqueryVersion")

    @include("voice_sentences.partials.csspartials")


    <script src="//code.jquery.com/jquery-1.10.2.js"></script>

    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

    {{--  <script src="{{URL::asset("js/soundPlugin/jsgrid.min.js")}}"></script>
      <script src="{{URL::asset("js/soundPlugin/jsgrid-fr.js")}}"></script> --}}


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>




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
                        url: '{{url("admin/ajaxAllPlacementTests")}}',
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

                window.location = <?=json_encode(url('admin/placement_test/'))?>+"/" + item.item.ID;
            },
            fields: [


                {
                    name: "exam_name",
                    type: "text",
                    width: 30,
                    editing: false,
                    "title": "اسم الاختبار",
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
                    width: 20,
                    editing: false,
                    "title": "البلد",
                    align: "right"
                }, {
                    name: "user",
                    type: "text",
                    width: 9,
                    editing: false,
                    "title": "الكاتب",
                    align: "right",
                    filtering: false,
                }, {
                    name: "Created_at",
                    type: "text",
                    width: 23,
                    editing: false,
                    "title": "تاريخ الانشاء",
                    align: "right",
                    filtering: false,


                }, {
                    name: "Updated_at",
                    type: "text",
                    width: 23,
                    editing: false,
                    "title": "اخر تعديل",
                    align: "right",
                    filtering: false,


                }, {
                    name: "NumberOfQuestions",
                    type: "text",
                    width: 1,
                    editing: false,
                    "title": "عدد الاسئلة",
                    align: "right",
                    filtering: false,


                }, {
                    name: "status",
                    type: "text",
                    width: 1,
                    editing: false,
                    "title": "الحالة",
                    align: "right",
                    filtering: false,


                },


                {
                    "title": "الاجراء",
                    width: 80,
                    filtering: false,
                    sorting: false,
                    itemTemplate: function (_, item) {
                        View = <?=json_encode(url('admin/placement_test/'))?>+"/" + item.ID;
                        addQuestion = <?=json_encode(url("admin/placement_test_questions/create/"))?>+"/" + item.ID;
                        edit = <?=json_encode(url('admin/placement_test/'))?>+"/" + item.ID + "/edit";
                        Delete = <?=json_encode(url('admin/placement_test/'))?>+"/" + item.ID + "/delete";

                        return $('' +
                            '' +
                            '' +
                            '<a class="btn btn-primary btn-sm" style="display: inline;margin-left:5px ;" href="' + View + '"> <span class="fa fa-desktop" aria-hidden="true"></span> &nbsp;مشاهدة</a>' +
                            '<a class="btn btn-success btn-sm" style="display: inline;margin-left:5px ;" href="' + addQuestion + '"> <span class="fa fa-edit" aria-hidden="true"></span> &nbsp;اضافه اسئلة</a>' +
                            '<a class="btn btn-info btn-sm"  style="display: inline;margin-left:5px ;" href="' + edit + '"> <span class="fa fa-trash" aria-hidden="true"></span> &nbsp;تعديل</a>' +
                            '<a class="btn btn-danger btn-sm"  style="display: inline;margin-left:5px ;" href="' + Delete + '"> <span class="fa fa-trash" aria-hidden="true"></span> &nbsp;مسح</a>' +
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