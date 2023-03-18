@extends('template')

@section('main')
<main role="main" id="site-content" class="margin-top-85" style="padding-top:100px;padding-bottom:100px;">
    <div class="container">
        {!! $content !!}
    </div>
    <br>
</main>
@stop

<style>
    img {
        width:100%;
        height: auto;
    }
</style>
