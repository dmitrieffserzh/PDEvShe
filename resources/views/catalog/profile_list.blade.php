@extends('app')

@section('title', $page->meta->title ?? '')
@section('description', $page->meta->description ?? '')

@section('breadcrumbs', Diglactic\Breadcrumbs\Breadcrumbs::render('catalog.'.Helpers::getGirlSectionUrlValue($section_id), $title))
@section('h1', $heading ?? 'Каталог девушек')

@section('content')
    @include('components.filter')
    <div class="profiles-list">
    @foreach($profiles as $item)
        @include('components.profiles.item_list', ['item' => $item])
    @endforeach
    </div>
    {{ $profiles->links('components.button-more') }}


    @if( $page->tile ||  $page->content)
        <div class="page-content">
            {!! $page->content !!}
        </div>
    @endif
@endsection
