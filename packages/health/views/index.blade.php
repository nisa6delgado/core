<!DOCTYPE html>
<html lang="{{ config('language') }}">

<head>

<meta charset="{{ config('charset') }}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Nisa Delgado">
<meta name="theme-color" content="#212529">

<title>{{ config('application_name') }}</title>

<link rel="icon" href="{{ asset('img/favicon.svg') }}">

<link rel="stylesheet" href="{{ node('bootstrap/dist/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ node('@fortawesome/fontawesome-free/css/all.css') }}">

<style>
    body {
        background-color: silver;
    }
</style>

</head>

<body>
    <div class="mx-auto">
    	<header>
    		<h1>
    			Health 
    			<i class="fa-regular fa-wave-pulse"></i>
    		</h1>
    	</header>

    	<div class="flex">
    		@foreach($items as $item)
    			<div class="w-1/4"></div>
    		@endforeach
    	</div>
    </div>
</body>

</html>
