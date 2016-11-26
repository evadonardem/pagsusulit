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

	

</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(function() {	
	var viewModel = kendo.observable({
		
	});
	kendo.bind($('#view'), viewModel);

	

});
</script>
@endsection