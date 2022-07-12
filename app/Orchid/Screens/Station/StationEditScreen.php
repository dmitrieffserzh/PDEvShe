<?php

namespace App\Orchid\Screens\Station;

use App\Models\Post;
use App\Models\Station;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class StationEditScreen extends Screen {

	public $station;

	public function query( Station $station ): iterable {
		return [
			'station' => $station
		];
	}


	public function name(): ?string {
		return $this->station->exists ? 'Редактирование станции' : 'Создание станции';
	}


	public function commandBar(): iterable {
		return [
			Button::make( __( 'Remove' ) )
			      ->icon( 'trash' )
			      ->confirm( __( 'Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.' ) )
			      ->method( 'remove' )
			      ->canSee( $this->station->exists )
			      ->style( 'color: #df0031;' ),
			Button::make( 'Отменить' )
			      ->icon( 'close' )
			      ->method( 'cancel' ),
			Button::make( 'Сохранить' )
			      ->icon( 'check' )
			      ->method( 'update' )
			      ->canSee( $this->station->exists )
			      ->class( 'float-end btn btn-' . Color::PRIMARY() ),
			Button::make( __( 'Save' ) )
			      ->icon( 'check' )
			      ->method( 'create' )
			      ->canSee( ! $this->station->exists )
			      ->class( 'float-end btn btn-' . Color::PRIMARY() ),
		];
	}


	public function layout(): iterable {
		return [
			Layout::columns( [
				Layout::rows( [
					Input::make( 'station.name' )
					     ->title( 'Название станции' )
					     ->placeholder( 'Введите название станции' )
					     ->style( 'width: 100%;' )
					     ->required(),
					Input::make( 'station.slug' )
					     ->title( 'URL' )
					     ->placeholder( 'Введите URL страницы' )
					     ->style( 'width: 100%;' )
					     ->required(),
					Input::make( 'station.title' )
					     ->title( 'Заголовок описания на странице' )
					     ->placeholder( 'Введите заголовок статьи' )
					     ->style( 'width: 100%;' ),
					Quill::make( 'station.content' )
					     ->title( 'Содержимое статьи' )
					     ->placeholder( 'Введите содержимое статьи' ),


					Input::make( 'station.meta.title' )
					     ->title( 'Meta-title' )
					     ->placeholder( '' )
					     ->style( 'width: 100%;' ),
					TextArea::make( 'station.meta.description' )
					        ->title( 'Meta-description' )
					        ->placeholder( '' ),


					Group::make( [
						Button::make( 'Отменить' )
						      ->method( 'cancel' )
						      ->icon( 'close' )
						      ->class( 'float-start btn btn-' . Color::SECONDARY() ),
						Button::make( 'Сохранить' )
						      ->method( 'update' )
						      ->icon( 'check' )
						      ->canSee( $this->station->exists )
						      ->class( 'float-end btn btn-' . Color::PRIMARY() ),
						Button::make( 'Сохранить' )
						      ->method( 'create' )
						      ->icon( 'check' )
						      ->canSee( ! $this->station->exists )
						      ->class( 'float-end btn btn-' . Color::PRIMARY() ),
					] )
				] )
			] )
		];
	}

	public function create( Request $request ) {
		$station = Station::create( $request->station );
		$station->meta()->create( $request->station['meta'] );
		if ( $station ) {

			Toast::success( 'Станция успешно сохранена' );

			return redirect()->route( 'platform.stations' );
		}
	}

	public function update( Station $station, Request $request ) {
		$station->updateOrFail( $request->station );
		if ( $station->meta()->exists() ) {
			$station->meta()->update( $request->station['meta'] );
		} else {
			$station->meta()->create( $request->station['meta'] );
		}

		Toast::success( 'Стнция успешно обновлена' );

		return redirect()->route( 'platform.stations' );
	}

	public function remove( Station $station ) {
		$station->delete();

		Toast::info( __( 'User was removed' ) );

		return redirect()->route( 'platform.stations' );
	}

	public function cancel() {
		return redirect()->route( 'platform.stations' );
	}
}
