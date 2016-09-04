<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<script type="text/javascript" src="{{ asset('js/jquery-3.1.0.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/jquery-migrate-3.0.0.min.js') }}"></script>
	
	<!-- Kendo UI - Core -->
	<script type="text/javascript" src="{{ asset('plugins/telerik.kendoui.core/js/kendo.all.min.js') }}"></script>
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/telerik.kendoui.core/styles/kendo.common.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/telerik.kendoui.core/styles/kendo.default.min.css') }}">
</head>
<body>
	@yield('content')
	@yield('scripts')	
</body>
</html>