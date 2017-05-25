@extends('layout.main')

@section('title', 'Question')

@section('content')
<div id="view">
	<h1>Question</h1>
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<a href="{{ action('QuestionController@create') }}" class="k-button k-primary pull-right">Add New Question</a>
		</div>
	</div>

	<div data-template="questions-template" data-bind="source: questions"></div>
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
			pageSize: 10
		}),
		deleteQuestion: function(e) {
			var ref = this;
			var deleteURL = $(e.target).closest('a').prop('href');
			$.post(deleteURL, { _method: 'delete', _token: $('input[name=_token]').val() }, function(r) {
				ref.questions.read();
			});
			e.preventDefault();
			return false;
		},
		correctAnswer: function(e) {
			return (e.is_correct>0) ? '<i class="fa fa-lg fa-check"></i>' : '<i class="fa fa-lg fa-close"></i>';
		}
	});
	kendo.bind($('#view'), viewModel);

	$('#pager').kendoPager();
});
</script>

<script id="questions-template" type="text/x-kendo-template">
	<div class="row">
		<div class="col-md-1 col-sm-1">
			<p>\#<span data-bind="text: id"></span></p>
			#if(is_finalized){#
			<span>Finalized</span><br>
			#} else {#
			<span>Saved as Draft</span><br>
			<a data-bind="attr: { href: editURL }"><i class="fa fa-lg fa-edit"></i></a>
			#}#
			<a data-bind="attr: { href: deleteURL }, events: { click: deleteQuestion }"><i class="fa fa-lg fa-trash"></i></a>
		</div>
		<div class="col-md-9 col-sm-9">
			<div data-bind="html: description"></div>
			<div data-template="options-template" data-bind="source: options"></div>
		</div>
	</div>
</script>

<script id="options-template" type="text/x-kendo-template">
	<div class="row">
		<div class="col-md-1 col-sm-1">
			<span data-bind="html: correctAnswer"></span>
		</div>
		<div class="col-md-1 col-sm-1">
			<span data-bind="text: id"></span>
		</div>
		<div class="col-md-10 col-sm-10">
			<div data-bind="html: description"></div>
		</div>
	</div>
</script>
@endsection
