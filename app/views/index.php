<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>PHP CRUD using jquery ajax without page reload</title>

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
</head>
<body>




<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>PHP Ajax CRUD without page reload using Bootstrap Modal
                   
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#studentAddModal"> Add Student</button>
                       
                    </h4>
                </div>
                <div id="messageerr" class="alert alert-warning d-none"></div>
                <div class="card-body">

                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>fullname</th>
                                <th>username</th>
                                <th>password</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php foreach($users as $user):?>
                            <tr>
                                <td><?= $user['fullname'] ?></td>
                                <td><?= $user['username'] ?></td>
                                <td><?= $user['password'] ?></td>
                                <td>
                                    <button type="button" value="<?=$user['user_id'];?>" class="editStudentBtn btn btn-success btn-sm">Edit</button>
                                    <button type="button" value="<?=$user['user_id'];?>" class="deleteStudentBtn btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>





<!-- Add Student -->
<div class="modal fade" id="studentAddModal" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="insertUserForm">
            <div class="modal-body">

                <div id="errorMessage" class="alert alert-warning d-none"></div>

                <div class="mb-``568` nmj,3">
                    <label for="">fullname</label>
                    <input type="text" name="fullname" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">username</label>
                    <input type="text" name="username" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">password</label>
                    <input type="text" name="password" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
        </div>
    </div>
</div>







<!-- Add Student -->
<div class="modal fade" id="editDataModal" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="updateDataForm">
            <div class="modal-body">

                <div id="updateErrorMessage" class="alert alert-warning d-none"></div>

                <div class="mb-3">
                    <label for="">fullname</label>
                    <input type="hidden" name="user_id" class="form-control" id="editid"/>
                    <input type="text" name="fullname" class="form-control" id="editname"/>
                </div>
                <div class="mb-3">
                    <label for="">username</label>
                    <input type="text" name="username" class="form-control" id="editusername"/>
                </div>
                <div class="mb-3">
                    <label for="">password</label>
                    <input type="text" name="password" class="form-control" id="editpassword"/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
        </div>
    </div>
</div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <script>
        $(document).on('submit', '#insertUserForm', function(e){
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_student", true);

            $.ajax({
                type: "POST",
                url: "http://localhost/almarezCrud/User/insertData",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    var res = jQuery.parseJSON(response);
                    console.log(res);

                    if(res.status == 500) {
                        $('#errorMessage').removeClass('d-none');
                        $('#errorMessage').text(res.message);
                       

                    }else if(res.status == 200){

                        $('#messageerr').removeClass('d-none');
                        $('#messageerr').text(res.message);
                        $('#studentAddModal').modal('hide');
                        $('#insertUserForm')[0].reset();
                        $('#myTable').load(location.href + " #myTable");
                    }
            
                }
            });

        });

        $(document).on('click', '.editStudentBtn', function () {

            var student_id = $(this).val();
            const id = {
                'user_id': student_id,
            };
            console.log(student_id);
            $.ajax({
                type: "POST",
                url: "http://localhost/almarezCrud/User/getSingleUser",
                data: id, 
                // processData: false,
                success: function (response) {

                    var res = jQuery.parseJSON(response);
                    console.log(res)
                    if(res.status == 500) {
                        $('#messageerr').removeClass('d-none');
                        $('#messageerr').text(res.message);
                        
                    }else if(res.status == 200){

                        $('#editid').val(res.user.user_id);
                        $('#editname').val(res.user.fullname);
                        $('#editusername').val(res.user.username);
                        $('#editpassword').val(res.user.password);

                        $('#editDataModal').modal('show');
                    }

                }
            });

        });

        $(document).on('submit', '#updateDataForm', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("submit", true);

            $.ajax({
                type: "POST",
                url: "http://localhost/almarezCrud/User/updateData",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    
                    var res = jQuery.parseJSON(response);
                    if(res.status == 500) {
                        $('#updateErrorMessage').removeClass('d-none');
                        $('#updateErrorMessage').text(res.message);

                    }else if(res.status == 200){
                        $('#messageerr').removeClass('d-none');
                        $('#messageerr').text(res.message);
                        $('#editDataModal').modal('hide');
                        $('#updateDataForm')[0].reset();
                        $('#myTable').load(location.href + " #myTable");

                    }
                }
            });

        });

        // $(document).on('click', '.viewStudentBtn', function () {

        //     var student_id = $(this).val();
        //     $.ajax({
        //         type: "GET",
        //         url: "code.php?student_id=" + student_id,
        //         success: function (response) {

        //             var res = jQuery.parseJSON(response);
        //             if(res.status == 404) {

        //                 alert(res.message);
        //             }else if(res.status == 200){

        //                 $('#view_name').text(res.data.name);
        //                 $('#view_email').text(res.data.email);
        //                 $('#view_phone').text(res.data.phone);
        //                 $('#view_course').text(res.data.course);

        //                 $('#studentViewModal').modal('show');
        //             }
        //         }
        //     });
        // });

        $(document).on('click', '.deleteStudentBtn', function (e) {
            e.preventDefault();

            if(confirm('Are you sure you want to delete this data?'))
            {
                var student_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "http://localhost/almarezCrud/User/deleteData/",
                    data: {
                        'delete_student': true,
                        'user_id': student_id
                    },
                    success: function (response) {

                        var res = jQuery.parseJSON(response);
                        if(res.status == 500) {

                            alert(res.message);
                        }else{
                           

                            $('#myTable').load(location.href + " #myTable");
                        }
                    }
                });
            }
        });

    </script>

</body>
</html>