<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <title>Teacher Details</title>
</head>

<body class="p-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('All Techer') }}</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Sl No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Institute</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <span id="addT">Teacher Add</span>
                        <span id="updateT">Teacher Update</span>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="teacher_name" class="form-label">Teacher Name</label>
                            <input type="text" class="form-control" id="xxx" aria-describedby="teacher_name">
                            <span class="text-danger" id="nameerror"></span>
                        </div>
                        <div class="mb-3">
                            <label for="teacher_title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title">
                            <span class="text-danger" id="titleerror"></span>
                        </div>

                        <div class="mb-3">
                            <label for="institue" class="form-label">Institue</label>
                            <input type="text" class="form-control" id="institute">
                            <span class="text-danger" id="insterror"></span>
                        </div>
                        <input type="hidden" id="id">
                        <button type="submit" id="addbutton" onclick="addData()" class="btn btn-primary">Add</button>
                        <button type="submit" id="updatebutton" onclick="updateData()" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script>
        $('#addbutton').show();
        $('#addT').show();
        $('#updatebutton').hide();
        $('#updateT').hide();


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function allData(){
            $.ajax({
                type:"GET",
                dataType:'Json',
                url:"/teacher/all",
                success:function(response){
                    var data=""
                    $.each(response,function(key,value){
                        // Here each can perform as like foreach loop
                        data=data+"<tr>"
                        data=data+"<td>"+value.id+"</td>"
                        data=data+"<td>"+value.name+"</td>"
                        data=data+"<td>"+value.title+"</td>"
                        data=data+"<td>"+value.institute+"</td>"
                        data=data+"<td>"
                        data=data+"<button class='btn btn-success' onclick='editData("+value.id+")'>Edit</button>"
                        data=data+"<button class='btn btn-danger' onclick='deleteData("+value.id+")'>Delete</button>"
                        data=data+"</td>"
                        data=data+"</tr>"
                    });
                    $('tbody').html(data);
                }
            });
        }
        allData();

        function clearData(){
            $('#xxx').val('');
            $('#title').val('');
            $('#institute').val('');
            $('#nameerror').text('');
            $('#titleerror').text('');
            $('#insterror').text('');

            // console.log(x);
        }

        function addData(){
           var namex= $('#xxx').val();
           var title= $('#title').val();
           var institute= $('#institute').val();

        //    console.log(name);
        //    console.log(title);
        //    console.log(institue);

           $.ajax({
                type:"post",
                dataType:'json',
                data:{a:namex, title:title, institute:institute},
                url:"/teacher/store/",

                success:function(data){
                    clearData();
                    allData();

                    Swal.fire({
                    icon: 'success',
                    title: 'Complete',
                    text: 'Data Added Successfully',
                    // footer: '<a href="">Why do I have this issue?</a>'
                    })

                    // console.log('added data successfully');
                },
                error:function(error){
                    $('#nameerror').text(error.responseJSON.errors.a);
                    $('#titleerror').text(error.responseJSON.errors.title);
                    $('#insterror').text(error.responseJSON.errors.institute);
                    // console.log(error.responseJSON.errors);
                }
            });
        }

        function editData(id){
            $.ajax({
                type:"GET",
                dataType:"Json",
                url:"/teacher/edit/"+id,
                success:function(data){
                    $('#addbutton').hide();
                    $('#addT').hide();
                    $('#updatebutton').show();
                    $('#updateT').show();
                    $('#id').val(data.id);
                    $('#xxx').val(data.name);
                    $('#title').val(data.title);
                    $('#institute').val(data.institute);
                    console.log(data);
                }
            });
        }

        function updateData(){
            var id= $('#id').val();
            var namex= $('#xxx').val();
            var title= $('#title').val();
            var institute= $('#institute').val();

            $.ajax({
                type:"POST",
                dataType:"Json",
                data:{a:namex, title:title, institute:institute},
                url:"/teacher/update/"+id,

                success:function(data){
                    Swal.fire({
                    icon: 'success',
                    title: 'Complete',
                    text: 'Data Updated Successfully',
                    // footer: '<a href="">Why do I have this issue?</a>'
                    })
                    clearData();
                    allData();
                    $('#addbutton').show();
                    $('#addT').show();
                    $('#updatebutton').hide();
                    $('#updateT').hide();
                    console.log('Update data successfully');
                }
            });
        }

        function deleteData(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    ),
                    $.ajax({
                        type:"GET",
                        dataType:"json",
                        url:"/teacher/delete/"+id,

                        success:function(data){
                            $('#addbutton').show();
                            $('#addT').show();
                            $('#updatebutton').hide();
                            $('#updateT').hide();
                            clearData();
                            allData();
                            console.log("deleted");
                        }
                    });
                }
            });
        }


        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

</body>

</html>
