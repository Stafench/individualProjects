$.ajax({
  url: '../Access.php', 
  type: 'POST',
  success: function(response) {
    if( response === "Недостаточно прав")
    window.location.href  = "../../../../index.php"
  },
  error: function(xhr, status, error) {
    console.log("Ошибка:" + error);
  }
});

$.ajax({
  url: 'requests/delete_empty_rows.php', 
  type: 'POST',
  success: function(response) {

  },
  error: function(xhr, status, error) {
    console.log(error);
  }
});
let sortNowOrderBy;
let sortNowNameColumn;
let table = $("<table></table>")
let CreateBtn = $('<button class="addBtn btn btn-primary" type="submit" id="CreateBtn">Добавить</button>')
table.attr("id", "mainTable")

let row = $(`
<tr>
    <th id="name">Наименование дисциплины</th>
    <th id="default">Сортировать по добавлению</th>
</tr>
`);
row.attr("id", "mainTableH")
$('body').append(table)
$('body').append(CreateBtn)

$('#mainTable').append(row)


function addRowsInTable(nameColumn = 'id_object', orderBy = 'ASC'){
  $.ajax({
    url: 'requests/read_req.php',
    type: 'POST', 
    dataType: 'json',
    data: {
      nameColumn: nameColumn,
      orderBy: orderBy
    }, 
    success: function(response) {
      $('.rowTable').remove()
      console.log(response);
      sortNowOrderBy = orderBy;
      sortNowNameColumn = nameColumn;
        response.forEach(row => {

            row = $(`
        <tr class="rowTable" data-id="${row.id_object}">
            <td id="name"><input maxlength="45" placeholder="Введите название" class="form-control" type="text" name="name" value="${row.name}"></td>
            <td><button type="submit" class="delBtn btn btn-primary">Удалить</button></td>
        </tr>
            `)
            $("#mainTable").append(row)
          });
          addEventHighlightRow('.rowTable', '.rowTable input[type=text]')
          addEventHighlightRowOnFocus('.rowTable input[type=text]')
          addEventOnClickDelBtn('.rowTable .delBtn')
          addEventOnChangeUpdateRow('.rowTable input[type=text]')
          $(window).on('load', function() {
            $('body').addClass('fade-in');
          });
          searchInTable()
    },
    error: function(xhr, status, error) {
      console.log(error);
    }
  });
}
  function addEventHighlightRowOnFocus(objInputs) {
    $(objInputs).focus(function () { 
      console.log($(this).parent().parent());
      $($(this).parent().parent()).addClass('hoveredRow');
    });
    $(objInputs).blur(function () { 
      console.log($(this).parent().parent());
      $($(this).parent().parent()).removeClass('hoveredRow');
    });
  }
  function addEventHighlightRow(objRow, objInputs){
    $(objRow).hover(function () {
      if($(objInputs).is(':focus')){
        // console.log('Событие фокуса активно');
        return 0;
      }
      $(this).addClass('hoveredRow');
      }, function () {
        if($(objInputs).is(':focus')){
          // console.log('Событие фокуса активно');
          return 0;
        }
        $(this).removeClass('hoveredRow');
      }
    );
  }
  function addEventOnChangeUpdateRow(objInputs) {
    $(objInputs).change( function () {
      let row = $(this).parent().parent()
      id = $(row).attr('data-id')
      $.ajax({
          url: 'requests/update_req.php', 
          type: 'POST', 
          data: {
            id_object: id,
            name: this.name,
            value: this.value,
          },
          success: function(response) {
          },
          error: function(xhr, status, error) {
            console.log(error);
          }
        });
    })
  }
  function addEventOnChangeAddRow(objInputs) {
        let row = $(objInputs).parent().parent()
        // let login = row.children('#login').children('input[name=login]:first')[0].value
        // let password = row.children('#password').children('input[name=password]:first')[0].value
        // let lastname = row.children('#lastname').children('input[name=lastname]:first')[0].value
        // let firstname = row.children('#firstname').children('input[name=firstname]:first')[0].value
        // let middlename = row.children('#middlename').children('input[name=middlename]:first')[0].value

        $.ajax({
            url: 'requests/create_req.php', 
            type: 'POST',
            dataType: 'json',
            data: {
              name: null
            },
            success: function(response) {
                row.attr('data-id', response)
                row.attr('class', 'rowTable')
            },
            error: function(xhr, status, error) {
              console.log(error);
            }
          });
  }

  function addEventOnClickDelBtn(delBtn){
    $(delBtn).click(function() {
      let row = $(this).parent().parent()
      id = $(row).attr('data-id')
      $(row).fadeOut(500, function() {
        $(row).remove();
      });
      $.ajax({
          url: 'requests/delete_req.php',
          type: 'POST',
          data:{
              id_object: id
          },
          success: function (response) {
            console.log(response);
          },
          error: function (xhr, status,response) {
              console.log(response)
          }
      })
  })
  }
