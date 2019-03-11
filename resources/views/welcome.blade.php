<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
        <script  src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>
        <style type="text/css">
            .form-control, .btn{
                border-radius: 0;
            }
        </style>
    </head>
    <body>





        <div class="container">
            <div class="row">
                <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <h2 style="text-align: center;">Contant Form</h2>
                        <div style="display: none;" class="alert alert-success"></div>
                        <form method="post" id="contactForm" onsubmit="save()">
                        <!-- <form method="post" id="contactForm" action="{{URL::to('/save')}}"> -->
                            @csrf
                            <div class="form-group">
                                <label class="control-label">Name : </label>
                                <input class="form-control" id="name" type="text" name="name" placeholder="Enter Fullname">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Email : </label>
                                <input class="form-control" id="email" type="email" name="email" placeholder="Enter Email">
                            </div>
                            <input type="hidden" name="id" id="contactId" value="">
                            <input type="hidden" name="update" id="update" value="">
                            <div class="form-group">
                                <label class="control-label">Phone : </label>
                                <input class="form-control" id="phone" type="number" name="phone" placeholder="Enter Phone">
                            </div>
                            <button type="submit" id="saveBtn" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                <div class="col-md-4"></div>
            </div>
            <div class="row">
                <h2>Contact List</h2>       
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody id="showContact">
                      <tr>
                        <td>1</td>
                        <td>Ruhul</td>
                        <td>ruhul@gmail.com</td>
                        <td>01749-769449</td>
                        <th>
                            <button class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</button>
                            <button class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</button>
                        </th>
                      </tr>
                    </tbody>
                  </table>
            </div>
        </div>
    </body>

    <script type="text/javascript">

        showAll();

           function save(){
                event.preventDefault();
                var update = $('#update').val();
                if(update === 'update'){
                    var url = "{{ url('/update') }}";
                }else{
                    var url = "{{ url('/save') }}";
                }
                var data = $('#contactForm').serialize();
                $.ajax({
                    url: url,
                    method: 'post',
                    data: data,
                    success: function(response){
                        if(response.success){
                            $('#contactForm')[0].reset();
                            $("#saveBtn").removeClass('btn-warning');
                            $("#saveBtn").addClass('btn-success');
                            $("#saveBtn").html('Submit');
                            $('.alert-success').html(response.success).fadeIn().delay(4000).fadeOut('slow');
                            showAll();
                        }else{
                            alert('Error');
                        }
                    },
                    error: function(){
                        alert('Could not add data');
                    }
                });
                
           }


           function showAll(){
               var url = "{{URL::to('/getAll')}}";
                $.ajax({
                    type: 'ajax',
                    method: 'GET',
                    url:url,
                    dataType: 'json',
                    success:function(data){
                        var html = '';
                        var i;
                        var sl = 1;
                       for(i=0; i<data.length; i++){
                            sl = sl++;
                            html += '<tr>'+
                                        '<td>'+sl+'</td>'+
                                        '<td>'+data[i].name+'</td>'+
                                        '<td>'+data[i].email+'</td>'+
                                        '<td>'+data[i].phone+'</td>'+
                                        '<td>'+
                                            '<button class="btn btn-xs btn-warning" onclick="edit('+data[i].id+')"><i class="fa fa-edit"></i> Edit</button> '+
                                            ' <button class="btn btn-xs btn-danger" onclick="deleteData('+data[i].id+')"><i class="fa fa-trash"></i> Delete</button>'+
                                        '</td>'+
                                    '</tr>';
                        }
                        $("#showContact").html(html);
                    },
                    error:function(){
                        alert('Error Geting Data');
                    }
                })

           }

           function edit(id){
                var url = "/l_crud/edit/"+id;
                $.ajax({
                    url: url,
                    type: 'ajax',
                    method: 'get',
                    dataType: 'json',
                    success: function(data){
                        $("#saveBtn").removeClass('btn-success');
                        $("#saveBtn").addClass('btn-warning');
                        $("#saveBtn").html('Update');

                        $("#name").val(data.name);
                        $("#contactId").val(data.id);
                        $("#email").val(data.email);
                        $("#phone").val(data.phone);
                        $("#update").val('update');
                    },
                    error: function(){
                        alert('Could not add data');
                    }
                });
           }


            function deleteData(id){
                if(confirm('Are You sure about Delete??')){
                    var url = "/l_crud/delete/"+id;
                    $.ajax({
                        url: url,
                        type: 'ajax',
                        method: 'get',
                        dataType: 'json',
                            success: function(response){
                            if(response.success){
                                $('.alert-success').html('Successfully Deleted').fadeIn().delay(4000).fadeOut('slow');
                                showAll();
                            }else{
                                alert('Error');
                            }
                        },
                        error: function(){
                            alert('Could not add data');
                        }
                    });
                } 
           }
       
    </script>



</html>
