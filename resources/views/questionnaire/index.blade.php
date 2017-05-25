@extends('layout.main')

@section('title', 'Questionnaire')

@section('content')
<div id="view">
	<h1>Questionnaire</h1>


	<div class="row">
		<div class="col-md-12 col-sm-12">
			<a href="{{ action('QuestionnaireController@create') }}" class="k-button k-primary">Create Questionnaire</a>
		</div>
	</div>

	<div data-template="questionnaires-template" data-bind="source: questionnaires"></div>
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div id="pager" data-bind="source: questionnaires"></div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(function() {
	var viewModel = kendo.observable({
		questionnaires: new kendo.data.DataSource({
			transport: {
				read: {
					url: "{{ action('QuestionnaireController@index') }}",
					dataType: 'json'
				}
			},
			pageSize: 10
		}),
		deleteQuestionnaire: function(e) {
			var ref = this;
			var deleteURL = $(e.target).closest('a').prop('href');
			$.post(deleteURL, { _method: 'delete', _token: $('input[name=_token]').val() }, function(r) {
				ref.questionnaires.read();
			});
			e.preventDefault();
			return false;
		}
	});
	kendo.bind($('#view'), viewModel);

	$('#pager').kendoPager();

});
</script>

<script id="questionnaires-template" type="text/x-kendo-template">
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div>
				\#<span data-bind="text: id"></span>
				<a data-bind="attr: { href: deleteURL }, events: { click: deleteQuestionnaire }"><i class="fa fa-lg fa-trash"></i></a>
			</div>
			<div data-bind="html: description"></div>
		</div>
	</div>
</script>
@endsection
