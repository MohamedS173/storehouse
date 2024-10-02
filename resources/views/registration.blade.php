@extends('layout')

@section('nav')



<?php
if(session('role') == 'manager'){ 
    echo '<a class="nav-link " href="/index">Storage</a>';
    echo '<a class="nav-link " href="/user-requests">Request Page</a>';
    echo '<a class="nav-link " href="/manager-requests">Requests List</a>';
    echo '<a class="nav-link active border-bottom border-warning border-1 text-warning" aria-current="page" href="/register">Registeration</a>';
}
?>
@endsection


@section('content')
<div class="container-fluid p-5  text-center h-100 mt-5">

    <div class="row d-flex flex-xxl-row flex-sm-column justify-content-evenly align-items-center h-100">
        <div class="col-sm-7 col-md-6 col-lg-6 col-xl-5 col-xxl-4  ">

            <div class="card" style="border-radius: 15px;">
                @if (session('status'))
                <h6 class="alert alert-success"> {{session('status')}}</h6>
                @endif
                <div class="card-body p-5">
                    <h2 class="text-uppercase text-center mb-5">Create an <span class="text-warning border-bottom border-warning border-2">account</span></h2>

                    <form action="/register" id="signupForm" onsubmit="signup(event)" method="post">
                        @csrf

                        <div data-mdb-input-init class="form-outline text-start mb-4">
                            <label class="form-label " for="form3Example1cg">Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required>
                        </div>


                        <div data-mdb-input-init class="form-outline text-start mb-4">
                            <label class="form-label" for="form3Example4cg">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required>
                        </div>

                        <div data-mdb-input-init class="form-outline text-start mb-4">
                            <label class="form-label">Role</label>
                            <div class="input-group col-sm-10">
                                <select name="role" class="form-select" aria-label="Default select example" id="role" required>

                                    <option value="user">User</option>
                                    <option value="manager">Manager</option>
                                    <option value="storageman">Storage Man</option>
                                </select>
                            </div>
                        </div>


                        <div class="d-flex justify-content-center">
                            <button type="submit" data-mdb-button-init
                                data-mdb-ripple-init class="btn btn-outline-success btn-block btn-lg gradient-custom-4 ">Register</button>
                        </div>

                        <p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="/login"
                                class="fw-bold text-body"><u>Login here</u></a></p>

                    </form>

                </div>
            </div>
        </div>
        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 h-100 order-xl-last order-xxl-last order-first ">

            <h1 class="services_taital">Available <span class="text-warning border-bottom border-warning border-2">Users</span></h1>
            @if (session('status'))
            <h6 class="alert alert-success"> {{session('status')}}</h6>
            @endif
            <table class="table table-bordered table-hover mt-5">
                <thead class="table-dark">
                    <tr>

                        <th>Username</th>
                        <th>Role</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $request)
                    <tr id="request-{{ $request->id }}">
                        <td>{{ $request->username }}</td>
                        <td>{{ $request->role }}</td>
                        <td>

                            <input type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#editModal" onClick="changeUserId(this)" data-user-id="{{ $request->id }}" value="Edit">
                            <a href="/delete-user/{{$request->id}}"><input type="button" class="btn btn-sm btn-outline-danger" onClick="deleteUser('{{$request->id}}')" data-user-id="{{ $request->id }}" value="Delete"></a>
                            <!-- onClick="deleteUser(this)" -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <!-- Modal -->
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="editModalLabel">Edit User</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="/updateUser" id="edit_form" onsubmit="editData(event)" method="post">
                                    {{csrf_field()}}
                                    <!-- Make sure to use PUT for update -->
                                    <!-- @method('post') -->
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="user_id" data-user-id="" id="myUser_id" value="">
                                    <div class="form-group text-start mb-3">
                                        <label for="" class="text-dark">Username</label>
                                        <input type="text" class="form-control" id="usernameedit" name="usernameedit">
                                    </div>
                                    <div data-mdb-input-init class="form-outline text-start mb-4">
                                        <label class="form-label">Role</label>
                                        <div class="input-group col-sm-10">
                                            <select name="roleedit" class="form-select" aria-label="Default select example" id="roleedit">
                                                <option id='selected' value="selected" selected></option>
                                                <option value="user">User</option>
                                                <option value="manager">Manager</option>
                                                <option value="storageman">Storage Man</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-outline-success">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>


    <script>
        function signup(e) {
            e.preventDefault();
            var formData = $('#signupForm').serialize();

            $.ajax({
                type: 'POST',
                url: '/register',
                data: formData,
                success: function(response) {
                    alert('Registration successful');
                    window.location.href = '/login';
                },
                error: function(error) {
                    alert('The username is already exists');
                    // console.log('Error:', error);
                }
            });
        };

        

        function changeUserId(elm) {
            //alert($(elm).attr('data-user-id'));
            var myUserId = $(elm).attr('data-user-id');
            $("#myUser_id").attr('data-user-id', myUserId);
            $.ajax({
                url: "/getUser",
                type: "GET",
                data: {
                    'user_id': myUserId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response['user_id']);
                    console.log(response['usernameedit']);
                    console.log(response['roleedit']);

                    $("#myUser_id").val(response['user_id']);
                    $("#usernameedit").val(response['usernameedit']);
                    $("#selected").text(response['roleedit']);


                    //$("#equipTableBody").html(response);
                },
                error: function(error) {
                    console.log("Error:", error);
                }
            });
        }


        function editData(e) {
            event.preventDefault(); // Prevent form submission
            var formData = new FormData(event.target);


            var userId = $('#myUser_id').attr('data-user-id'); // Get user id
            //alert(userId);
            // var userId = $(elm).attr('data-user-id'); // Get user id



            $.ajax({
                url: '/updateUser',
                type: 'POST',

                data: formData,
                // headers: {
                //    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                success: function(response) {
                    // Handle successful response, refresh the table or show a message
                    // console.log(data);
                    // console.log(data);
                    console.log(response);



                    alert('User updated successfully!');
                    $('#editModal').hide('fast'); // Close the modal after success
                    $('.modal-backdrop').hide('fast'); // Close the modal backdrop
                    // fetch('#services');


                    location.reload(); // Reload the page to see changes (optional)
                },
                error: function(error) {
                    console.log('Error:', error);
                    //alert('Failed to update user!');
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }

        function deleteUser(userId) {
            // let userId = $('#myUser_id').val();
            $.ajax({
                url: '/delete-user/' + userId,
                type: 'GET',
                data: {
                    _token: $('input[name=_token]').val() // Include CSRF token
                },
                success: function(response) {
                    alert('User deleted successfully!');
                    location.reload(); // Reload the page to reflect changes (optional)
                },
                error: function(error) {
                    console.log('Error:', error);
                    // alert('User deleted successfully!');
                    alert('Failed to delete user!');
                }
            });
        }
    </script>













    @endsection