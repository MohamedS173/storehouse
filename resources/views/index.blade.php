@extends('layout')

@section('nav')

<?php
if(session('role') == 'manager'){ 
    echo '<a class="nav-link active border-bottom border-warning border-1 text-warning" aria-current="page" href="/index">Storage</a>';
    echo '<a class="nav-link " href="/user-requests">Request Page</a>';
    echo '<a class="nav-link " href="/manager-requests">Requests List</a>';
    echo '<a class="nav-link "  href="/register">Registeration</a>';
}
?>
@endsection



@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="services_taital">Available <span class="text-warning border-bottom border-warning border-2">Goods</span></h1>
            </div>
            <div class="col-sm-12 mt-5 text-center">
                @if (session('status'))
                <h6 class="alert alert-success"> {{session('status')}}</h6>
                @endif
                <table class="table table-bordered  table-hover mt-5">
                    <thead class="table-dark">
                        <tr>
                            <td>Id</td>
                            <td>Item Name</td>
                            <td>Quantity</td>
                            <td>
                                Add/change Data
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                                    Add New Data
                                </button>

                                <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#additemsModal">
                                    Add Items Type
                                </button>
                                
                                <div class="modal fade text-start" id="additemsModal" tabindex="-1" aria-labelledby="additemsModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="modal-title text-dark" id="additemsModalLabel">Add Items Type</h2>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/add-itemtype" method="post" id="addtypeForm" onsubmit="type(event)">
                                                    @csrf

                                                    <div class="form-group mb-3">
                                                        <label for="" class="text-dark">Item Type</label>
                                                        <input type="text" class="form-control" id="type-add" name="type" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
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

                                <!-- Modal -->
                                <div class="modal fade text-start" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="modal-title text-dark" id="addModalLabel">Add Data</h2>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/add-item" method="post" id="addForm" onsubmit="store(event)">
                                                    @csrf
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                    <div class="form-group mb-3">

                                                        <label for="" class="text-dark">Item type</label>
                                                        <select class="form-select form-select-sm" name="items" aria-label=".form-select-sm example" id="items_select">
                                                            <option value="" >Item Types</option>
                                                            @foreach ($users as $data)
                                                            <option name="item" id="item_id" value="{{$data->id}}">{{$data->id}}:{{$data->name}}</option>
                                                            
                                                            @endforeach
                                                            
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="" class="text-dark">Quntity</label>
                                                        <input type="number" class="form-control" id="quntity-add" name="quantity" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
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
                            </td>
                        </tr>
                    </thead>
                    <tbody id="equipTableBody">
                        @foreach ($users as $key => $data)

                        <tr id="tab_{{$data->id}}">
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->quantity }}</td>

                            <td>

                                
                                <input type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#addquntityModal" onClick="changeUserId(this)" data-user-id="{{ $data->id }}" value="Add">
                                <input type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#takequntityModal" onClick="getUserId(this)" data-user-id="{{ $data->id }}" value="Take">
                                <a href="/delete-item/{{$data->id}}"><input type="button" class="btn btn-sm btn-outline-danger" onClick="deleteUser('{{$data->id}}')" data-user-id="{{ $data->id }}" value="Delete"></a>
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <!-- Modal -->
                    <div class="modal fade text-start" id="addquntityModal" tabindex="-1" aria-labelledby="addquntityModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="addquntityModalLabel">add items</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="/additem" id="additems_form" onsubmit="additem(event)" method="post">
                                        {{csrf_field()}}
                                        
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        
                                        <input type="hidden" name="user_id" data-user-id="" id="myUser_id" value="">
                                        
                                        <div class="form-group mb-3">
                                            <label for="" class="text-dark">Quantity</label>
                                            <input type="number" class="form-control" id="quntity" name="quantity_change">
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
                    <!-- Modal -->
                    <div class="modal fade text-start" id="takequntityModal" tabindex="-1" aria-labelledby="takequntityModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="takequntityModalLabel">add items</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="/takeitem" id="takeitems_form" onsubmit="takeitem(event)" method="post">
                                        {{csrf_field()}}
                                        <!-- Make sure to use PUT for update -->
                                        <!-- @method('post') -->
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="usert_id" data-user-id="" id="myUsert_id" value="">
                                    
                                        <div class="form-group mb-3">
                                            <label for="" class="text-dark">Quantity</label>
                                            <input type="number" class="form-control" id="quntity_take" name="quantity_change">
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
                </table>

            </div>
        </div>
    </div>




    
