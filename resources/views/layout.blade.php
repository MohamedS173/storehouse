<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Goods Storehouse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        .navbar-brand {
            font-weight: bold;
            font-size: 25px;
        }

        .navbar-brand:hover {
            color: silver;
            transform: scale(1.1);
        }

        .navbar-text {
            /* font-weight: bold; */
            font-size: 17px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container text-center ">
            <a class="navbar-brand" href="/">Storehouse</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav col  justify-content-lg-end">
                    @yield('nav')
                    <!-- <a class="nav-link" id="logout" onclick="logout(event)" href="/logout">Logout</a> -->
                    <?php
                    if (!session()->has('user_id')) {
                        echo '<a class="nav-link" id="logout" onclick="logout(event)" href="/logout" hidden>Logout</a>';
                    } else {
                        echo '<a class="nav-link" id="logout" onclick="logout(event)" href="/logout">Logout</a>';
                    }
                    ?>
                    @if(session()->has('user_id'))
                    @foreach ($loggedUser as $user)
                    <span class="navbar-text text-white ps-4">
                        you are logged as
                        , <span class="suser text-warning border-bottom border-warning border-1">{{$user->role}}</span>
                    </span>


                    @break
                    @endforeach

                    @endif

                </div>
            </div>
        </div>
    </nav>
    @yield('content')




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        function logout(e) {
            e.preventDefault();


            $.ajax({
                type: 'GET',
                url: '/logout',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    alert('loggedout successful');
                    window.location.href = '/login';
                },
                error: function(error) {
                    alert('there is an error in logout process');
                    console.log('Error:', error);
                }
            });
        };
    </script>



</body>

</html>