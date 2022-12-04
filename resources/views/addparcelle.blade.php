@extends('layouts.admin')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Add</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Parcelle</li>
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
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
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
                <form action="{{ route('saveparcelle') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                  <div class="card-body">
              
                    <div class="form-group">
                      <label for="exampleInputEmail1">Numero</label>
                      <input type="text" class="form-control" name="numero" placeholder="Numero">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Numero d'identite du proprietaire</label>
                        <select name="proprietaire_id"  class="custom-select form-control-border">
                          <option value="">Numero d'identite du proprietaire</option>
                          @foreach($proprietaires as $proprietaire)
                          <option value="{{ $proprietaire->id  }}">{{ $proprietaire->numero_identite }}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Date delimitation</label>
                        <input type="date" class="form-control" name="Date_delimitation" placeholder="Date delimitation">
                    </div>
                  
                    <div class="form-group">
                        <label >Nom de Village</label>
                        <select name="village_id"  class="custom-select form-control-border">
                          <option value="">Nom de Village</option>
                          @foreach($villages as $village)
                          <option value="{{ $village->id  }}">{{ $village->nom }}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                      <label >Signature </label>
                  </div>
                  <div class="form-group">
                    <textarea name="signature" placeholder="Signature"></textarea>
                </div>
  
                @if($isAdmin)
                  <div class="form-group">
                      <label for="exampleInputEmail1">Agent</label>
                      <select name="agent_id" class="custom-select form-control-border">
                          <option value="">Agent</option>
                          @foreach($agents as $agent)
                          <option value="{{ $agent->id  }}">{{ $agent->name }}</option>
                          @endforeach
                      </select>
                  </div>
                @endif
                  


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
