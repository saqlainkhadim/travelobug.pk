<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Metas For sharing property in social media -->
		<meta property="og:url"                content="{{ isset($shareLink) ? $shareLink : url('/') }}" />
		<meta property="og:type"               content="article" />
		<meta property="og:title"              content="{{ $title ?? Helpers::meta((!isset($exception)) ? Route::current()->uri() : '', 'title') }}" />
		<meta property="og:description"        content="{{ isset($result->property_description->summary) ? $result->property_description->summary : ( Helpers::meta((!isset($exception)) ? Route::current()->uri() : '', 'description'))  }}" />
		<meta property="og:image"              content="{{ (isset($property_id) && !empty($property_id && isset($property_photos[0]->photo) )) ? url(env('FILE_PATH').'/images/property/'.$property_id.'/'.$property_photos[0]->photo) : (defined("BANNER_URL") ? BANNER_URL : '') }}" />


		@if (!empty($favicon))
			<link rel="shortcut icon" href="{{ $favicon }}">
		@endif

		<title>{{ $title ?? Helpers::meta((!isset($exception)) ? Route::current()->uri(): '', 'title') }} {{ $additional_title ?? '' }} </title>
        <!-- SEO Tags -->
        <meta name="description" content="{{ isset($result->property_description->summary) ? $result->property_description->summary : ( Helpers::meta((!isset($exception)) ? Route::current()->uri() : '', 'description'))  }}"/>
        <meta name="keywords" content="{{ isset($result->property_description->summary) ? $result->property_description->summary : ( Helpers::meta((!isset($exception)) ? Route::current()->uri() : '', 'keywords'))  }}">
        <meta name="author" content="TravelObug">

        <meta name="mobile-web-app-capable" content="yes">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- CSS  new version start-->
		@stack('css')
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="{{asset(env('FILE_PATH').'/css/vendors/bootstrap/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset(env('FILE_PATH').'/css/vendors/fontawesome/css/all.min.css')}}">
		<link rel="stylesheet" href="{{asset(env('FILE_PATH').'/css/style.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"/>
		<!--CSS new version end-->
	</head>
<body>
