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
    console.log(picker);
    picker.setAttribute('min', d);
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

function deleteActivity(id){
    if (confirm("¿De verdad quieres eliminar esta actividad?")){
      $.ajax({
          url: "/routine/"+id+"/delete",
          method:"DELETE",
          headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
          success: function(result){
              $("#card-"+id).remove();
          },
          error: function(xhr){
              console.log("Ocurrió un error:  " + xhr.responseText);
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
                console.log("Ocurrió un error:  " + xhr.textResponse);
            }
        });
    }
}

function deleteGrade(subjectId, gradeId, percentage){
    if (confirm("¿De verdad quieres eliminar esta nota?")){
        row = $("#row-"+gradeId+" td");;
        $.ajax({
            url: "/subjects/" + subjectId + "/grade/" + gradeId + "/delete",
            method:"DELETE",
            headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
            success: function(result){
                value = parseInt($('#defined').text(), 10);
                value -= percentage;
                $("#defined").text(value);
                row.hide();
                row.remove();
                if (value < 100){
                    $("#agregar_nota").removeAttr("hidden");
                    $("#input_percentage").attr("max", 100-value);
                }
                console.log(result);
                $("#current_grade").text(result);
            },
            error: function(xhr){
                console.log("Ocurrió un error:  " + xhr.responseText);
            }
        });
    }
}

function importActivity(id){
    $.ajax({
        url: "/routine/"+id+"/import",
        method:"POST",
        headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
        success: function(result){
            alert('Actividad importada');
        },
        error: function(xhr){
            console.log("Ocurrió un error:  " + xhr.responseText);
        }
    });
}

function importDeadline(id){
    $.ajax({
        url: "/deadlines/"+id+"/import",
        method:"POST",
        headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
        success: function(result){
            alert('Actividad importada');
        },
        error: function(xhr){
            console.log("Ocurrió un error:  " + xhr.responseText);
        }
    });
}

function setTimer(id, end_date){
    var countDownDate = new Date(end_date).getTime();
    var interval = setInterval(function(){
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        time = days + "d " + hours + "h";
        if (days == 0){
            time = hours + "h " + minutes + "m";
            if (hours == 0){
                time = minutes + "m " + seconds + "s"
                if (minutes == 0){
                    time = seconds + "s";
                }
            }   
        }
        text = document.getElementById("remaining-"+id);
        if (text == null){
            return;
        }
        text.innerHTML = time;
        if ((distance/(1000*60)).toFixed(2) == 15){
            console.log("Chale");
            sendNotification(id);
        }
        if (distance < 0){
            clearInterval(interval);
            text.innerHTML = "expirada";
        }
    }, 1000);
}

function sendNotification(deadline_id){
    console.log("Quedan 15 minutos");
    name_cell = document.getElementById("name-"+deadline_id);
    if (!Notification){
        console.log("Notifications not available");
        
    }else{
        if (Notification.permission !== 'granted'){
            Notification.requestPermission().then(function(result){
                console.log(result);
            });
        }
        if (Notification.permission === 'granted'){
            var notification = new Notification("Una de tus actividades está a punto de expirar",
            {
                body: name_cell.textContent + " expirará en 15 minutos",
                icon: "../images/task.png"
            });
        }
        
    }   
}

