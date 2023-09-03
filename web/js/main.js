let SITE_URL = getSiteUrl() ;


function getSiteUrl() {
    let site_url=window.location.host;
    if (site_url=='localhost:8080'){
        return '';
    }
    return site_url+'/web';
}

$(document).on('change','#type_id',function (e) {
    var type_id = $(this).val();
    
    if(type_id ==3){
        $("#name").val("solfa")
    }else{
        $("#name").val("")   
    }
  

});

