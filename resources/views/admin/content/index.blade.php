@extends('layouts.app')

@section('custom-content')
<style>

</style>
    <div class="container">
        <div class=" main-container">


            <div class="col-md-12">
                <!--paneeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeel-->
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <h3 class="text-center"><span class="fa fa-window-restore"></span>&nbsp;&nbsp; المحتوى</h3>
                    </div>
                    @if(auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::EDITOR)
                        <div class="panel-body">
                            <div class="panel panel-green ">
                                <div class="panel-heading"><h3>   <a data-toggle="collapse" data-target="#demo" style="color: #f1f1f1;cursor:pointer" >بحث متقدم</a></h3></div>
                                <div class="panel-body collapse" id="demo" >
                                    <form action="{{url('/ajax/content/getAll')}}" method="get">
                                        <input type="hidden" name="advancesearch" value="advancesearch">
                                        <div class="row">

                                            <div class="col-md-3">
                                                <label>الصف :</label>


                                                <select id="myTable" class="form-control" name="level">
                                                    <option value="">الكل</option>
                                                    @foreach($levels as $parent)
                                                        <option value="{{$parent->id}}"
                                                                @if(session()->get('level')==$parent->id) selected @endif>
                                                            &#10000; {{$parent->name}}  </option>

                                                        @if ($parent->children->count())
                                                            @foreach ($parent->children as $child)
                                                                <option value="{{ $child->id }}"
                                                                        @if(session()->get('level')==$child->id) selected @endif>
                                                                    &emsp; &#9000;
                                                                    &#9000; {{ $child->name }}</option>

                                                            @endforeach

                                                        @endif
                                                    @endforeach


                                                </select>


                                            </div>

                                            <div class="col-md-3">
                                                <div class="row form-group">

                                                    <label for="parent_id">التصنيفات</label>


                                                    <select class="form-control" name="category">
                                                        <option value=""> الكل</option>
                                                        @foreach($categories as $parent)
                                                            <option value="{{$parent->id}}"
                                                                    @if(session()->get('category')==$parent->id) selected @endif>
                                                                &#10000; {{$parent->name}}  </option>

                                                            @if ($parent->children->count())
                                                                @foreach ($parent->children as $child)
                                                                    <option value="{{ $child->id }}"
                                                                            @if(session()->get('category')==$child->id) selected @endif>
                                                                        &emsp; &#9000;
                                                                        &#9000; {{ $child->name }}</option>

                                                                    @if ($child->children->count())
                                                                        @foreach ($child->children as $child2)
                                                                            <option value="{{ $child2->id }}"
                                                                                    @if(session()->get('category')==$child2->id) selected @endif>
                                                                                &emsp;&emsp;&emsp;
                                                                                &#9000;
                                                                                &#9000;&#9000; {{ $child2->name }}</option>
                                                                        @endforeach

                                                                    @endif
                                                                @endforeach

                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>


                                            <div class="col-md-3">

                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1">البلد :</label>

                                                    <select id="myTable" class="form-control" name="countries">
                                                        <option value="">الكل</option>
                                                        <option value="general"  @if(session()->get('country')=="general") selected @endif>عام</option>
                                                        @foreach($country as $country)
                                                            <option value="{{$country->id}}"
                                                                    @if(session()->get('country')==$country->id) selected @endif>{{$country->name}}</option>

                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">

                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1">الكاتب :</label>

                                                    <select id="myTable" class="form-control" name="editor">
                                                        <option value="">الكل</option>


                                                        @foreach($editors as $editor)
                                                            <option value="{{$editor->id}}"
                                                                    @if(session()->get('editor')==$editor->id) selected @endif>{{$editor->name}}</option>

                                                        @endforeach


                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">


                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="example-date-input" class="col-form-label">من يوم
                                                        :</label>

                                                    <input class="form-control" type="date" id="timeStart"
                                                           name="start_on" value="{{session()->get('start_on')}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="example-date-input" class="col-form-label">إلي يوم
                                                        :</label>

                                                    <input class="form-control" type="date" id="timeEnd" name="end_on"
                                                           value="{{(session()->get('end_on'))?session()->get('end_on'):date('Y-m-d')}}"
                                                           id="example-date-input">

                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <label for="example-date-input" class="col-form-label"> &nbsp;</label>
                                                <button type="submit" class="btn btn-success btn-block"
                                                        style="border-radius: 50px;width: 40px;outline: 0"><span
                                                            class="fa fa-search"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <br>


                            <div style="width: 100%" id="jsGrid"></div>


                            <br>
                            <center class="btnscontainer">
                                <a class="btn btn-success " href="{{ URL::to('content/create') }}"><span
                                            class="fa fa-plus-circle"></span>&nbsp;اضافة محتوى</a>
                                <a class="btn btn-danger" href="{{route('incomplete') }}"><span
                                            class="fa fa-edit"></span>&nbsp;محتويات لم تكتمل</a>
                            </center>
                            <br><br>
                        </div>
                    @endif
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

