<?php

namespace App\DataTables;

use App\Models\Parcelle;
use App\Models\User;
use App\Models\Village;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

use App\Models\Proprietaire;

use Auth;

class ParcellesDataTable extends DataTable
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
            // ->addColumn('action', 'parcelles.action')
            ->addColumn('action',function ($data){
                return $this->getActionColumn($data);
            })
            ->addColumn('Proprietaire',function ($data){
                return $this->getProprietaireColumn($data);
            })
            ->addColumn('Village',function ($data){
                return $this->getVillageColumn($data);
            })
            ->addColumn('Agent',function ($data){
                return $this->getAgentColumn($data);
            })
            ->addColumn("Demande d'immatriculation",function ($data){
                return $this->getDMIColumn($data);
            })
            ->setRowId('id')
            ->rawColumns(["Demande d'immatriculation", 'action']);
    }

    protected function getActionColumn($data): string
    {
        $editUrl = route('editparcelle', $data->id);

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
    }

    protected function getDMIColumn($data): string
    {
        $downloadUrl = route('getdmi', $data->id);

        $disable = 'disabled';

        if(Auth::user()->role == "admin"){
            $disable = '';
        }

        return "
        <div class='row'>
        <div class='col'>
        <a href='$downloadUrl' class='btn btn-success $disable' target='_blank'>Telecharger</a>
        </div>
        </div>
        ";
    }

    protected function getProprietaireColumn($data): string
    {
        $pro = Proprietaire::where('id', $data->proprietaire_id)->first();
        if($pro != null) return $pro->nom;
        return "$data->proprietaire_id";
    }

    protected function getVillageColumn($data): string
    {
        $village = Village::where('id', $data->village_id)->first();
        if($village != null) return $village->nom;
        return "";
    }

    protected function getAgentColumn($data): string
    {
        $agent = User::where('id', $data->user_id)->first();
        if($agent != null) return $agent->name;
        return "";
    }


    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Parcelle $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Parcelle $model): QueryBuilder
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
                    ->setTableId('parcelles-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            'numero' ,
            Column::computed( 'Proprietaire' )
                ->width( 100 )
                ->addClass( 'text-center' ),
            Column::computed( 'Village' )
                ->width( 100 )
                ->addClass( 'text-center' ),
            'date_delimation',
            Column::computed( 'Agent' )
                ->width( 100 )
                ->addClass( 'text-center' ),
            Column::computed( 'action' )
                ->exportable( FALSE )
                ->printable( FALSE )
                ->width( 200 )
                ->addClass( 'text-center' ),
            Column::computed("Demande d'immatriculation")
                ->exportable( FALSE )
                ->printable( FALSE )
                ->width( 50 )
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
        return 'Parcelles_' . date('YmdHis');
    }
}
