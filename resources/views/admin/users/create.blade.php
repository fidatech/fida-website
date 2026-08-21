@extends('layouts.admin')
@section('title', 'Add team member')
@section('eyebrow', 'Control / secure administrator')
@section('content')
    <form method="POST" action="{{ route('admin.users.store') }}">@csrf @include('admin.users.form', ['submitLabel' => 'Create account'])</form>
@endsection
