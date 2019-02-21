@extends("layouts.app")



@section("custom-content")

    <div class="content-wrapper">
        
        <div class="container">
         <div class="panel panel-green">
                <div class="panel-heading"><h3><i class="fa fa-paragraph"></i> قاموس الكلمات</h3></div>
                <div class="panel-body">
            @if(session('message'))
                <div class="alert alert-info">{{session("message")}}</div>

            @endif
<div id="jsGrid"></div>
            <br>
            <br>
            <center>
            <a class="btn btn-success " href="{{ URL::to('dictionary/create/word') }}"><span
                        class="fa fa-plus-circle"></span>&nbsp;اضافة معنى </a>
            </center>
        </div>
        </div></div>
    </div>
<style>

    .jsgrid-button jsgrid-update-button{
        display: none !important;
    }
</style>


@section("OldJqueryVersion")

    @include("voice_sentences.partials.csspartials")


    <script src="//code.jquery.com/jquery-1.10.2.js"></script>

    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

    {{--  <script src="{{URL::asset("js/soundPlugin/jsgrid.min.js")}}"></script>
      <script src="{{URL::asset("js/soundPlugin/jsgrid-fr.js")}}"></script> --}}


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>

    <script>



            $("#jsGrid").jsGrid({
                width: "100%",

                pagerFormat: "الصفحات: {first} {prev} {pages} {next} {last} {itemCount} كلمة   {pageIndex} من {pageCount}",
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
                controller: {
                    loadData: function (filter) {
                        return $.ajax({
                            type: "GET",
                            url: '{{url("dictionary/ajax/getAll")}}',
                            data: filter,
                            dataType: "json"
                        });
                    }
                },
                rowClick: function (args) {
                    //$("#jsGrid").search();
                    //showDetailsDialog("Edit", args.item);
                },
                fields: [

                    {  name: "word",
                        type: "text",
                        width: 60,
                        editing: false,
                        "title": "الكلمة",
                        align: "right",
                        filtering: true
                    },
                    {
                        name: "type",
                        type: "text",
                        width: 25,
                        editing: false,
                        "title": "النوع",
                        align: "right"
                    },
                    {
                        name: "meaning",
                        type: "text",
                        width: 25,
                        editing: false,
                        "title": "المعنى",
                        align: "right",
                        filtering:false
                    },
                    {
                        name: "grade",
                        type: "text",
                        width: 50,
                        editing: false,
                        "title": "المستوى",
                        align: "right"
                    },
                    {
                        "title": "الاجراء",
                        width: 50,
                        filtering: false,
                        sorting: false,
                        itemTemplate: function (_, item) {
                            View = <?=json_encode(url('dictionary/view'))?>+"/" + item.ID;
                            Edit = <?=json_encode(url('dictionary/'))?>+"/" + item.ID + "/edit";
                            Delete = <?=json_encode(url('dictionary/'))?>+"/" + item.ID + "/delete";

                            return $('' +
                                '' +
                                '' +
                                '<a class="btn btn-primary btn-sm" style="display: inline;margin-left:5px ;" href="' + View + '"> <span class="fa fa-desktop" aria-hidden="true"></span> &nbsp;مشاهدة</a>' +
                                '<a class="btn btn-success btn-sm" style="display: inline;margin-left:5px ;" href="' + Edit + '"> <span class="fa fa-edit" aria-hidden="true"></span> &nbsp;تعديل</a>' +
                                '<a class="btn btn-danger btn-sm" style="display: inline;margin-left:5px ;" href="' + Delete + '"> <span class="fa fa-trash" aria-hidden="true"></span> &nbsp;مسح</a>' +
                                '' +
                                '' +
                                '');
                        }
                    }, {
                        type: "control",
                        editButton: false,
                        deleteButton: false,
                        width: 10,
                        autoload: true,

                        filtering:true,
                        _createFilterSwitchButton: function() {
                            return this._createOnOffSwitchButton("filtering", this.searchModeButtonClass, false);





                    },
                    }
                ]
            });
            $("#jsGrid").jsGrid("option", "filtering", false);
    </script>
@endsection
@endsection