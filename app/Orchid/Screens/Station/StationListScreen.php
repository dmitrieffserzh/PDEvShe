<?php

namespace App\Orchid\Screens\Station;

use App\Models\Station;
use App\Orchid\Layouts\Station\StationListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class StationListScreen extends Screen {

    public function query(): iterable {
        return [
            'station' => Station::filters()->defaultSort( 'id', 'desc' )->paginate(),
        ];
    }

    public function name(): ?string {
        return 'Станции метро';
    }

    public function commandBar(): iterable {
        return [
            Link::make( __( 'Add' ) )
                ->icon( 'plus' )
                ->route( 'platform.stations.create' ),
        ];
    }

    public function layout(): iterable {
        return [
	        StationListLayout::class,
        ];
    }


    public function remove( Request $request ): void {
        Station::findOrFail( $request->get( 'id' ) )->delete();
        Toast::info( 'Станция успешно удалена' );
    }
}
