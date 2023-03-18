@extends('template')

@section('main')
<main role="main" id="site-content" class="margin-top-85" style="padding-top:100px;padding-bottom:100px;">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>
                    <strong>
                        <a href="{{ url('/') }}">TravelOBug.pk</a>
                    </strong>
                </h1>
                <p class="mt-15 mb-5">
                    <strong>Email:</strong> contact@travelobug.pk<br />
                    <strong>Phone:</strong> 03267555818<br />
                    <strong>Address:</strong> Shop/H no. 6, Shahi Road, Press Market, Rahim Yar Khan
                </p>
            </div>
            <div class="col-md-6">
                <div class="px-2">
                    @include('home.contact_form')
                </div>
            </div>
        </div>

    </div>
    <br>
</main>
@stop

<style>
    img {width:100%;height:auto;}
</style>