@if(session()->has('data'))
<script>

    $("#demo").addClass("collapse in");
</script>
@endif
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

                    @if(session()->has('data'))
                        return <?php

                        echo session()->get('data');
                        session()->forget('data');
                        session()->forget('category');
                        session()->forget('level');
                        session()->forget('editor');
                        session()->forget('country');
                        session()->forget('start_on');
                        session()->forget('end_on');
                        ?>;


                    @else
                        return $.ajax({
                        type: "GET",
                        url: '{{url("ajax/content/getAll")}}',
                        data: filter,
                        dataType: "json",

                    });
                    @endif
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

                    headerTemplate: function (item) {

                        return $("<a><i class='fa fa-trash' style='color:#d9534f;'></i>")
                            .on("click", function () {
                                deleteSelectedItems();
                            });
                    },


                    itemTemplate: function (_, item) {

                        return $("<input>").attr("type", "checkbox")
                            .prop("checked", $.inArray(item, selectedItems) > -1)
                            .on("change", function () {
                                $(this).is(":checked") ? selectItem(item) : unselectItem(item);
                            });
                    },
                    align: "center",
                    width: 10
                },
                {
                    name: "content_name",
                    type: "text",
                    width: 60,
                    editing: false,
                    "title": "اسم الموضوع",
                    align: "right",
                    filtering: true,

                },

                {
                    name: "level",
                    type: "text",
                    width: 30,
                    editing: false,
                    "title": "الصف",
                    align: "right",
                    filtering: false
                },
                {
                    name: "grade",
                    type: "text",
                    width: 20,
                    editing: false,
                    "title": "المستوى",
                    align: "right"
                }, {
                    name: "country",
                    type: "text",
                    width: 25,
                    editing: false,
                    "title": "البلد",
                    align: "right"
                }, {
                    name: "user",
                    type: "text",
                    width: 25,
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
                    width: 80,
                    filtering: false,
                    sorting: false,
                    itemTemplate: function (_, item) {
                        View = <?=json_encode(url('content/'))?>+"/" + item.ID;
                        review = <?=json_encode(url('Editor/review/'))?>+"/" + item.ID;
                        Edit = <?=json_encode(url('content/'))?>+"/" + item.ID + "/edit";
                        Delete = <?=json_encode(url('content/'))?>+"/" + item.ID + "/delete";


                        return $('' +
                            '' +
                            '' +
                            '<a class="btn btn-primary btn-sm" style="display: inline;margin-left:5px ;" href="' + View + '"> <span class="fa fa-desktop" aria-hidden="true"></span> &nbsp;مشاهدة</a>' +
                            "@if(auth()->user()->is_permission==App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::EDITOR)" +
                            '<a class="btn btn-info btn-sm" style="display: inline;margin-left:5px ;" href="' + review + '"> <span class="fa fa-desktop" aria-hidden="true"></span> &nbsp;مراجعة</a>'
                            + "@endif" +
                            '<a class="btn btn-success btn-sm" style="display: inline;margin-left:5px ;" href="' + Edit + '"> <span class="fa fa-edit" aria-hidden="true"></span> &nbsp;تعديل</a>' +
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