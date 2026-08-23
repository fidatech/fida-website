@extends('layouts.admin')
@section('title', 'Edit insight category')
@section('content')<form method="POST" action="{{ route('admin.article-categories.update', $articleCategory) }}">@csrf @method('PUT') @include('admin.article-categories.form', ['submitLabel' => 'Save category'])</form>@endsection
