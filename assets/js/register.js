	
var Register = (function(){
	var lastattempt="";
	return {
		_Initialize: function(){
			$(document).ready(function(){
				$(".keyinput").on('keyup', Register.GetInformation);
				Register.GetInformation();
				
				$('#form-register').validate({
					groups: {
						regKey: "inputKey1 inputKey2 inputKey3 inputKey4 inputKey5"
					},	
					rules: {
						inputPassword: {
					  		minlength: 4,
					  		required: true
						},
						inputEmail: {
					  		required: true,
					  		email: true
						},
						inputKey1:{
							required: true
						},
						inputKey2:{
							required: true
						},
						inputKey3:{
							required: true
						},
						inputKey4:{
							required: true
						},
						inputKey5:{
							required: true
						},
						
				  	},
				  	highlight: function(label) {
						$(label).closest('.control-group').addClass('error');
				  	},
				  	success: function(label){
				  		$(label).closest('.control-group').removeClass('error');
				  	},
				  	errorPlacement: function(error, element) {
						if (element.attr("name") == "inputKey1" 
							|| element.attr("name") == "inputKey2"
							|| element.attr("name") == "inputKey3"
							|| element.attr("name") == "inputKey4"
							|| element.attr("name") == "inputKey5" )
							error.insertAfter("#key5");
						else
							error.insertAfter(element);
					},
					messages: {
						inputKey1: {
							required: "Please enter a 25 character key."
						},
							inputKey2 :{
							required: "Please enter a 25 character key."
						},
						inputKey3: {
							required: "Please enter a 25 character key."
						},
						inputKey4: {
							required: "Please enter a 25 character key."
						},
						inputKey5: {
							required: "Please enter a 25 character key."
						}
					},		
				  	onsubmit: true
				  	
				});
			});
		},
		GetInformation : function(){
			var key = "{0}-{1}-{2}-{3}-{4}".format($("#key1").val(), $("#key2").val(), $("#key3").val(), $("#key4").val(), $("#key5").val());
			
			if (key.length == 29 && lastattempt != key)
			{
				lastattempt = key;
				$.ajax({
					type: "POST",
					url: "/services/account_service.php",
					data: { key: key }
				}).done(function( data ) {
					//alert(data);
					if (data.length != 0)
					{
						var obj = $.parseJSON(data);
						$("#inputEmail").val(obj.email);
						$("#inputFirstName").val(obj.firstname);
						$("#inputLastName").val(obj.lastname);
						$("#icon").empty().append('<img src="./assets/images/iconRight.png" style="height:30px;" />');
					}else
					{
						$("#icon").empty().append('<img src="./assets/images/iconWrong.png" style="height:30px;" />');
					}
				});
			}else if (key.length != 29)
			{
				//alert(key + " vs " + lastattempt);
				$("#icon").empty();
			}
		},
		PasteKey : function(){
			if ($("#key1").val().length == 29)
			{
				var key = $("#key1").val().split('-');
				$("#key1").val(key[0]);
				$("#key2").val(key[1]);
				$("#key3").val(key[2]);
				$("#key4").val(key[3]);
				$("#key5").val(key[4]);
			}
		}
	}
}());
Register._Initialize();
