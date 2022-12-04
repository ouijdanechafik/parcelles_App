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
            <li class="breadcrumb-item"><a href="#">Parcelles</a></li>
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
        <li class="page-item"><a class="btn btn-success" href="{{ route('addparcelle')}}">Ajouter</a></li>
        </ul>
        </div>
        <div class='row float-left'>
                <div class='col'>
                <div class="search-container">
                    <form method="POST" class="searchForm" >
                    @csrf
                    <input type="text" placeholder="Numero" name="key">
                    <input type="hidden" name="type" value="nom">
                    <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                </div>
                <div class='col'>
                <div class="search-container">
                    <form method="POST" class="searchForm" >
                    @csrf
                    <input type="text" placeholder="Agent" name="key">
                    <input type="hidden" name="type" value="prenom">
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
              window.location.replace('/deleteparcelle/'+id);
          }
      })
  }

  $('.searchForm').on('submit', function(event){
        event.preventDefault(); 
        var action_url = '';
 
        action_url = "{{ route('searchparcelles') }}";
 
        $.ajax({
            type: 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: action_url,
            data:$(this).serialize(),
            dataType: 'json',
            success: function(data) {
                console.log('success: '+data);
                console.log(data);
                $("#parcelles-table > tbody").html("");
                data.forEach(row => {
                  var row = `
                    <tr>
                      <td>${row.numero}</td>
                      <td>${row.p_nom}</td>
                      <td>${row.village_nom}</td>
                      <td>${row.date_delimation}</td>
                      <td>${row.nom_agent}</td>
                      <td>${row.action}</td>
                      <td>${row.link}</td>
                    </tr>
                  `;
                  $('#parcelles-table tbody').append(row);
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