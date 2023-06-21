$(document).ready(function() {
    $("#custom-menu").hide();
    // Отключаем стандартное контекстное меню браузера
    $(document).on("contextmenu", function(e) {
      e.preventDefault();
      // Позиционируем ваше собственное контекстное меню по координатам клика
      $("#custom-menu").css({
        display: "block",
        position: 'absolute',
        left: e.pageX,
        top: e.pageY
      });
    });
  
    // Скрываем ваше собственное контекстное меню при клике вне него
    $(document).on("click", function() {
      $("#custom-menu").hide();
    });
    $.ajax({
        url: 'requests/read_teachers_req.php',
        type: 'POST',
        dataType: 'json',
        success: function (response) {
        //   console.log(response);
        response.forEach(element => {
            let row = (`<li data-id="${element.id_user}">${element.full_name}</li>`)
            $("#custom-menu ul").append(row)
        });
        
        },
        error: function (xhr, status,response) {
            console.log(response)
        }
    })
  });