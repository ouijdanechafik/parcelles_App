@extends('layouts.admin')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Edit</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
          <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Form</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="/Updateuser" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="form-control" value="{{$user->id}}" name="id" >

                  <div class="card-body">
                    <div class="form-group">
                      <label >Name</label>
                      <input type="text" class="form-control" value="{{$user->name}}" name="name" placeholder="name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">User name</label>
                        <input type="text" class="form-control" value="{{$user->username}}" name="username" placeholder="username">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="text" class="form-control" value="{{$user->email}}" name="email" placeholder="email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Phone</label>
                        <input type="password" class="form-control" value="{{$user->password}}" name="password" placeholder="password">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputEmail1">Gender</label>
                        <select name="gender" class="form-control">
                            <option value="female"
                                @if($user->gender == "female")
                                    selected
                                @endif
                            >Female</option>

                            <option value="male"
                                @if($user->gender == "male")
                                    selected
                                @endif
                            >Male</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Role</label>
                        <select name="role" class="form-control">
                            <option value="admin"
                            @if($user->role == "admin")
                                selected
                            @endif
                            >Admin</option>
                            <option value="user"
                            @if($user->role == "user")
                                selected
                            @endif
                            >Agent</option>



                        </select>
                    </div>


                </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                  </div>
                </form>
              </div>
              <!-- /.card -->
            </div>
           
          </div>
        </div>
    </section>
    
@endsection
