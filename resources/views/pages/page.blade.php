@extends('app')

@section('title', $profile->meta->title ?? '')
@section('description', $profile->meta->description ?? '')

@section('breadcrumbs', Diglactic\Breadcrumbs\Breadcrumbs::render('pages', $page))
@section('h1', $heading ?? 'Личные данные')

@section('content')
    {!! $page->content !!}
@endsection
