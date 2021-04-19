// Справка

  var info = document.getElementById("info").onclick = function () {
    alert("Для добавления QR-кода в счет, нажмите на кнопку 'Выберите файл' и после открытия диалогового окна, выберите файл с расшерением 'XLS', после нажмите 'OK'.  Файл будут записан в папку 'Счета'. Проверьте ваш файл на наличее в нем корректного QR-кода и отошлите его клиенту по электронной почте. ");
  } 
    

// Получение объекта файл+++++++++++++++++++++++++++++++++

	var control = document.getElementById("file");
		control.addEventListener("change", function(event) {
  // Когда происходит изменение элементов управления, значит появились новые файлы
  	var i = 0,
    	files = control.files,
    	len = files.length;
      file = control.files[0];

    //   var path = (window.URL || window.webkitURL).createObjectURL(file);
    // console.log('path', path);

  request (control.files[0].name);

}, false);

//----------------------------------------------------------


var inputs = document.querySelectorAll('.inputfile');
Array.prototype.forEach.call(inputs, function(input){
  var label  = input.nextElementSibling,
      labelVal = label.innerHTML;
  input.addEventListener('change', function(e){
    var fileName = '';
    if( this.files && this.files.length > 1 )
      label.querySelector( 'span' ).innerHTML = fileName;
    else
      fileName = control.files[0].name;
    //e.target.value.split( '/' ).pop();
    if( fileName )
      label.querySelector( 'span' ).innerHTML = fileName;
    else
      label.innerHTML = labelVal;
  });
});




// Создаем форму с несколькими значениями+++++++++++++++++++
function request (data)  {  
  
  var request = new XMLHttpRequest();
  var path_mac = "/qr_code_generator/server.php";
  
  request.open('POST', path_mac ,true);
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.addEventListener('readystatechange', function() {
    
    if ((request.readyState==4) && (request.status==200)) {
      
      let output = document.getElementById('answer');
      
      output.innerHTML = request.responseText;        

    }
  });

request.send("file=" + data);

};

//----------------------------------------------------------




