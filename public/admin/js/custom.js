$(document).ready(function (){
    $("#current_password").keyup(function (){
        // alert('test1');
        var current_password = $("#current_password").val();
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:'post',
            url:'password/check/ajax',
            data:{current_password:current_password},
            success:function (response) {
                if(response=='false'){
                    $("#verifyCurrentPassword").html('<font color="red">Current Password is Incorrect!</font>')
                    console.log(data.current_password)
                }else if(response == 'true'){
                    $("#verifyCurrentPassword").html('<font color="green">Current Password is Correct!</font>')
                    console.log(data.current_password)
                }
            },
            error:function (){
                alert('error');
            }
        })
    });
});

$(document).on('click','.updateCmsPageStatus',function (){
   var status = $(this).children('i').attr('status');
   var page_id = $(this).attr('page_id');
   $.ajax({
       headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
       type: 'post',
       url: 'update_cms_page_status',
       data: {status:status,page_id:page_id},
       success:function (response){
           if(response['status']==0){
               $("#page-"+page_id).html('<i class="fas fa-toggle-off" style="color: grey" aria-hidden="true" status="inactive"></i>');
           }else{
               $("#page-"+page_id).html('<i class="fas fa-toggle-on" aria-hidden="true" status="active"></i>');
           }
       },
       error:function (){
           alert('error');
       }
   });
});


