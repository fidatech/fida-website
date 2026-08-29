@extends('layouts.admin')
@section('title', 'New insight author')
@section('content')<form method="POST" action="{{ route('admin.article-authors.store') }}">@csrf @include('admin.article-authors.form', ['submitLabel' => 'Create author'])</form>@endsection
