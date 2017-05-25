@extends('layout.main')

@section('title', 'Question > Create')

@section('content')
<div class="row">
	<div class="col-md-6 col-sm-12">
		<form method="post" action="{{ action('QuestionnaireController@store') }}">
			<h1><i class="fa fa-lg fa-file"></i> Create Questionnaire</h1>

			<label>Description</label>
			<input type="text" name="description" class="k-input k-textbox" >

			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<button type="submit" name="button">Create</button>
		</form>
	</div>
</div>
<div data-template="questions-template" data-bind="source: questions"></div>
@endsection

@section('scripts')
<script type="text/javascript">
var Questionnaire = {};
Questionnaire.viewModel = null;
Questionnaire.init = function() {
	var ref = this;
	Questionnaire.viewModel = ref.initViewModel();
}

Questionnaire.initViewModel = function() {
	var ref = this;
	var viewModel = new kendo.observable({
		questions: new kendo.data.DataSource({
			transport: {
				read: {
					url: "{{ url('api/get_available_questions') }}",
					dataType: 'json',
					data: {
						questions: [3],
						_token: $('input[name=_token]').val()
					},
					type: 'post'
				}
			}
		}),

		correctAnswer: function(e) {
			return (e.is_correct>0) ? '<i class="fa fa-lg fa-check"></i>' : '<i class="fa fa-lg fa-close"></i>';
		}
	});

	kendo.bind($('body'), viewModel);
	return viewModel;
}


$(function() {
	Questionnaire.init();
	$('textarea').kendoEditor().data('kendoEditor');
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
