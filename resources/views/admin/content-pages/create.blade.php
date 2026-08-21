@extends('layouts.admin')

@section('title', 'Create page')
@section('eyebrow', 'Content / new multilingual page')

@section('content')
    <form method="POST" action="{{ route('admin.content-pages.store') }}">
        @csrf
        @include('admin.content-pages.form', ['submitLabel' => 'Create page'])
    </form>
@endsection
