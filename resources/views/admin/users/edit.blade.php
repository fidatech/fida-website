@extends('layouts.admin')
@section('title', 'Edit team member')
@section('eyebrow', 'Control / '.$managedUser->email)
@section('content')
    <form method="POST" action="{{ route('admin.users.update', $managedUser) }}">@csrf @method('PUT') @include('admin.users.form', ['submitLabel' => 'Save access'])</form>
@endsection
