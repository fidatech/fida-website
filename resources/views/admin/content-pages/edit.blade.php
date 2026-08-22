@extends('layouts.admin')

@section('title', 'Edit '.(config('website.content_types.'.$contentPage->type.'.singular') ?? 'content'))
@section('eyebrow', 'Content / '.$contentPage->slug)

@section('content')
    <form method="POST" action="{{ route('admin.content-pages.update', $contentPage) }}">
        @csrf
        @method('PUT')
        @include('admin.content-pages.form', ['submitLabel' => 'Save changes'])
    </form>
@endsection
