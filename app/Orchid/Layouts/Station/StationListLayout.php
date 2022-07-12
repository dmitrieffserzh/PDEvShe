<?php

declare( strict_types=1 );

namespace App\Orchid\Layouts\Station;

use App\Models\Post;
use App\Models\Station;
use Illuminate\Support\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class StationListLayout extends Table {

    public $target = 'station';

    public function columns(): array {

        return [

            TD::make( 'id', 'ID' )
              ->sort()
              ->cantHide()
              ->filter( Input::make() )
              ->render( function ( Station $station ) {
                  return '<strong>' . $station->id . '</strong>';
              } )->width( '100px' ),
            TD::make( 'title', 'Название' )
              ->sort()
              ->cantHide()
              ->filter( Input::make() )
                ->render( function ( Station $station) {
                    return '<b>' . Link::make( $station->name )
                                       ->route( 'platform.stations.edit', $station->id ) . '</b>';
                } ),
            TD::make( 'created_at', 'Дата создания' )
              ->sort()
              ->cantHide()
              ->filter( Input::make() )
              ->render( function ( Station $station ) {
                  return Carbon::parse( $station->created_at )->format( "d.m.Y H:i:s" );
              } ),
            TD::make( 'updated_at', 'Дата редактирования' )
              ->sort()
              ->cantHide()
              ->filter( Input::make() )
              ->render( function ( Station $station ) {
                  return Carbon::parse( $station->updated_at )->format( "d.m.Y H:i:s" );
              } ),
            TD::make( __( 'Actions' ) )
              ->align( TD::ALIGN_CENTER )
              ->width( '100px' )
              ->render( function ( Station $station ) {
                  return DropDown::make()
                                 ->icon( 'options-vertical' )
                                 ->list( [
                                     Link::make( __( 'Edit' ) )
                                         ->route( 'platform.stations.edit', $station->id )
                                         ->icon( 'pencil' ),

                                     Button::make( __( 'Delete' ) )
                                           ->icon( 'trash' )->style( 'color: #df0031;' )
                                           ->confirm( __( 'Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.' ) )
                                           ->method( 'remove', [
                                               'id' => $station->id,
                                           ] ),
                                 ] );
              } ),
        ];
    }
}
