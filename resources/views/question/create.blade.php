@extends('layout.main')

@section('title', 'Question > Create')

@section('content')
<form method="post" action="{{ action('QuestionController@store') }}">
	<h1><i class="fa fa-lg fa-file"></i> Create Question</h1>
	
	<div class="row">
		<div class="col-md-4 col-sm-12">

			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-lg fa-cog"></i> Settings
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<input type="checkbox" id="randomOptions" name="settings[]" class="k-checkbox" value="randomOptions">
							<label for="randomOptions" class="k-checkbox-label">Random Options</label>
						</div>
						<div class="col-md-6 col-sm-6">
							<input type="checkbox" id="multipleAnswers" name="settings[]" class="k-checkbox" value="multipleAnswers">
							<label for="multipleAnswers" class="k-checkbox-label" data-bind="{ events: { click: onClickMultipleAnswers } }">Multiple Answers</label>
						</div>
					</div>
				</div>
			</div>										
		</div>
		<div class="col-md-8 col-sm-12">
			<label>Description</label><br>
			<textarea name="description" required></textarea><br>

			<div class="options">
			</div>
			<span role="alert" data-for="options[]" class="k-widget k-tooltip k-tooltip-validation k-invalid-msg"></span>
		</div>		
	</div>
		
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="saveType" value="finalized">
			<a href="{{ action('QuestionController@index') }}" class="k-button pull-right">Cancel</a> 
			<button type="button" class="k-button pull-right" data-bind="events: { click: onClickSaveAsDraft }">Save as Draft</button>
			<button class="k-button k-primary pull-right">Save and Finalize</button> 
		</div>
	</div>	
</form>


<!-- Template for MCQ Single Answer -->
<div id="mcq-sa-option-template" class="mcq-sa-option">
	<input type="radio">
	<label>Correct Answer</label>
	<textarea></textarea><br>
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<button class="del-btn k-button pull-right"><i class="fa fa-lg fa-minus-circle"></i></button>
			<button class="add-btn k-button pull-right"><i class="fa fa-lg fa-plus-circle"></i></button>
		</div>
	</div>			
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
	ref.initViewModel();

	ref.validator.hideMessages();
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
		var type = $('#multipleAnswers').prop('checked') ? 'checkbox' : 'radio';
		clone.removeAttr('id');
		clone.find('input[type=radio]').prop('type', type);
		clone.find('input[type=radio]').prop('name', 'correct_answer[]');
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
Question.initViewModel = function() {
	var viewModel = new kendo.observable({
		onClickMultipleAnswers: function(e) {
			var flag = !$('#multipleAnswers').prop('checked');
			if(flag) {
				$('.options .mcq-sa-option').each(function() {					
					$(this).find('input[type="radio"]').prop('type', 'checkbox');
				});
			} else {
				$('.options .mcq-sa-option').each(function() {					
					$(this).find('input[type="checkbox"]').prop('type', 'radio');
				});
			}
		},
		onClickSaveAsDraft: function(e) {
			if(Question.validator.validate()) {
				$('input[name=saveType]').val('draft');
				$('form')[0].submit();
			}			
		}
	});

	kendo.bind($('body'), viewModel);
	return viewModel;
}

$(function() {
	Question.init();
	$('textarea[name=description]').kendoEditor();
});
</script>
@endsection