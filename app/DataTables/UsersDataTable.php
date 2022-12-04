<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\Parcelle;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    

    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            //->addColumn('action', 'users.action')
            ->addColumn('action',function ($data){
                return $this->getActionColumn($data);
            })
            ->addColumn('Nbrdeparcelles',function ($data){
                return $this->getNbrdeparcellesColumn($data);
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('users-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->parameters($this->getBuilderParameters());
                    
                 
                    
                  
    }
     /**
     * @param $data
     * @return string
     */
    protected function getActionColumn($data): string
    {
        $deleteUrl = route('deleteuser', $data->id);

        return "  
        <div class='row'>
        <div class='col'>
        <button type='button' class='btn btn-primary data-value='$data->id' href='$deleteUrl' onclick='deleteuser({{$data->id}})'>Editer</button>
        </div>
        <div class='col'>
        <button type='button' class='btn btn-danger '>Supprimer</button>
        </div>
        </div>";
    }

    protected function getNbrdeparcellesColumn($data): string
    {
        $items = Parcelle::where('id', $data->id)->get();
        return $items->count();
    }

    

    /**


     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            'id' ,
            'name' ,
            'email',
            'username',
            'role',
            Column::computed( 'action' )
            ->exportable( FALSE )
            ->printable( FALSE )
            ->width( 200 )
            ->addClass( 'text-center' ),
            Column::computed( 'Nbrdeparcelles' )
            ->width( 100 )
            ->addClass( 'text-center' ),
  ];
            
        
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
