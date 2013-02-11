var Listing = (function(){
	return {
		_Initialize: function(){

		},
		Vote: function(value, ideaId){
			$.ajax({
					type: "POST",
					url: "/services/vote_service.php",
					data: { action:"vote", value: value, ideaId: ideaId }
				}).done(function( data ) {
					var obj = $.parseJSON(data);
					
					if (obj.result == true)
					{
						$("#btn-up-" + ideaId).removeClass("btn-success").prop("href", "javascript:Listing.Vote(1, " + ideaId + ");").children("i").removeClass("icon-white");
						$("#btn-down-" + ideaId).removeClass("btn-danger").prop("href", "javascript:Listing.Vote(-1, " + ideaId + ");").children("i").removeClass("icon-white");
						
						switch(value)
						{
							case 1:
								$("#btn-up-" + ideaId).addClass("btn-success").prop("href", "javascript:Listing.Vote(0, " + ideaId + ");").children("i").addClass("icon-white");
								break;
							case -1:
								$("#btn-down-" + ideaId).addClass("btn-danger").prop("href", "javascript:Listing.Vote(0, " + ideaId + ");").children("i").addClass("icon-white");
								break;
						}
					}else
					{
						var alert = '<div class="alert alert-block alert-error vote-error">\
									<button type="button" class="close" data-dismiss="alert">×</button>\
  									<h4>Error!</h4>\
									  There has been an error while trying to submit your vote. If you continue to receive this message, please inform the Administrator. \
								 </div>';

						$("#idea-" + ideaId).after(alert);
					}	
				});
		},
		Delete: function(ideaId){
			$.ajax({
					type: "POST",
					url: "/services/vote_service.php",
					data: { action: "delete", ideaId: ideaId }
				}).done(function( data ) {
					var obj = $.parseJSON(data);
					if (obj.result == true)
					{
						var idea = $("#idea-" + ideaId)
						idea.next("hr").fadeOut(200, function(){this.remove()});
						idea.fadeOut(200, function(){this.remove()});
					}else
					{
						var alert = '<div class="alert alert-block alert-error vote-error">\
									<button type="button" class="close" data-dismiss="alert">×</button>\
  									<h4>Error!</h4>\
									  There has been an error while trying to delete your Idea. If you continue to receive this message, please inform the Administrator. \
								 </div>';

						$("#idea-" + ideaId).after(alert);
					}
				});
		}
	};
}());
Listing._Initialize();