addRowsInTable( )
    $('#CreateBtn').click(function() {
        row = $(`
        <tr class="newRowTable" data-id="newID">
        <td id="name"><input maxlength="45" placeholder="Введите название" class="form-control" type="text" name="name" value"></td>
            <td><button type="submit" class="delBtn btn btn-primary">Удалить</button></td>
        </tr>
            `)
            $(row).css('display', 'none');
              $("#mainTable").append(row)
              $(row).fadeIn(500);
              addEventHighlightRow('.newRowTable', '.newRowTable input[type=text], .rowTable input[type=text]')
              addEventHighlightRowOnFocus('.newRowTable input[type=text]')
              addEventOnClickDelBtn('.newRowTable .delBtn')
              addEventOnChangeUpdateRow('.newRowTable input[type=text]')
              addEventOnChangeAddRow('.newRowTable input[type=text]')
    })
$(document).ready(function () {
    $(document).keydown(function (event) { 
      if (event.which === 13) {
      $(':focus').blur()
      }
    });
    $(window).scroll(function() {
      if ($(this).scrollTop() > 200) {
          $('.anchor-link').addClass('show');
      } else {
          $('.anchor-link').removeClass('show');
      }
  });

  $('.anchor-link').click(function(e) {
      e.preventDefault();
      $('html, body').animate({
          scrollTop: $('body').offset().top
      }, 750); // Время прокрутки в миллисекундах (здесь 1000 мс = 1 секунда)
  });
  });


$('#link-back').on('click', function(event) {
  event.preventDefault(); // Предотвращает обычное действие ссылки (например, перезагрузку страницы)
  
  $('*').fadeOut(500, function() {
    setTimeout(() => {
      window.location.href = event.target.href;
    }, 500);
    
  });
});
  $('#mainTableH').children().each(function(){
    addSortForColumn(this)
  })
  function addSortForColumn(element){
    $('#mainTableH #' + $(element).attr('id') + ':not(:last-child)').click(function (e) { 
      e.preventDefault();
      console.log(e.currentTarget);
      if(sortNowNameColumn === $(e.currentTarget).attr('id') && sortNowOrderBy === 'ASC'){
      addRowsInTable($(e.currentTarget).attr('id'), 'DESC')
      $('#orderBy').remove()
      $(this).append('<div id="orderBy">Я-А</div>')
    }
      else{
      addRowsInTable($(e.currentTarget).attr('id'), 'ASC')
      $('.sortedColumn').removeClass('sortedColumn')
      $(this).addClass('sortedColumn')
      $('#orderBy').remove()
      $(this).append('<div id="orderBy">А-Я</div>')
    }
    });
  }
  $('#mainTableH #default').click(function (e) { 
    e.preventDefault();
    if(sortNowNameColumn === 'id_object' && sortNowOrderBy === 'ASC'){
    addRowsInTable(undefined ,'DESC')
    $('#orderBy').remove()
    $(this).append('<div id="orderBy">новым-старым</div>')
  }
    else{
    addRowsInTable()
    $('.sortedColumn').removeClass('sortedColumn')
    $(this).addClass('sortedColumn')
    $('#orderBy').remove()
    $(this).append('<div id="orderBy">старым-новым</div>')
  }
  });

  $('#searchInput').change(function(){
    searchInTable()
  })

  function searchInTable(){
    $('.rowTable').each(function(){
      $(this).show()
    })
    let searchText = $('#searchInput').val().toLowerCase();
    $('.rowTable').each(function(){
      let rowData = $(this).find('td input[type=text]')
      let found = false

      rowData.each(function(){
        // let cellData = $(this).children('')

          str = this.value.toLowerCase()
          if(str.includes(searchText)){
            found = true
          }

        if(found) {
          found = true;
          return false;
        }

        // if(found) $(this).show()
        // else $(this).hide()
      })
      if(found) $(this).show()
        else $(this).hide()
    })
  }