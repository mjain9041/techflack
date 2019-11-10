<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>API TASK</title>
        <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
        <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <script src="{{asset('js/jquery.min.js')}}"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/jquery.form.js')}}"></script>
        <script src="{{asset('js/jquery.form.additional.js')}}"></script>
        <script src="{{asset('js/toastr.min.js')}}"></script>
        <script src="{{asset('js/bootpage.min.js')}}"></script>
    </head>
    <body id="WagaApp">
        <div class="container">
            <br>
        <div class="col-md-12"><button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add User</button></div>
        <br>
        <div class="col-md-12 showUser">
            <div class="pull-right">
             <input type="text" class="form-control search" placeholder="Search By Name"  /></div><div class="clearfix"><br><br>
</div>

            <div id="tableDiv">
                
            </div>
       
            <div id="page-selection">
               
            </div>
        </div>
        <div class="col-md-6 edit-user" style="display:none;">
               <h2 class="text-center">Edit User</h2>
               {{ Form::open(array('class' => 'form-horizontal','files' => true,'id'=>'editForm')) }}
               <div class="form-group">
                    <label class="control-label col-sm-2" for="name">Name:</label>
                    <div class="col-sm-10">
                    {{Form::hidden('id',null, array('class'=>'form-control','id'=>'id'))}}
                    {{Form::text('name',null, array('class'=>'form-control','id'=>'name','placeholder'=>'Enter Name','maxlength'=>'50'))}}
                    </div>
                </div>
                    <div class="form-group">
                    <label class="control-label col-sm-2" for="name">Email.:</label>
                    <div class="col-sm-10">
                    {{Form::text('email',null, array('class'=>'form-control','id'=>'email','placeholder'=>'Enter Email'))}}
                    </div>
                    </div>
                    <div class="form-group">
                    <label class="control-label col-sm-2" for="name">Contact No.:</label>
                    <div class="col-sm-10">
                    {{Form::text('contact_no',null, array('class'=>'form-control','id'=>'contact_no','placeholder'=>'Enter Contact No'))}}
                    </div>
                    </div>
            
                    <div class="form-group">
                    <label class="control-label col-sm-2" >Profile:</label>
                    <div class="col-sm-10">
                    <span class="fixed"><img src="" class="show_image" width="50" /></span>
                    {{Form::file('profile_pic',array('class'=>'form-control profile_pic'))}} </div>
                    </div>

                    <div class="form-group">        
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success editUser">Submit</button>  
                        <button type="button" class="btn btn-danger cancelAddForm">Cancel</button>
                    </div>
                    </div>

               </form>
        </div>
        <br>
            <div id="FormDiv">

            </div>
        </div>

        <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add User</h4>
      </div>
      <div class="modal-body">
      {{ Form::open(array('class' => 'form-horizontal','files' => true,'id'=>'addForm')) }}
    <div class="form-group">
      <label class="control-label col-sm-2" for="name">Name:</label>
      <div class="col-sm-10">
      {{Form::text('name',null, array('class'=>'form-control','placeholder'=>'Enter Name','maxlength'=>'50'))}}
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="name">Email:</label>
      <div class="col-sm-10">
      {{Form::text('email',null, array('class'=>'form-control','placeholder'=>'Enter Email'))}}
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="name">Contact No.:</label>
      <div class="col-sm-10">
      {{Form::text('contact_no',null, array('class'=>'form-control','placeholder'=>'Enter Contact No'))}}
      </div>
    </div>
 

   

    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">Profile Pic:</label>
      <div class="col-sm-10">          
      {{Form::file('profile_pic',array('class'=>'form-control profile_pic'))}}
      </div>
    </div>
 
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-success addSubmit">Submit</button>  
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
    {{ Form::close() }}
      </div>
    
    </div>

  </div>
</div>
        <script>
            var userIndex = '{{ env("API_URL") }}';
            var userDelete = '{{ env("API_URL") }}delete/';
            var userEdit = '{{ env("API_URL") }}edit/';
            var userStore = '{{ env("API_URL") }}store';
            var userUpdate = '{{ env("API_URL") }}update';
            
      </script>
        <script src="{{asset('js/custom.js')}}"></script>   
    </body>

</html>
