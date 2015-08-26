<script type="text/javascript">
  var sessionTimerRefresh='';
  var sessionLifeTime=1440;
  var sessionWorker;
  $(document).ready(function(e) {
	sessionTimerRun();	
  });
  $(document).click(function(e) {
	sessionChecker();
  });
  function sessionTimerRun(){
	if(typeof(Worker) !== "undefined") {
	  if(typeof(sessionWorker) == "undefined") {
	    sessionWorker = new Worker("sessionWorker.js");
	  }
	  sessionWorker.onmessage = function(event){
	    sessionLifeTime=event.data;
		if(sessionLifeTime==5){
		  /**Cookie checker**/	
		  var chocochip='<?= $_COOKIE['chocochip']?>';
		  if(chocochip!=''){
			/**Resetting the session**/
			sessionChecker();
		  }
		}
		else if(sessionLifeTime<=0){
		  /**Session Time out**/
		  sessionWorker.terminate();
		  alert("You Session has expired.\nPlease Log in again");
		  var uri='<? echo $_SERVER['REQUEST_URI']?>'.split('/');
		  var currentPage=(uri[uri.length-1]).replace('.php','');
		  window.location='login.php?referer='+currentPage;
		}
	  };
    }
    else {
	  sessionLifeTime--;
	  if(sessionLifeTime==5){
		/**Cookie checker**/	
		var chocochip='<?= $_COOKIE['chocochip']?>';
		if(chocochip!=''){
		  /**Resetting the session**/
		  sessionChecker();
		}
		else{
		  sessionTimerRefresh=setTimeout('sessionTimerRun()',1000);
		}
	  }
	  else if(sessionLifeTime<=0){
		/**Session Time out**/
		clearTimeout(sessionTimerRefresh);
		alert("You Session has expired.\nPlease Log in again");
		var uri='<? echo $_SERVER['REQUEST_URI']?>'.split('/');
		var currentPage=(uri[uri.length-1]).replace('.php','');
		window.location='login.php?referer='+currentPage;
	  }
	  else{
		sessionTimerRefresh=setTimeout('sessionTimerRun()',1000);
	  }
    }
  }
  function sessionChecker(){
	var sUrl="backend.php?function=sessionChecker";
	$.ajax({
	  url:sUrl,
	  success:function(data){
	    if(typeof(Worker) !== "undefined") { sessionWorker.terminate(); sessionWorker=undefined; }
	    else clearTimeout(sessionTimerRefresh);
	    /**Timer Reset**/
	    sessionLifeTime=1440;
	    sessionTimerRun();
	  }
	});
  }
</script>
