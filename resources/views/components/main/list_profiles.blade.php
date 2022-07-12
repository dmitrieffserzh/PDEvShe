<section class="section">
    <div class="section__container">
        @if(isset($h1))
            <h1 class="section__title">{{ $title }}</h1>
        @else
            <h2 class="section__title">{{ $title }}</h2>
        @endif
        <div class="profiles-list">
        @foreach($items as $item)
            @include('components.profiles.item_list', ['item' => $item])
        @endforeach
        </div>
        @if($link)
        <div class="view-all">
            <a href="{{ $link }}" class="button button--view-all">Смотреть все</a>
        </div>
        @endif
    </div>
</section>
