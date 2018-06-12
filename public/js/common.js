function loading2(text,s){
    $("#mask > .loading").html("<img src='/image/admin/loading_icon.gif'><br>"+text);
    if(s == undefined){
        $("#mask").show();
    }else{
        if(s > 0){
            setTimeout(function(){$("#mask").hide();},s);
        }else{
            $("#mask").hide();
        }
    }
}