<?php

namespace App\DataTables;

use App\Models\Village;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VillagesDataTable extends DataTable
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
            // ->addColumn('action', 'villages.action')
            ->addColumn('action',function ($data){
                return $this->getActionColumn($data);
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Village $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Village $model): QueryBuilder
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
                    ->setTableId('villages-table')
                    ->columns($this->getColumns())
                    
                    ->minifiedAjax()
                    ->parameters($this->getBuilderParameters());
                }

    /**
     * @param $data
     * @return string
     */
    protected function getActionColumn($data): string
    {
        $editUrl = route('editvillage', $data->id);

        return "  
        <div class='row'>
        <div class='col'>
        <a  href='$editUrl' class='btn btn-primary '>Editer</a>
        </div>
        <div class='col'>
        <a href='#'  onclick='deletefn($data->id)' class='btn btn-danger '>Supprimer</a>
        </div>
        </div>";
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
        return 'Villages_' . date('YmdHis');
    }
}
