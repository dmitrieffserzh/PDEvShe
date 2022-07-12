@extends('app')

@section('title', $page->meta->title ?? '')
@section('description', $page->meta->description ?? '')

@section('breadcrumbs', Diglactic\Breadcrumbs\Breadcrumbs::render('pages', $page))
@section('h1', $heading ?? 'Личные данные')

@section('content')
    <div class="page-content">
    {!! $page->content !!}
    </div>
@endsection
