<?
/**$_GET['function'] get the function name**/
function sessionChecker(){
  if (!isset($_SESSION['username'])){
	if(isset($_COOKIE['chocochip'])) { echo 1;}
	else echo 0;
  }
}
?>