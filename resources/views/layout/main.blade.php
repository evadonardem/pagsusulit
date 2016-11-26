<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<script type="text/javascript" src="{{ asset('js/jquery-3.1.0.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/jquery-migrate-3.0.0.min.js') }}"></script>
	
	<!-- Bootstrap -->
	<script type="text/javascript" src="{{ asset('plugins/bootstrap-3.3.7-dist/js/bootstrap.min.js') }}"></script>
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}">

	<!-- Font Awesome -->
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/font-awesome-4.6.3/css/font-awesome.min.css') }}">
	
	<!-- Kendo UI - Core -->
	<script type="text/javascript" src="{{ asset('plugins/telerik.kendoui.core/js/kendo.all.min.js') }}"></script>
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/telerik.kendoui.core/styles/kendo.common.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/telerik.kendoui.core/styles/kendo.default.min.css') }}">
</head>
<body>
	<div class="container-fluid">
		@yield('content')
	</div>
	
	@yield('scripts')	
</body>
</html>