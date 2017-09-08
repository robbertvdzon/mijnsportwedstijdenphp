
function checkPasswd() {
	var passwd = $('#passwd').val();
	if (passwd!="DaX"){
		alert("Geen toegang");
		return false;
	}
	return true;

}


function saveMaillist() {
	if (!checkPasswd()) return;
	var text = $('textarea#maillistText').val();
	$.ajax({
	   url: 'savemaillist.php',
	   type: 'POST',
	   data: 'data='+JSON.stringify(text),   

	   success: function (response) {
	     alert(response);
	   }
	});       
}



function saveMergeFile() {
	if (!checkPasswd()) return;
	var text = $('textarea#mergeText').val();

	text = text.replace(/\u20ac/g, '&euro;')
	text = encodeURIComponent(text);
	$.ajax({
	   url: 'savemerge.php',
	   type: 'POST',   
 	   data: {
                data: text
           },
           dataType: "JSON",	   
	   success: function (response) {
	     alert(response);
	   },
	   error: function (response) {
	     alert(response.responseText);
	   }
	   
	});       
}

function sendTestEmail() {
	if (!checkPasswd()) return;
	var email = $('#testEmail').val();
	var subject = $('#subject').val();
	$.ajax({
	   url: 'sendtestmail.php',
	   type: 'POST',
	   data: 'email='+JSON.stringify(email)+'&subject='+JSON.stringify(subject),  

	   success: function (response) {
	     alert(response);
	   }
	});       
}



function sendBulk() {
	if (!checkPasswd()) return;
	var subject = $('#subject').val();
	$.ajax({
	   url: 'sendbulkmail.php',
	   type: 'POST',
	   data: 'subject='+JSON.stringify(subject),  
	   success: function (response) {
	     alert(response);
	   }
	});       
}
