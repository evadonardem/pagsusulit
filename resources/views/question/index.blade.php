@extends('layout.main')

@section('title', 'Question')

@section('content')
<div id="view">
	<h1>Question</h1>
	<div data-template="questions-template" data-bind="source: questions"></div>
	<a href="{{ action('QuestionController@create') }}" class="k-button k-primary">Add New Question</a>
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div id="pager" data-bind="source: questions"></div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
$(function() {	
	var viewModel = kendo.observable({
		questions: new kendo.data.DataSource({
			transport: {
				read: {
					url: "{{ action('QuestionController@index') }}",
					dataType: 'json'
				}
			},
			pageSize: 2
		}),
		deleteQuestion: function(e) {
			var ref = this;
			e.preventDefault();
			var deleteURL = e.target.href;
			$.post(deleteURL, { _method: 'delete', _token: $('input[name=_token]').val() }, function(r) {
				ref.questions.read();
			});
			return false;
		}
	});
	kendo.bind($('#view'), viewModel);

	$('#pager').kendoPager();
});
</script>

<script id="questions-template" type="text/x-kendo-template">
	<div>
		<p data-bind="text: id"></p>
		<div data-bind="html: description"></div>
		<div data-template="options-template" data-bind="source: options"></div>
		<p><a data-bind="attr: { href: deleteURL }, click: deleteQuestion">Delete</a></p>
	</div>	
</script>

<script id="options-template" type="text/x-kendo-template">
	<div>		
		<div data-bind="html: description"></div>
	</div>
</script>
@endsection