@extends('layouts.admin')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Ajouter</h1>
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
                <form action="/saveuser" method="POST" enctype="multipart/form-data">
                    @csrf
                  <div class="card-body">
                
                    <div class="form-group">
                      <label for="exampleInputEmail1">Name</label>
                      <input type="text" class="form-control" name="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label >Email</label>
                        <input type="text" class="form-control" name="email" placeholder="Email">
                    </div>
                   
                    <div class="form-group">
                        <label for="exampleInputEmail1">User name</label>
                        <input type="text" class="form-control" name="username" placeholder="username">
                    </div>
                  
                    <div class="form-group">
                        <label >Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputEmail1">Role</label>
                        <select name="role" class="form-control">
                            <option value="admin">Admin</option>
                            <option value="user">Agent</option>
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
            <div class="col-md-6" style="padding: 40px; ">
                <img src="" id="img" width="100%" />
            </div>
          </div>
        </div>
    </section>
    <script type="text/javascript">
        imgInp = document.getElementById("image");
        img = document.getElementById("img");
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                img.src = URL.createObjectURL(file)
            }
        }


    </script>
@endsection
