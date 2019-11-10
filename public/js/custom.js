function loadData(page=0,search=''){
        $.ajax({
          url: userIndex+page+'/'+search,
          type: "GET",
          dataType: 'json',
          success: function (data) {
             if(data.status =='success'){
                var userData = data.userData;
                var html = '<div class="table-responsive">';
                html += '<table class="table table-bordered">';
                html += '<thead> <tr><th>#</th><th>Name</th><th>Email</th><th>Contact No.</th><th>Profile Pic</th><th>Action</th></tr> </thead>';
                html += ' <tbody>';
                if(userData.length>0){
                  for(var i=0;i<=userData.length-1;i++)
                    { 
                      var j= i+1;
                      html+="<tr> <td>"+j+"</td><td>"+userData[i]['name']+"</td><td>"+userData[i]['email']+"</td><td>"+userData[i]['contact_no']+"</td><td><span class='fixed'><img src='"+userData[i]['profile_pic']+"' width='50' /></span></td><td> <a href='#' class='btn btn-primary fixed editSingle' data-id="+userData[i]['id']+">Edit</a> <a href='#' class='btn btn-danger fixed deleteSingle' data-id="+userData[i]['id']+">Delete</a> </td></tr>";
                    }
                }else{
                  html+="<tr> <td colspan='7' align='center'><b>No Data Found</b></td></tr>";  
                } 
                  html += '</tbody></table></div>';
                $('#tableDiv').html(html);
                if(data.userCount > 0 ) {
                  $('#page-selection').show();
                  $('#page-selection').bootpag({
                    total: data.userCount,
                    maxVisible:10,
                    next:'Next',
                    prev:'Prev'
                  }); 
                }else{
                  $('#page-selection').hide();
                }           
             }else{
              $('#tableDiv').html('<h2>Error Occur!!</h2>');
             }
          },
          error: function (data) {
            $('#tableDiv').html('<h2>Error Occur!!</h2>');
          }
      });
      }
      $.validator.addMethod("roles", function(value, elem, param) {
   return $(".hobby:checkbox:checked").length > 0;
},"<span>You must select at least one!</span>");
        $(document).ready(function(){
          $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
         });
         loadData();
         
         $(document).on("click", ".bootpag > li" , function() {
            var pageNo =  $(this).data('lp');
            var search =  $('.search').val();
            if($(this).hasClass('next')) {
              pageNo = pageNo-10;
            }
            if($(this).hasClass('prev')) {
              // $('.bootpag>li>active').data('lp');
              if($('ul').find('.active').data('lp') != pageNo)
                pageNo = pageNo+1;
            }
            loadData(pageNo-1,search);
         });

         $(document).on("keyup", ".search" , function() {
          var search =  $(this).val();
          loadData(0,search);
       });


       $(document).on("click", ".addSubmit" , function() {

        $("#addForm").validate({
rules: {
name: "required",
email: { required : true, email:true },
contact_no: { required : true, phoneUS:true },
profile_pic:{required:true,accept: "image/*"}
},
messages: {
name: "Please specify your name",
contact_no: {
required:'Please specify contact no.'
}
},
submitHandler: function(form) {
var form_data = new FormData($('#addForm')[0]);

$.ajax({
    url: userStore, 
    type: "POST",             
    data: form_data, 
    contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
    processData: false,   
    success: function(data) {
        if(data.status == 'success') {
          toastr.success('User Added Successfully');
          loadData();
          $('#myModal').modal('hide');
          $('#addForm').get(0).reset();
        }else{
          toastr.error(data.messsage);
        }
    },
    error: function (data) {
      toastr.error('Something Went Wrong');
        }
});
return false;
},
});
   
});

      $(document).on("click", ".editUser" , function() {
                $("#editForm").validate({
   rules: {
     name: "required",
     email: { required : true, email:true },
     contact_no: { required : true, phoneUS:true },
    
   },
   messages: {
     name: "Please specify your name",
     contact_no: {
       required:'Please specify contact no.'
     }
   },
   submitHandler: function(form) {
      var form_data = new FormData($('form')[0]);
        $.ajax({
            url: userUpdate, 
            type: "POST",             
            data: form_data, 
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false,   
            success: function(data) {
                if(data.status == 'success') {
                  toastr.success('User Added Successfully');
                  loadData();
                  $('.showUser').removeClass('col-md-6').addClass('col-md-12');
                  $('.edit-user').hide();
                  
                }else{
                  toastr.error(data.messsage);
                }
            },
            error: function (data) {
              toastr.error('Something Went Wrong');
                }
        });
        return false;
    },
});
           
        });

        $(document).on("click", ".deleteSingle" , function() {
            var id = $(this).attr("data-id");
            var result = confirm("Want to delete?");
            if (result) {
                $.ajax({
                url: userDelete+id,
                type: "DELETE",
                dataType: 'json',
                success: function (data) {
                  if(data.status =='success'){
                    toastr.success('User Delete Successfully');
                    loadData();
                  }else{
                    toastr.error('Something Went Wrong');
                  }
                },
                error: function (data) {
                  toastr.error('Something Went Wrong');
                }
              });
            }
        });

  $(document).on("click", ".cancelAddForm" , function(e) {
    $('.showUser').removeClass('col-md-6').addClass('col-md-12');
    $('.edit-user').hide();
  });

  $(document).on("click", ".editSingle" , function(e) {
    var id= $(this).data('id');
    $.ajax({
      url: userEdit+id,
      type: "GET",
      dataType: 'json',
      success: function (data) {
         if(data.status =='success'){
            $('#id').val(data.userData.id);
            $('#name').val(data.userData.name);
            $('#email').val(data.userData.email);
            $('#contact_no').val(data.userData.contact_no);
            $('.show_image').attr('src',data.userData.profile_pic);
            $('.showUser').removeClass('col-md-12').addClass('col-md-6');
            $('.edit-user').show();
         }else{
          $('#tableDiv').html('<h2>Error Occur!!</h2>');
         }
      },
      error: function (data) {
        $('#tableDiv').html('<h2>Error Occur!!</h2>');
      }
  });
  });


        });
