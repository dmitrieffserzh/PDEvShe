<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\Models\Profile;
use App\Models\Testimonial;
use App\Orchid\Layouts\Girl\GirlListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {

        $allProfilesCount = Profile::all()->count();
        $profiles = Profile::where('active', 1)->limit(15)->get();
        $activeProfile = Profile::where('active', 1)->get()->count();
        $allTestimonials = Testimonial::all()->count();
        return [
            'allProfilesCount' => $allProfilesCount,
            'profile' => $profiles,
            'activeProfiles' => $activeProfile,
            'allTestimonials' => $allTestimonials
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Панель управления';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Добро пожаловать в панель управления сайтом INTIMDOSUG.PW';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Перейти на сайт')
                ->href('/')
                ->icon('globe-alt'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [

            Layout::columns([
                Layout::view('platform.count-block'),
                Layout::view('platform.active-block'),
                Layout::view('platform.testimonials-block'),
            ]),

            Layout::rows([

            ])->title('dsdsds'),

            GirlListLayout::class,



            Layout::view('platform::partials.welcome'),
        ];
    }
}
