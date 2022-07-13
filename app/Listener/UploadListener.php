<?php

namespace App\Listener;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Orchid\Platform\Events\UploadFileEvent;

class UploadListener implements ShouldQueue {

	use InteractsWithQueue;

	public function handle( UploadFileEvent $event ) {


		//dd($event[0]->relativeUrl());

//		$mime       = $event['mime'];
//		$videoTypes = array( 'video/mp4', 'video/ogg', 'video/webm', 'video/mpeg' );
//
//		if ( array_search( $mime, $videoTypes ) !== false ) {
//
//		VideoThumbnail::createThumbnail(
//			$event->relativeUrl(),
//			public_path('files/thumbs/'),
//			'movie.jpg',
//			2,
//			320,
//			320
//		);
//			//$event->attachment
//			//$event->time
//		}
	}
}
