var Edit = (function(){
	var LengthValidator = function(container, min, max) {
		if ($(container).val().length == 0 && min > 0) {
			return false;
		}
		else if ($(container).val().length > max) {
			return false;
		}
		else if ($(container).val().length < min) {
			return false;
		}
		return true;
	};
	
	return {
		_Initialize: function(){
			$(document).ready(function(){
				$("#summary").charCount({
					allowed: 200,
					warning: 50,
					counterText: ''
				});
				
				$("#title").charCount({
					allowed: 50,
					warning: 10,
					counterText: ''
				});
				
				$("#form-edit-new").submit(function(){
					return Edit.Validate();
				});
		  	});
		},
		Validate: function() {
			var result = true;
			
			if (!LengthValidator("#title", 3, 50)){
				result = false;
				$("#title").closest('.control-group').addClass('error');
			} else
				$("#title").closest('.control-group').removeClass('error');
			
			if (!LengthValidator("#summary", 20, 200)){
				result = false;
				$("#summary").closest('.control-group').addClass('error');
			} else
				$("#summary").closest('.control-group').removeClass('error');
			
			return result;
		}
	};
}());
Edit._Initialize();