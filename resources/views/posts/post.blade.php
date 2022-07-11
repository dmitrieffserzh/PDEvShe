@extends('app')

@section('title', $post->meta->title ?? '')
@section('description', $post->meta->description ?? '')

@section('breadcrumbs', Diglactic\Breadcrumbs\Breadcrumbs::render('posts.show', $post))
@section('h1', $heading ?? 'Личные данные')

@section('content')
    {!! $post->content !!}
@endsection
