@extends('layouts.app')
@section('custom-content')
    <div class="container">


        <div class="container main-container">
            <div class="row">

                <div class="col-md-9">
                    <div class="panel panel-green">
                        <div class="panel-heading"><h4><i class="fa fa-address-card"></i> معلومات عن المستخدم</h4></div>
                        <div class="panel-body">


                            <div id="text-to-print">

                                <div class="row">
                                    <div class="col-md-5">
                                        <p>
                                            <strong>كود المستخدم : </strong> {{ $users->id }}<br>
                                            <strong>صالحية المستخدم : </strong>
                                            {{$userPermission}}
                                        </p>
                                        <p><strong> البريد الالكتروني : {{$users->email}}</strong></p>
                                    </div>
                                    <div class="col-md-7">
                                        <p><strong>البلاد المخصصه للمستخدم :
                                                @if ($users->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::STUDENT)

                                                    {{$users->Country->name}}
                                                @else
                                                    @foreach($userRelatedCountries as $countries)
                                                        <span class="label label-default">{{$countries->getRelatedCountry->name}}</span>
                                                    @endforeach
                                                @endif


                                            </strong></p>
                                        <p><strong>المراحل الدراسيه المخصصه للمستخدم :

                                                @if ($users->is_permission == \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::STUDENT)

                                                    {{$users->grade}}
                                                @else
                                                    @foreach($userRelatedEducationGrades as $levels)
                                                        <span class="label label-default">{{$levels->getRelatedLevel->name}}</span>
                                                    @endforeach
                                                @endif

                                            </strong></p>
                                    </div>

                                </div>



                            </div>
                            <br>
                            <p><a class="btn btn-info" onclick="printDiv('text-to-print')"><i class="fa fa-print"></i> طباعة
                                    المصطلح</a>
                                <a class="btn btn-danger" href="{{url("users")}}"><i class="fa fa-reply"></i> الرجوع للمستخدمين</a></p>
                        </div>
                    </div>


                </div>
                <div class="col-md-3">
                    <div class="text-center" style="background-color: #f6f6f6;color: #000;padding: 20px;border-radius: 5px;border: 1px solid #5cb85c;">
                        <img src="{{asset("/images/ppcustom.png")}}" width="42%">
                        <h1 class="text-center"> {{ $users->name }}</h1>
                        <strong> {{$userPermission}}</strong></div>
                </div>
            </div>







        </div>

        <br>
        @if($users->is_permission==\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::QUESTIONREVIEWER||$users->is_permission==\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::QUESTIONEDITOR||$users->is_permission==\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::EDITOR||$users->is_permission==\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::REVIEWER||$users->is_permission==\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::AUDIT||$users->is_permission==\App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::PUBLISHER)

            <div class="panel panel-green" sty>
                <div class="panel-heading"><h3> الدروس التى تم العمل عليها </h3></div>
                <div class="panel-body">

                    <div class="row">
                        <form action="{{url('/getRelatedContentsForUsers/'.$users->id)}}">
                            <div class="col-md-3">


                                <input type="hidden" name="form" value="1">

                                يبدا فى:<input type="date" name="startOn" class="form-control" style="display: inline"
                                               value={{(session()->has('startOn'))?session()->get('startOn'):''}}>




                            </div>
                            <div class="col-md-3">
                                ينتهى فى: <input type="date" name="endsOn" class="form-control" style="display: inline"
                                                 value="{{(session()->has('endsOn'))?session()->get('endsOn'):date("Y-m-d")}}">
                            </div>

                            <div class="col-md-1">
                                <br>
                                <button type="submit" class="btn btn-success btn-block" style="border-radius: 50px;height: 50px;
    width: 50px;margin-top: -10px"><span class="fa fa-search"></span></button>

                            </div>

                        </form>
                    </div>
                    <hr>





                    <br>

                    <div style="width: 100%" id="jsGrid"></div>
                </div>

            </div>


    </div></div>



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
                    @if(session()->has('data'))
                        return <?php echo session()->get('data');
                        session()->forget('data');
                        session()->forget('startOn');
                        session()->forget('endsOn');

                        ?>;
                            @else

                    var d = $.Deferred();

                    $.ajax({
                        type: "GET",

                        url: '{{url("/getRelatedContentsForUsers/".$users->id)}}',
                        data: filter,
                        //success: function (result, status, xhr) {

                        //   }

                    }).done(function (result) {

                        result = $.grep(result, function (item) {

                            return item.SomeField === filter.SomeField;
                        });

                        d.resolve(result);
                    });

                    return d.promise();
                    // return
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
@endif
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
@endsection
