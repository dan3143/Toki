/* Set the width of the side navigation to 250px */
function openNav() {
  document.getElementById("sidenav").style.width = "250px";
}

/* Set the width of the side navigation to 0 */
function closeNav() {
  document.getElementById("sidenav").style.width = "0";
}

function remainingDays(to, id){
  var oneDay = 24*60*60*1000; //hours*minutes*seconds*milliseconds
  var today = new Date();
  var secondDate = new Date(to);
  remaining = Math.round(Math.abs(secondDate.getTime() - today.getTime())/oneDay);
  var element = document.getElementById('remaining-' + id);
  element.innerHTML = "("+remaining+" días)";
}

function minDate(){
  var d = new Date(),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;
    d = [year, month, day].join('-');
    picker = document.getElementById('input_date');
    picker.setAttribute('min', d);
    console.log(picker);
}