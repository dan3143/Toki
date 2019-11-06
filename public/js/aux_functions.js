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
  remaining = Math.round((secondDate.getTime() - today.getTime())/oneDay);
  var element = document.getElementById('remaining-' + id);
  message = "";
  if (remaining < 0){
    element.classList.add("text-danger");
    remaining = Math.abs(remaining);
    message = "hace ";
  }
  message = message + remaining+" día"+(remaining==1 ? '' : 's');
  element.innerHTML = message;
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

function disableSubmit() {
  var allowSubmit = true;
  frm = document.getElementById('form');
  frm.onsubmit = function () {
  if (allowSubmit)
      allowSubmit = false;
  else 
      return false;
  }
};

function deleteCard(id){
    if (confirm("¿De verdad quieres eliminar esta actividad?")){
      $.ajax({
          url: id+"/delete",
          method:"DELETE",
          headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
          success: function(result){
              $("#card-"+id).remove();
          },
          error: function(xhr){
              console.log("Ocurrió un error:  " + xhr.status);
          }
      });
  }        
}

function deleteSubject(id){
  $("#delete-"+id).click(function(){
    if (confirm("¿De verdad quieres eliminar esta asignatura?")){
        row = $("#row-"+id+" td");
        $.ajax({
            url: "subjects/"+id+"/delete",
            method:"DELETE",
            headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
            success: function(result){
                row.hide();
                row.remove();
            },
            error: function(xhr){
                console.log("Ocurrió un error:  " + xhr);
            }
        });
    }
  });
}

function increment(id){
  absences = $("#absenceNumber-"+id);
  value = parseInt(absences.text(), 10);
  $.ajax({
      url: "subjects/"+id+"/increment",
      method: "put",
      headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
      success: function(result){
          value++;
          absences.text(value);
      },
      error: function(xhr){
          console.log("Ocurrió un error:  " + xhr.status);
      }
  });
}

function decrement(id){
  absences = $("#absenceNumber-"+id);
  value = parseInt(absences.text(), 10);
  $.ajax({
      url: "subjects/"+id+"/increment",
      method: "put",
      headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
      success: function(result){
          if (value > 0){
              value--;
          }
          absences.text(value);
      },
      error: function(xhr){
          console.log("Ocurrió un error:  " + xhr.status);
      }
  });
}

function deleteDeadline(id){
    if (confirm("¿De verdad quieres eliminar esta tarea?")){
        row = $("#row-"+id+" td");
        $.ajax({
            url: "deadlines/"+id+"/delete",
            method:"DELETE",
            headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
            success: function(result){
                row.hide();
                row.remove();
            },
            error: function(xhr){
                console.log("Ocurrió un error:  " + xhr);
            }
        });
    }
}