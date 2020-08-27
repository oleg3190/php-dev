@extends('layouts.app', ['page_title' => 'Welcome!'])

@section('html_header')
<!-- Additional header tags -->
@endsection

@section('main_content')
    <!-- Begin page content -->
    <div class="container">
        <div class="page-header">
            <h1>Сообщения от всех пользователей</h1>
        </div>
        <message-form :user="{{json_encode(Auth()->user()) ?: null}}"></message-form>
    </div>
@endsection