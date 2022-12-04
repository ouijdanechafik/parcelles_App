@extends('layouts.admin')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Update</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Proprietaire</li>
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
                <form action="{{ route('updateproprietaire') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$proprietaire->id}}" />
                    <input type="hidden" name="id_img" value="{{$photo->id}}" />
                  <div class="card-body">
              
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nom</label>
                      <input type="text" class="form-control" value='{{$proprietaire->nom}}' name="nom" placeholder="Nom">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Prenom</label>
                        <input type="text" class="form-control" value='{{$proprietaire->prenom}}'  name="prenom" placeholder="Prenom">
                    </div>
                    <div class="col-sm-6">
                      <!-- radio -->
                      <div class="form-group">
                        <label for="exampleInputEmail1">Sexe</label>
                        <div class="form-check">
                          <input class="form-check-input"
                          @if($proprietaire->sexe == 'homme')
                            @checked(true)
                          @endif type="radio" name="sexe" value="homme">
                          <label class="form-check-label"
                          
                          >Homme</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input"
                          @if($proprietaire->sexe == 'femme')
                            @checked(true)
                          @endif
                          type="radio" name="sexe" value="femme">
                          <label class="form-check-label">Femme</label>
                        </div>
                        
                      </div>
                    </div>
                  
                    <div class="form-group">
                        <label >Nationalite</label>
                        <input type="text" class="form-control" value='{{$proprietaire->nationalite}}' name="nationalite" placeholder="Nationalite">
                    </div>
                    <div class="form-group">
                        <label >Type identite</label>
                        <select name="type_identite"  class="custom-select form-control-border">
                          <option value="">Type identite</option>
                          <option value="permis"
                            @if($proprietaire->type_identite == 'permis')
                            @selected(true)
                            @endif
                          >Permis</option>
                          <option value="carte de resident"
                          @if($proprietaire->type_identite == 'carte de resident')
                            @selected(true)
                            @endif
                          >Carte de résident</option>
                          <option value="CIN"
                          @if($proprietaire->type_identite == 'CIN')
                            @selected(true)
                            @endif
                          >CIN</option>
                          <option value="PASSPORT"
                          @if($proprietaire->type_identite == 'PASSPORT')
                            @selected(true)
                            @endif
                          >PASSPORT</option>
                        </select>
                       
                  </div>

                  <div class="form-group">
                    <label >Numero d'identite</label>
                    <input type="text" class="form-control"  value='{{$proprietaire->numero_identite}}' name="numero_identite" placeholder="Numero d'identite">
                    
              </div>
              <div class="form-group">
                <label for="exampleInputFile">Image</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="image" id="image">
                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">Upload</span>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                    <img src='{{ asset("images/$photo->src") }}' width="150px" height="100px" />
                </div>
              </div>
              <div class="form-group">
                <label >Adresse</label>
                <input type="text" value="{{ $proprietaire->adresse }}" class="form-control" name="adresse" placeholder="Adresse">
                
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
