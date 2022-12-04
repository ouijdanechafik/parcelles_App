@extends('layouts.admin')
@section('style')

<style>
    
    
     .search-container {
      float: right;
    }
    
     input[type=text] {
      padding: 6px;
      margin-top: 8px;
      font-size: 17px;
      border: none;
    }
    
     .search-container button {
      float: right;
      padding: 6px 10px;
      margin-top: 8px;
      margin-right: 16px;
      background: #ddd;
      font-size: 17px;
      border: none;
      cursor: pointer;
    }
    
    

    </style>

@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Proprietaire</a></li>
          </ol>
          
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  
  <section class="content">
    
    <div class="container-fluid">
        <div class="card">
      <div class="card-header">
        <h3 class="card-title"></h3>
        <div class="card-tools">
        <ul class="pagination pagination-sm float-right">
        <li class="page-item"><a class="btn btn-success" href="/addproprietaire">Ajouter Proprietaire</a></li>
        </ul>
        </div>
        <div class='row'>
            <div class='col'>
        <div class="search-container">
            <form method="POST" class="searchForm" >
              @csrf
              <input type="text" placeholder="Nom" name="key">
              <input type="hidden" name="type" value="nom">
              <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
          </div>
          <div class='col'>
          <div class="search-container">
            <form method="POST" class="searchForm" >
              @csrf
              <input type="text" placeholder="Prenom" name="key">
              <input type="hidden" name="type" value="prenom">
              <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
          </div>
          <div class='col'>
          <div class="search-container">
            <form method="POST" class="searchForm" >
              @csrf
              <input type="text" placeholder="Numero d'identite" name="key">
              <input type="hidden" name="type" value="numero_identite">
              <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
          </div>
        </div>
       
        </div>
        <div class="card-body">
            {!! $dataTable->table() !!}
        </div>
        </div>
    </div>
  </section>

  {!! $dataTable->scripts() !!}
@endsection

@section('script')


<!-- CSS only -->
<script >

  function deletefn(id){
      Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
          if (result.isConfirmed) {
              window.location.replace('/deleteproprietaire/'+id);
          }
      })
  }

  $('.searchForm').on('submit', function(event){
        event.preventDefault(); 
        var action_url = '';
 
        action_url = "{{ route('searchp') }}";
 
        $.ajax({
            type: 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: action_url,
            data:$(this).serialize(),
            dataType: 'json',
            success: function(data) {
                console.log('success: '+data);
                console.log(data);
                $("#proprietaire-table > tbody").html("");
                data.forEach(row => {
                  var row = `
                    <tr>
                      <td>${row.nom}</td>
                      <td>${row.prenom}</td>
                      <td>${row.sexe}</td>
                      <td>${row.nationalite}</td>
                      <td>${row.type_identite}</td>
                      <td>${row.numero_identite}</td>
                      <td>${row.action}</td>
                    </tr>
                  `;
                  $('#proprietaire-table tbody').append(row);
                });
            },
            error: function(data) {
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
    });


</script>
@endsection
