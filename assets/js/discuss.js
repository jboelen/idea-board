var Discuss = (function(){
	return {
		_Initialize: function(){
		},
		ToggleReply: function(id){
			$("#comment-reply_" + id).toggle();
		},
		ToggleEdit: function(id){
			$("#comment-edit_" + id).toggle();
		}
	};
}());
Discuss._Initialize();