<script>
    function type(event) {
        event.preventDefault(); // Prevent form submission
        var formData = new FormData(event.target);
        

        $.ajax({
            url: '/add-itemtype',
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function(response) {
                alert('User added successfully!');

                $('#additemsModal').hide('fast'); // Close the modal after success
                // fetch('#services');
                $('.modal-backdrop').hide('fast'); // Close the modal backdrop
                location.reload();
            },
            error: function(error) {
                console.log('Error:', error);
                alert('Failed to add user!');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }


    function store(event) {
        event.preventDefault(); // Prevent form submission
        var formData = new FormData(event.target);
        // const itemId = document.getElementById('item-select').value;
        
        var myUserId = $('#items_select').val();
        $("#item-select option:selected").val(myUserId);
        formData.append('item_id', myUserId);
        // $("#item_id").attr('value', myUserId);
        

        $.ajax({
            url: '/add-item',
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function(response) {
                console.log(response['item_id']);
                // $("#item_id").val(response['item']);
                alert('Item added successfully!');

                $('#addModal').hide('fast'); // Close the modal after success
                // fetch('#services');
                $('.modal-backdrop').hide('fast'); // Close the modal backdrop
                location.reload();
            },
            error: function(error) {
                console.log(myUserId);
                // console.log($("#item_select"));

                console.log('Error:', error);
                alert('Failed to add user!');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    function changeUserId(elm) {
        //alert($(elm).attr('data-user-id'));
        var myUserId = $(elm).attr('data-user-id');
        $("#myUser_id").attr('data-user-id', myUserId);
        $.ajax({
            url: "/get-item",
            type: "GET",
            data: {
                'user_id': myUserId
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response['user_id']);
                console.log(response['name_change']);
                console.log(response['quantity_change']);

                $("#myUser_id").val(response['user_id']);
                $("#itemname").val(response['name_change']);
                // $("#quntity").val(response['quantity_change']);

                //$("#equipTableBody").html(response);
            },
            error: function(error) {
                console.log("Error:", error);
            }
        });
    }

    function getUserId(elm) {
        //alert($(elm).attr('data-user-id'));
        var myUserIdTake = $(elm).attr('data-user-id');
        $("#myUsert_id").attr('data-user-id', myUserIdTake);
        $.ajax({
            url: "/getitemtype",
            type: "GET",
            data: {
                'user_id': myUserIdTake
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response['usert_id']);
                console.log(response['name_change']);
                console.log(response['quantity_change']);

                $("#myUsert_id").val(response['usert_id']);
                $("#itemname").val(response['name_change']);
                // $("#quntity_take").val(response['quantity_change']);

                //$("#equipTableBody").html(response);
            },
            error: function(error) {
                console.log("Error:", error);
            }
        });
    }


    function additem(e) {
        event.preventDefault(); // Prevent form submission
        var formData = new FormData(event.target);


        var userId = $('#myUser_id').attr('data-user-id'); // Get user id
        //alert(userId);
        // var userId = $(elm).attr('data-user-id'); // Get user id



        $.ajax({
            url: '/additem',
            type: 'POST',

            data: formData,
            // headers: {
            //    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            success: function(response) {
                // Handle successful response, refresh the table or show a message
                // console.log(data);
                // console.log(data);
                if(response.success) {
                    alert('Quantity updated successfully. New Quantity: ' + response.new_quantity);
                    console.log('Quantity updated successfully. New Quantity: ' + response.new_quantity);
                
                    // console.log(response);


                    // $("#tab_" + userId).html(response);

                    //alert('User updated successfully!');
                    $('#addquntityModal').hide(''); // Close the modal after success
                    $('.modal-backdrop').hide(''); // Close the modal backdrop
                    // fetch('#services');


                    location.reload(); // Reload the page to see changes (optional)
                }
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

    function takeitem(e) {
        event.preventDefault(); // Prevent form submission
        var formtData = new FormData(event.target);


        var userId = $('#myUsert_id').attr('data-user-id'); // Get user id
        //alert(userId);
        // var userId = $(elm).attr('data-user-id'); // Get user id



        $.ajax({
            url: '/takeitem',
            type: 'POST',

            data: formtData,
            // headers: {
            //    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            success: function(response) {
                // Handle successful response, refresh the table or show a message
                // console.log(data);
                // console.log(data);
                if(response.success) {
                    alert('Quantity updated successfully. New Quantity: ' + response.new_quantity);
                    // console.log('Quantity updated successfully. New Quantity: ' + response.new_quantity);
                
                    // console.log(response);


                    // $("#tab_" + userId).html(response);

                    //alert('User updated successfully!');
                    $('#takequntityModal').hide(''); // Close the modal after success
                    $('.modal-backdrop').hide(''); // Close the modal backdrop
                    // fetch('#services');


                    location.reload(); // Reload the page to see changes (optional)
                }
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
            url: '/delete-item/' + userId,
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





     // function store(event) {
    //     event.preventDefault(); // Prevent form submission
    //     var formData = new FormData(event.target);
        

    //     $.ajax({
    //         url: '/add-item',
    //         type: 'POST',
    //         data: formData,
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },

    //         success: function(response) {
    //             alert('User added successfully!');

    //             $('#addModal').hide('fast'); // Close the modal after success
    //             // fetch('#services');
    //             $('.modal-backdrop').hide('fast'); // Close the modal backdrop
    //             location.reload();
    //         },
    //         error: function(error) {
    //             console.log('Error:', error);
    //             alert('Failed to add user!');
    //         },
    //         cache: false,
    //         contentType: false,
    //         processData: false
    //     });
    // }

    // function changeUserId(elm) {
    //     //alert($(elm).attr('data-user-id'));
    //     var myUserId = $(elm).attr('data-user-id');
    //     $("#myUser_id").attr('data-user-id', myUserId);
    //     $.ajax({
    //         url: "/getitem",
    //         type: "GET",
    //         data: {
    //             'user_id': myUserId
    //         },
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(response) {
    //             console.log(response['user_id']);
    //             console.log(response['name_change']);
    //             console.log(response['quantity_change']);

    //             $("#myUser_id").val(response['user_id']);
    //             $("#itemname").val(response['name_change']);
    //             $("#quntity").val(response['quantity_change']);

    //             //$("#equipTableBody").html(response);
    //         },
    //         error: function(error) {
    //             console.log("Error:", error);
    //         }
    //     });
    // }

    // function addUserId(elm) {
    //     //alert($(elm).attr('data-user-id'));
    //     var myUserId = $(elm).attr('data-user-id');
    //     $("#myUsera_id").attr('data-user-id', myUserId);
    //     $.ajax({
    //         url: "/get-item",
    //         type: "GET",
    //         data: {
    //             'user_id': myUserId
    //         },
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(response) {
    //             console.log(response['usera_id']);
    //             console.log(response['name_change']);
    //             console.log(response['quantity_change']);

    //             $("#myUsera_id").val(response['user_id']);
    //             $("#itemname").val(response['name_change']);
    //             $("#quntity").val(response['quantity_change']);

    //             //$("#equipTableBody").html(response);
    //         },
    //         error: function(error) {
    //             console.log("Error:", error);
    //         }
    //     });
    // }

    // function getUserId(elm) {
    //     //alert($(elm).attr('data-user-id'));
    //     var myUserIdTake = $(elm).attr('data-user-id');
    //     $("#myUsert_id").attr('data-user-id', myUserIdTake);
    //     $.ajax({
    //         url: "/getitemtype",
    //         type: "GET",
    //         data: {
    //             'user_id': myUserIdTake
    //         },
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(response) {
    //             console.log(response['usert_id']);
    //             console.log(response['name_change']);
    //             console.log(response['quantity_change']);

    //             $("#myUsert_id").val(response['usert_id']);
    //             $("#itemname").val(response['name_change']);
    //             $("#quntity_take").val(response['quantity_change']);

    //             //$("#equipTableBody").html(response);
    //         },
    //         error: function(error) {
    //             console.log("Error:", error);
    //         }
    //     });
    // }


    // function edititem(e) {
    //     event.preventDefault(); // Prevent form submission
    //     var formData = new FormData(event.target);


    //     var userId = $('#myUser_id').attr('data-user-id'); // Get user id
    //     //alert(userId);
    //     // var userId = $(elm).attr('data-user-id'); // Get user id



    //     $.ajax({
    //         url: '/update-item',
    //         type: 'POST',

    //         data: formData,
    //         // headers: {
    //         //    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         // },
    //         success: function(response) {
    //             // Handle successful response, refresh the table or show a message
    //             // console.log(data);
    //             // console.log(data);
    //             if(response.success) {
    //                 alert('Quantity updated successfully. New Quantity: ' + response.new_quantity);
    //                 console.log('Quantity updated successfully. New Quantity: ' + response.new_quantity);
                
    //                 // console.log(response);


    //                 $("#tab_" + userId).html(response);

    //                 //alert('User updated successfully!');
    //                 $('#editModal').hide('fast'); // Close the modal after success
    //                 $('.modal-backdrop').hide('fast'); // Close the modal backdrop
    //                 // fetch('#services');


    //                 location.reload(); // Reload the page to see changes (optional)
    //             }
    //         },
    //         error: function(error) {
    //             console.log('Error:', error);
    //             //alert('Failed to update user!');
    //         },
    //         cache: false,
    //         contentType: false,
    //         processData: false
    //     });
    // }


    // function additem(e) {
    //     event.preventDefault(); // Prevent form submission
    //     var formData = new FormData(event.target);


    //     var userId = $('#myUsera_id').attr('data-user-id'); // Get user id
    //     //alert(userId);
    //     // var userId = $(elm).attr('data-user-id'); // Get user id



    //     $.ajax({
    //         url: '/additem',
    //         type: 'POST',

    //         data: formData,
    //         // headers: {
    //         //    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         // },
    //         success: function(response) {
    //             // Handle successful response, refresh the table or show a message
    //             // console.log(data);
    //             // console.log(data);
    //             if(response.success) {
    //                 alert('Quantity updated successfully. New Quantity: ' + response.new_quantity);
    //                 console.log('Quantity updated successfully. New Quantity: ' + response.new_quantity);
                
    //                 // console.log(response);


    //                 $("#tab_" + userId).html(response);

    //                 //alert('User updated successfully!');
    //                 $('#addquntityModal').hide('fast'); // Close the modal after success
    //                 $('.modal-backdrop').hide('fast'); // Close the modal backdrop
    //                 // fetch('#services');


    //                 location.reload(); // Reload the page to see changes (optional)
    //             }
    //         },
    //         error: function(error) {
    //             console.log('Error:', error);
    //             //alert('Failed to update user!');
    //         },
    //         cache: false,
    //         contentType: false,
    //         processData: false
    //     });
    // }


    // function takeitem(e) {
    //     // event.preventDefault(); // Prevent form submission
    //     var formtData = new FormData(event.target);


    //     var userId = $('#myUsert_id').attr('data-user-id'); // Get user id
    //     //alert(userId);
    //     // var userId = $(elm).attr('data-user-id'); // Get user id



    //     $.ajax({
    //         url: '/takeitem',
    //         type: 'POST',

    //         data: formtData,
    //         // headers: {
    //         //    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         // },
    //         success: function(response) {
    //             // Handle successful response, refresh the table or show a message
    //             // console.log(data);
    //             // console.log(data);
    //             if(response.success) {
    //                 alert('Quantity updated successfully. New Quantity: ' + response.new_quantity);
    //                 console.log('Quantity updated successfully. New Quantity: ' + response.new_quantity);
                
    //                 // console.log(response);


    //                 $("#tab_" + userId).html(response);

    //                 //alert('User updated successfully!');
    //                 $('#takequntityModal').hide('fast'); // Close the modal after success
    //                 $('.modal-backdrop').hide('fast'); // Close the modal backdrop
    //                 // fetch('#services');


    //                 location.reload(); // Reload the page to see changes (optional)
    //             }
    //         },
    //         error: function(error) {
    //             console.log('Error:', error);
    //             //alert('Failed to update user!');
    //         },
    //         cache: false,
    //         contentType: false,
    //         processData: false
    //     });
    // }


    // function deleteUser(userId) {
    //     // let userId = $('#myUser_id').val();
    //     $.ajax({
    //         url: '/delete-item/' + userId,
    //         type: 'GET',
    //         data: {
    //             _token: $('input[name=_token]').val() // Include CSRF token
    //         },
    //         success: function(response) {
    //             alert('User deleted successfully!');
    //             location.reload(); // Reload the page to reflect changes (optional)
    //         },
    //         error: function(error) {
    //             console.log('Error:', error);
    //             // alert('User deleted successfully!');
    //             alert('Failed to delete user!');
    //         }
    //     });
    // }
</script>


@endsection