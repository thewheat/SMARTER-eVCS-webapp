$(document).ready(function(){
	if($("#CategoryText").val() == "")	
	{
		$("#CategoryName").keyup(function(e){
			$("#CategoryText").val($(this).val());
			//$("#CategoryImage").val($(this).val() + ".jpg");
			//$("#CategoryVoice").val($(this).val());
		});
	}
});
