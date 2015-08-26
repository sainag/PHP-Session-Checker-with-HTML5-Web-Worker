//var sessionTimerRefresh='';
var sessionLifeTime=1440;
function sessionTimer(){
  sessionLifeTime--;
  postMessage(sessionLifeTime);
  setTimeout("sessionTimer()",1000);
}
sessionTimer();