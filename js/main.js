"use strict"

var urls = {
	pAddEdit : "/projectEditAdd",
	rAddEdit : "/requirementEditAdd",
	tdAddEdit : "/todoEditAdd",
	puAddEdit : "/userAdd",
	
	pDelete : "/projectDelete",
	rDelete : "/requirementDelete",
	tDelete : "/todoDelete",
	uDelete : "/userDelete",
	
	setGuiTheme : "/setGuiTheme"
};

$(document).ready(function(){
	
	$('#btnProjectAddEdit').bind('click', function(){
		tinyMCE.triggerSave();
		
		var formId = "#projectForm";
		var $elem = $( formId + " input[name=name]");
		
		if (!hasError($elem)){			
			$.post(
				urls.pAddEdit,
				$( formId ).serialize(),
				addEditResponse
			)
		}
	});
	
	$('#btnRequirementAddEdit').bind('click', function(){
		tinyMCE.triggerSave();
		
		var formId = "#requirementForm";
		var $elem = $( formId + " input[name=name]");
		
		if (!hasError($elem)){
			$.post(
				urls.rAddEdit,
				$( formId ).serialize(),
				addEditResponse
			)
		}
	});
	
	$('#btnTodoAddEdit').bind('click', function(){
		tinyMCE.triggerSave();
		
		var formId = "#todoForm";
		var $elem = $( formId + " input[name=name]");
		
		if (!hasError($elem)){
			$.post(
				urls.tdAddEdit,
				$( formId ).serialize(),
				addEditResponse
			)
		}
	});
	
	$('#btnProjUserAddEdit').bind('click', function(){
		
		var formId = "#projUserForm";
		var $elem = $( formId + " input[name=username]");
		
		if (!hasError($elem)){
			$.post(
				urls.puAddEdit,
				$( formId ).serialize(),
				addEditResponse
			)
		}
	});
	
	function hasError(elem){
		if (elem.val() === ''){
			elem.focus();
			elem.closest(".form-group").addClass('has-error');
			return true;
		}
		
		return false;
	}
	
	function addEditResponse(json){
		var d = $.parseJSON(json);
		
		if (d[0] == 'success'){
			location.reload();
			
		}else{
			alert(d[1]);
		}
	}
});
	
$(document).ready(function(){
	tinymce.init({selector:'textarea',height: 500});
});

function changeGuiTheme(event, theme){
	event.preventDefault(); 
	
	$("#guiTheme").attr('href', '//bootswatch.com/'+theme+'/bootstrap.min.css');
	
	$.post(
		urls.setGuiTheme,
		{'guiTheme':theme},
		successChange
	)
}
function successChange(data){
	//console.log(data);
	//console.log('success');
}
function populateProj(idPart){
	var formN = "#projectForm";
	
	$('.progress').removeClass('hide');
	$(formN).addClass('hide');
	
	$(formN + ' .subTitleAction').html('Edit').removeClass('label-danger').addClass('label-info');
	$(formN + ' input[name=name]').val($('#projectName'+idPart).attr('data'));
	$(formN + ' input[name=projectId]').val($('#projectId'+idPart).attr('data'));
	//$(formN + ' textarea[name=description]').val($('#description'+idPart).attr('data'));
	tinymce.get('description').setContent($('#description'+idPart).attr('data'));
	
	setTimeout(function(){
		$('.progress').addClass('hide');
		$(formN).removeClass('hide');
	}, 500);
}
function populateRequirement(idPart){
	var formN = "#requirementForm";
	
	$('.progress').removeClass('hide');
	$(formN).addClass('hide');
	
	$(formN + ' .subTitleAction').html('Edit').removeClass('label-danger').addClass('label-info');
	$(formN + ' input[name=name]').val($('#requirementName'+idPart).attr('data'));
	$(formN + ' input[name=projectId]').val($('#projectId'+idPart).attr('data'));
	$(formN + ' input[name=requireId]').val($('#requireId'+idPart).attr('data'));
	//$(formN + ' textarea[name=description]').val($('#description'+idPart).attr('data'));
	tinymce.get('description').setContent($('#description'+idPart).attr('data'));
	
	setTimeout(function(){
		$('.progress').addClass('hide');
		$(formN).removeClass('hide');
	}, 500);
}
function populateTodo(idPart){
	
	var formN = "#todoForm";
	
	$('.progress').removeClass('hide');
	$(formN).addClass('hide');
	
	$(formN + ' .subTitleAction').html('Edit').removeClass('label-danger').addClass('label-info');
	$(formN + ' input[name=name]').val($('#todoName'+idPart).attr('data'));
	$(formN + ' input[name=projectId]').val($('#projectId'+idPart).attr('data'));
	$(formN + ' input[name=toDoId]').val($('#toDoId'+idPart).attr('data'));
	$(formN + ' input[name=endDate]').val($('#endDate'+idPart).attr('data'));
	//$(formN + ' textarea[name=description]').val($('#description'+idPart).attr('data'));
	$(formN + ' option[value='+$('#priority'+idPart).attr('data')+']').prop('selected', true);
	$(formN + ' option[value='+$('#status'+idPart).attr('data')+']').prop('selected', true);
	tinymce.get('description').setContent($('#description'+idPart).attr('data'));
	
	setTimeout(function(){
		$('.progress').addClass('hide');
		$(formN).removeClass('hide');
	}, 500);
}
function reset2Add(formN){
	$('#'+formN+' .subTitleAction').html('Add New').removeClass('label-info').addClass('label-danger');
}
function deleteProj(id){
	if (confirm("Are you to delete this data permanently")){
		$.post(
			urls.pDelete,
			{'projectId':id},
			deleteResponse
		)
	}
}
function deleteRequirement(id){
	if (confirm("Are you sure to delete this data permanently")){
		$.post(
			urls.rDelete,
			{'requireId':id},
			deleteResponse
		)
	}
}
function deleteTodo(id){
	if (confirm("Are you sure to delete this data permanently")){
		$.post(
			urls.tDelete,
			{'toDoId':id},
			deleteResponse
		)
	}
}
function deleteProjUser(id){
	if (confirm("Are you sure to delete this data permanently")){
		$.post(
			urls.uDelete,
			{'projUserId':id},
			deleteResponse
		)
	}
}

function deleteResponse(json){
	var d = $.parseJSON(json);
	
	if (d[0] == 'success'){
		location.reload();
		
	}else{
		alert(d[1]);
	}
}