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
