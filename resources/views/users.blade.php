
@extends('layouts.admin')
@section('style')

<style>
    
    
     .search-container {
      float: left;
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

  <div class="container-fluid">
    <br/>
    <div class="row">
      <div class="col-12 table-responsive">
        <div class="card">
            <div class="card-header">
                <div class='row'>
                    <div class='col'>
                        <div class="card-tools">
                        <ul class="pagination pagination-sm float-right">
                        <li class="page-item"><button type="button" name="create_record" id="create_record" class="btn btn-success"> <i class="bi bi-plus-square"></i> Ajouter</button></li>
                        </ul>
                        </div>
                        <div class='col'>
                        <div class="search-container">
                            <form method="POST" class="searchForm" >
                            @csrf
                            <input type="text" placeholder="Identifiant" name="key">
                            <input type="hidden" name="type" value="username">
                            <button type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
          <table class="table table-striped table-bordered user_datatable"> 
              <thead>
                  <tr>
                      <th>Nom</th>
                      <th>Identifiant</th>
                      <th>Email</th>
                      <th>Role</th>
                      <th>Nbr de Parcelles</th>
                      <th width="180px">Action</th>
                  </tr>
              </thead>
              <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  </div>
 
  <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <form method="post" id="create" class="form-horizontal">
        <div class="modal-header">
            <h5 class="modal-title" id="ModalLabelAdd">Ajouter Agent/Admin</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <span id="form_result"></span>
            <div class="form-group">
                <label>Name : </label>
                <input type="text" name="name" id="name" class="form-control" />
            </div>
            <div class="form-group">
              <label>User Name : </label>
              <input type="text" name="username" id="username" class="form-control" />
          </div>
          <div class="form-group">
            <label>Password </label>
            <input type="text" name="password" id="password" class="form-control" />
        </div>
            <div class="form-group">
                <label>Email : </label>
                <input type="text" name="email" id="email" class="form-control" />
            </div>
          <div class="form-group">
            <label>Role : </label>
            <select name="role" id="role" class="custom-select form-control-border">
                <option value="">Role</option>
                <option value="admin">Admin</option>
                <option value="agent">Agent</option>
              </select>
            {{-- <input type="text" name="role" id="role" class="form-control" /> --}}
          </div>
           
            <input type="hidden" name="action" id="action" value="Add" />
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" name="action_button" id="action_button" value="Add" class="btn btn-info" />
        </div>
    </form>  
    </div>
    </div>
</div>
 
    <div class="modal fade" id="formUpdateModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <form method="post" id="update" class="form-horizontal">
            <div class="modal-header">
                <h5 class="modal-title" >Mise a jour</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span id="form_resultupdate"></span>
                <div class="form-group">
                    <label>Name : </label>
                    <input type="text" name="name" id="nameupdate" class="form-control" />
                </div>
           
                <div class="form-group">
                    <label>Email : </label>
                    <input type="text" name="email" id="emailupdate" class="form-control" />
                </div>
              <div class="form-group">
                <label>Role : </label>
                {{-- <input type="text" name="role" id="roleupdate" class="form-control" /> --}}
                <select name="role" id="roleupdate" class="custom-select form-control-border">
                    <option value="">Role</option>
                    <option value="admin">Admin</option>
                    <option value="agent">Agent</option>
                  </select>
              </div>
               
                <input type="hidden" name="hidden_id" id="hidden_id" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" value="Update" class="btn btn-info" />
            </div>
        </form>  
        </div>
        </div>
    </div>
 
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <form method="post" id="sample_form" class="form-horizontal">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 alignement="center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
            </div>
        </form>  
        </div>
        </div>
    </div>

@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function() {
    var table = $('.user_datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users.index') }}",
        columns: [
            {data: 'username', name: 'username'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'role', name: 'role'},
            {data: 'nbparcelle', name: 'nbparcelle'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
 
    $('#create_record').click(function(){
        // $('#action_button').val('Add');
        // $('#action').val('Add');
        $('#form_result').html('');
 
        $('#formModal').modal('show');
    });
 
    $('#create').on('submit', function(event){
        event.preventDefault(); 
        var action_url = '';

        action_url = "{{ route('users.store') }}";
 
        $.ajax({
            type: 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: action_url,
            data:$(this).serialize(),
            dataType: 'json',
            success: function(data) {
                console.log('success: '+data);
                var html = '';
                if(data.errors)
                {
                    html = '<div class="alert alert-danger">';
                    for(var count = 0; count < data.errors.length; count++)
                    {
                        html += '<p>' + data.errors[count] + '</p>';
                    }
                    html += '</div>';
                }
                if(data.success)
                {
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                    $('#create')[0].reset();
                    $('#users').DataTable().ajax.reload();
                }
                $('#form_result').html(html);
                window.location.reload();
            },
            error: function(data) {
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
    });

    $('#update').on('submit', function(event){
        event.preventDefault(); 
        var action_url = '';
 
        action_url = "{{ route('users.update') }}";
 
        $.ajax({
            type: 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: action_url,
            data:$(this).serialize(),
            dataType: 'json',
            success: function(data) {
                console.log('success: '+data);
                var html = '';
                if(data.errors)
                {
                    html = '<div class="alert alert-danger">';
                    for(var count = 0; count < data.errors.length; count++)
                    {
                        html += '<p>' + data.errors[count] + '</p>';
                    }
                    html += '</div>';
                }
                if(data.success)
                {
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                    $('#update')[0].reset();
                    $('#users').DataTable().ajax.reload();
                   
                }
                $('#form_resultupdate').html(html);
                window.location.reload();
            },
            error: function(data) {
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
    });
 
    $(document).on('click', '.edit', function(event){
        event.preventDefault(); 
        var id = $(this).attr('id'); 
        // alert(id);
        $('#form_result').html('');
 
         
 
        $.ajax({
            url :"/users/edit/"+id+"/",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType:"json",
            success:function(data)
            {
                console.log('success: '+data);
                $('#nameupdate').val(data.result.name);
                $('#emailupdate').val(data.result.email);
                $('#roleupdate').val(data.result.role);

                $('#hidden_id').val(id);
                // $('#action_button').val('Update');
                $('#action').val('Edit'); 
                $('.editpass').hide(); 
                $('#formUpdateModal').modal('show');
            },
            error: function(data) {
                var errors = data.responseJSON;
                console.log(errors);
            }
        })
    });
 
    var user_id;
 
    $(document).on('click', '.delete', function(){
        user_id = $(this).attr('id');
        $('#confirmModal').modal('show');
    });
 
    $('#ok_button').click(function(){
        $.ajax({
            url:"users/destroy/"+user_id,
            beforeSend:function(){
                $('#ok_button').text('Deleting...');
            },
            success:function(data)
            {
                setTimeout(function(){
                $('#confirmModal').modal('hide');
                $('#users').DataTable().ajax.reload();
                alert('Data Deleted');
                window.location.reload();
                }, 2000);
            }
        })
    });
});
$('.searchForm').on('submit', function(event){
        event.preventDefault(); 
        var action_url = '';
 
        action_url = "{{ route('searchagent') }}";
 
        $.ajax({
            type: 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: action_url,
            data:$(this).serialize(),
            dataType: 'json',
            success: function(data) {
                console.log('success: '+data);
                console.log(data);
                $(".user_datatable > tbody").html("");
                data.forEach(row => {
                  var row = `
                    <tr>
                      <td>${row.name}</td>
                      <td>${row.username}</td>
                      <td>${row.email}</td>
                      <td>${row.role}</td>
                      <td>${row.nbparcelle}</td>
                      <td>${row.action}</td>
                    </tr>
                  `;
                  $('.user_datatable tbody').append(row);
                });
            },
            error: function(data) {
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
    });
</script>
</html>
@endsection