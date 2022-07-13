<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listener\UploadListener;
use Orchid\Platform\Events\UploadFileEvent;

class EventServiceProvider extends ServiceProvider {

	protected $listen = [
		Registered::class      => [
			SendEmailVerificationNotification::class,
		],
//		UploadFileEvent::class => [
//			UploadListener::class,
//		],
	];

	public function boot() {
		//
	}

	public function shouldDiscoverEvents() {
		return false;
	}
}
