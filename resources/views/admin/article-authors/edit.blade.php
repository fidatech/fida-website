@extends('layouts.admin')
@section('title', 'Edit insight author')
@section('content')<form method="POST" action="{{ route('admin.article-authors.update', $articleAuthor) }}">@csrf @method('PUT') @include('admin.article-authors.form', ['submitLabel' => 'Save author'])</form>@endsection
