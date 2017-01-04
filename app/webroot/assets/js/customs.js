var SUCCESS = '<i class="glyphicon glyphicon-ok" style="color: #36a9e1;"></i>&nbsp;&nbsp;成功';
var ERROR = '<i class="fa fa-exclamation-triangle" style="color: red;"></i>&nbsp;&nbsp;エラー';
$(document).ready(function() {
	$( document ).ajaxError(function( event, jqxhr, settings, thrownError ) {
	    if (jqxhr.status == 403) {
	    	window.location = 'auth/login';
	    } else {
	    	Common.notification(ERROR, 'Error while process data !!!');
	    }
	});
});
