<?php

namespace App\DataTables;

use App\Models\Proprietaire;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProprietaireDataTable extends DataTable
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
            // ->addColumn('action', 'proprietaire.action')
            ->addColumn('action',function ($data){
                return $this->getActionColumn($data);
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Proprietaire $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Proprietaire $model): QueryBuilder
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
                    ->setTableId('proprietaire-table')
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
        $editUrl = route('editproprietaire', $data->id);

        return "
        <div class='row'>
        <div class='col'>
        <a href='$editUrl' class='btn btn-primary '>Editer</a>
        </div>
        <div class='col'>
        <a href='#'  onclick='deletefn($data->id)' class='btn btn-danger ' >Supprimer</a>
        </div>
        </div>
        ";
        /* <div><a class='btn btn-primary' data-value='$data->id' href='$editUrl'>Update</a></div>
        <div><button class='btn btn-danger' data-value='$data->id' >Delete</button></div>
        
        <button type='button' class='btn btn-block btn-primary btn-xs' data-value='$data->id'href='$editUrl'>Update</button> */
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
           
            'nom' ,
            'prenom' ,
            'sexe' ,
            'nationalite' ,
            'type_identite',
            'numero_identite',
                Column::computed( 'action' )
                ->exportable( FALSE )
                ->printable( FALSE )
                ->width( 200 )
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
        return 'Proprietaire_' . date('YmdHis');
    }
}
