@extends('layout.main')

@section('title', 'Question > Create')

@section('content')
<form method="post" action="{{ action('QuestionController@store') }}">
	<h1>Create Question</h1>
	<label>Description</label><br>
	<textarea name="description" required></textarea><br>

	<div class="options">
		

	</div>
	<span role="alert" data-for="options[]" class="k-widget k-tooltip k-tooltip-validation k-invalid-msg"></span>

	<br>
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<a href="{{ action('QuestionController@index') }}" class="k-button">Cancel</a>
	<button class="k-button k-primary">Create</button>
</form>


<!-- Template for MCQ Single Answer -->
<div id="mcq-sa-option-template" class="mcq-sa-option">
	<input type="radio">
	<textarea></textarea>
	<button class="add-btn k-button">+</button>
	<button class="del-btn k-button">-</button>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
var Question = {};
Question.validator = null;

Question.init = function() {
	var ref = this;
	ref.validator = $('form').kendoValidator().data('kendoValidator');
	ref.initMCQSingleAnswerOption();
}
Question.initMCQSingleAnswerOption = function() {
	var ref = this;

	$('#mcq-sa-option-template').hide();
	
	for(var i=0; i<3; i++) {
		MCQSingleAnswerOption();	
	}

	$('body').on('click', '.mcq-sa-option .add-btn', function() {
		MCQSingleAnswerOption($(this).closest('.mcq-sa-option'));		
	});

	$('body').on('click', '.mcq-sa-option .del-btn', function() {
		$(this).closest('.mcq-sa-option').remove();
		initClones();		
	});

	function initClones() {
		$('.mcq-sa-option').eq(0).find('.del-btn').hide();
		$('div.options .mcq-sa-option').find('input[type=radio]').each(function(i) {
			$(this).val(i);
		});
		$('div.options .mcq-sa-option').find('textarea').each(function(i) {
			if($(this).data('kendoEditor')==null) {
				$(this).kendoEditor();
			}
		});
	}

	function MCQSingleAnswerOption(target) {		
		var clone = $('#mcq-sa-option-template').clone();
		clone.removeAttr('id');
		clone.find('input[type=radio]').prop('name', 'correct_answer');
		clone.find('textarea').prop('required', true).prop('name', 'options[]');
		clone.show();		
		if(target==null) {
			$('div.options').append(clone);
		} else {
			target.after(clone);
		}		
		initClones();
	}
}

$(function() {
	Question.init();

	
	$('textarea[name=description]').kendoEditor();
});
</script>
@endsection