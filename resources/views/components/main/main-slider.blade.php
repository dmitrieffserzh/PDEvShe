<div class="main-slider swiper">
    <div class="swiper-wrapper">
        @foreach($slides as $slide)
            <div class="swiper-slide main-slider__slide" style="background-image: url({{ $slide->image }})">
                <div class="main-slider__title">
                    {{ $slide->title }}
                </div>
            </div>
        @endforeach
    </div>
</div>
