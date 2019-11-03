/* Set the width of the side navigation to 250px */
function openNav() {
  document.getElementById("sidenav").style.width = "250px";
}

/* Set the width of the side navigation to 0 */
function closeNav() {
  document.getElementById("sidenav").style.width = "0";
}

function remainingDays(to){
  var oneDay = 24*60*60*1000; //hours*minutes*seconds*milliseconds
  var today = new Date();
  var secondDate = new Date(to);
  remaining = Math.round(Math.abs(secondDate.getTime() - today.getTime())/oneDay);
  var element = document.getElementById('remaining');
  element.innerHTML = "("+remaining+" días)";
}