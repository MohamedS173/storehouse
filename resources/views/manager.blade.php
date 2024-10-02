@extends('layout')

@section('nav')

<?php
if(session('role') == 'manager'){ 
    echo '<a class="nav-link " href="/index">Storage</a>';
    echo '<a class="nav-link " href="/user-requests">Request Page</a>';
    echo '<a class="nav-link active border-bottom border-warning border-1 text-warning " aria-current="page" href="/manager-requests">Requests List</a>';
    echo '<a class="nav-link "  href="/register">Registeration</a>';
}
?>

@endsection

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="services_taital">Pending <span class="text-warning border-bottom border-warning border-2">Requests</span></h1>
        </div>
        <div class="col-sm-12 mt-5">
            @if (session('status'))
            <h6 class="alert alert-success"> {{session('status')}}</h6>
            @endif
            <table  class="table table-bordered table-hover mt-5">
                <thead class="table-dark">
                    <tr>
                        <th>Goods ID</th>
                        <th>Item Name</th>
                        <th>User</th>
                        <th>Available Quantity</th>
                        <th>Requested Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $request)
                    <tr id="request-{{ $request->id }}">
                        <td>{{ $request->goods->id }}</td>
                        <td>{{ $request->goods->name }}</td>
                        <td>{{ $request->id }}</td>
                        <td>{{ $request->goods->quantity }}</td>
                        <td>{{ $request->quantity }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-success" onclick="approveRequest('{{ $request->id }}')">Approve</button>
                            <button class="btn btn-sm btn-outline-danger" onclick="rejectRequest('{{ $request->id }}')">Reject</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
</div>

<script>
    function approveRequest(id) {
        $.ajax({
            type: 'POST',
            url: `/approve-request/${id}`,
            data: { _token: "{{ csrf_token() }}" },
            success: function(response) {
                alert(response.success);
                $('#request-' + id).remove();
            },
            error: function(xhr) {
                alert('Error approving request');
            }
        });
    }

    function rejectRequest(id) {
        $.ajax({
            type: 'POST',
            url: `/reject-request/${id}`,
            data: { _token: "{{ csrf_token() }}" },
            success: function(response) {
                alert(response.success);
                $('#request-' + id).remove();
            },
            error: function(xhr) {
                alert('Error rejecting request');
                // console.log(error);
            }
        });
    }
</script>










@endsection