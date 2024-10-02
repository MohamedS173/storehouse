@extends('layout')

@section('nav')

<a class="nav-link active border-bottom  border-warning border-1 text-warning" aria-current="page" href="/login">Login</a>
@endsection


@section('content')
<div class="container h-100 mt-5">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
            <div class="card" style="border-radius: 15px;">
                @if (session('status'))
                <h6 class="alert alert-success"> {{session('status')}}</h6>
                @endif
                <div class="card-body p-5">
                    <h2 class="text-uppercase text-center mb-5">please <span class="text-warning border-bottom border-warning border-2">login</span></h2>

                    <form id="loginForm" action="/login" method="post" onsubmit="login(event)">
                        @csrf

                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="form3Example1cg">Username</label>
                            <input type="text" name="username" id="loginUsername" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required>
                        </div>


                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="form3Example4cg">Password</label>
                            <input type="password" name="password" id="loginPassword" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required>
                        </div>


                        <div class="d-flex justify-content-center">
                            <button type="submit" data-mdb-button-init
                                data-mdb-ripple-init class="btn btn-outline-success btn-block btn-lg gradient-custom-4 ">Login</button>
                        </div>

                        <!-- <p class="text-center text-muted mt-5 mb-0">You don't have an account? <a href="/"
                                class="fw-bold text-body"><u>Sign-up here</u></a></p> -->

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function login(e) {
        e.preventDefault();
        var formData = $('#loginForm').serialize();

        $.ajax({
            type: 'POST',
            url: '/login',
            data: formData,
            success: function(response) {
                if (response.role == 'manager') {
                    window.location.href = '/manager-requests';
                } else if (response.role == 'storageman') {
                    window.location.href = '/index';
                } else if (response.role == 'user') {
                    window.location.href = '/user-requests';
                }
            },
            error: function(error) {
                alert('Invalid username or password');
            }
        });
    };
</script>




@endsection