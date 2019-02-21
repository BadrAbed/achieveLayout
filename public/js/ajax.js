$(document).ready(function () {
    // console.log("ready");
    var appPath = "/achieve/public";
    $(".addTag").click(function () {
        console.log("clicked");
        //console.log(document.location.origin);
        var id = this.id.substr(3,this.id.length);
        var value = $("#tags"+id).val();

        console.log(id+"--"+value);
        //Start Ajax
       $.ajax({
           url: document.location.origin+appPath+"/image/addTags",
           data:{tags:value, id:id},
           beforeSend:function(){
               console.log("before send");
           },
           success:function(data){
               console.log(data);
           },
           error:function(data){
               console.log("error");
           }
       });
    });


    // $("#main_categories").change(function () {
    //
    //     var id = $("#main_categories").val();
    //     //Start Ajax
    //     $.ajax({
    //         url: document.location.origin+appPath+"/categories/getCategories",
    //         data:{tags:value, id:id},
    //         beforeSend:function(){
    //             console.log("before send");
    //         },
    //         success:function(data){
    //             console.log(data);
    //         },
    //         error:function(data){
    //             console.log("error");
    //         }
    //     });
    // });

});