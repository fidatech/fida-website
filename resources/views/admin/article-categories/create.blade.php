@extends('layouts.admin')
@section('title', 'New insight category')
@section('content')<form method="POST" action="{{ route('admin.article-categories.store') }}">@csrf @include('admin.article-categories.form', ['submitLabel' => 'Create category'])</form>@endsection
