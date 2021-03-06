@extends('app')

@section('title', $station->meta->title ?? '')
@section('description', $station->meta->description ?? '')

@section('breadcrumbs', Diglactic\Breadcrumbs\Breadcrumbs::render('search'))
@section('h1', $heading ?? 'Каталог девушек')

@section('content')
    <div class="profiles-list">
        @if($items)
            @foreach($items as $item)
                @include('components.profiles.item_list', ['item' => $item])
            @endforeach
        @else
            <h4 style="padding: 0 .5rem;">По вашему запросу ничего не найдено :(</h4>
        @endif
    </div>

    @if( isset($station->tile) ||  isset($station->content))
    <div class="page-content">
       <h2>{{$station->title}}</h2>
        {!! $station->content !!}
    </div>
    @endif
@endsection
