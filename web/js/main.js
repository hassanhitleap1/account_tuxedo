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


$(document).on('click','#insert_tiger',function (e) {
    let data;
    let url=`${SITE_URL}/expenses/calculation-tiger`;

     var date=$("#date").val();
     data={"date":date};
     if(date==""){
        alert("ارجو تحديد التاريخ")
        return ;
     }

     Swal.fire({
        title: 'Are you sure?',
        text: `هل تربد اضاف العمولات على المصاريف بتاريخ ${date}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes ',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            // Your code to proceed with the action on 'Yes' goes here
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: data
            }).done(function(response) {
                console.log(response.success)
                if(response.success){
                    Swal.fire('Confirmed!', 'The action was successfully completed.', 'success');
                }
                
            }).fail(function() {
                console.log("error");
            });
    
        
        }
    });


   
    
});

