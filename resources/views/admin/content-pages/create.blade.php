@extends('layouts.admin')

@php($typeDefinition = config('website.content_types.'.$contentPage->type, config('website.content_types.page')))
@section('title', 'Create '.$typeDefinition['singular'])
@section('eyebrow', 'Content / new multilingual '.Str::lower($typeDefinition['singular']))

@section('content')
    <form method="POST" action="{{ route('admin.content-pages.store') }}">
        @csrf
        @include('admin.content-pages.form', ['submitLabel' => 'Create '.$typeDefinition['singular']])
    </form>
@endsection
