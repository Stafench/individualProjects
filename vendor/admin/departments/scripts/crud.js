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
$(document).ready(function() {
$.ajax({
  url: 'requests/delete_empty_rows.php', 
  type: 'POST',
  success: function(response) {

  },
  error: function(xhr, status, error) {
    console.log(error);
  }
});
let isDragging = false;
let sortNowOrderBy;
let sortNowNameColumn;
let mainTable = $("<table></table>")
let secondaryTable = $('<div></div>')
secondaryTable.attr('id', 'unselectedHT')
let CreateBtn = $('<button class="addBtn btn btn-primary" type="submit" id="CreateBtn">Добавить</button>')
mainTable.attr("id", "mainTable")

function dropMainTable(selector){
  $(selector).droppable({
    tolerance: 'pointer',
      drop: function(event, ui) {
        $('#cln').remove()
        if($(this).children().length == 0){
        $(this).append(ui.draggable.css({
          left: '0',
          top: '0'
        }).hide().fadeIn(150))
        if($('#unselectedHT').children().length < 3){
          $('#unselectedHT').addClass('emptyTable')
          }
      } else{
        ui.draggable.css({
          left: '0',
          top: '0'
        })
      }
      $(this).css({
        background: '#fff'
      })
      idDepartment = $(this).parent().attr('data-id')
      idHead = ui.draggable.attr('data-id')
  $.ajax({
    url: 'requests/update_req.php', 
    type: 'POST', 
    data: {
      id_department: idDepartment,
      name: "head_id",
      value: idHead
    },
    success: function(response) {
    },
    error: function(xhr, status, error) {
      console.log(error);
    }
  });
        ui.draggable.draggable()
      },
      activate: function(event, ui) {
      },
      deactivate: function(event, ui) {
        ui.draggable.css({
          left: '0',
          top: '0'
        })
      },
      over: function(event, ui) {
        if($(this).children().length == 0){
          $(this).append(ui.draggable.clone().addClass('mbDrop').attr('id', 'cln').css({
            left: '0',
            top: '0',
          }).addClass('fadeInAnimation'))
        } else{
          let draggable = ui.draggable.attr('data-id')
          let children = $($(this).children()[0]).attr('data-id')
          if(draggable != children)
          $(this).css({
            background: '#a00'
          })
        }
      },
      out: function() {
        $(this).css({
          background: '#fff'
        })
        $('#cln').remove()
      }
  });
}
let row = $(`
<tr>
    <th id="name">Наименование кафедры</th>
    <th id="full_name">Заведующий кафедрой</th>
    <th id="default">Сортировать по добавлению</th>
</tr>
`);
row.attr("id", "mainTableH")

$('.container-first').append(mainTable)
$('.container-secondary').append(secondaryTable)

$('.container-crBTN').append(CreateBtn)

$('#mainTable').append(row)
row = $(`
<div id="headSecTable">Заведующие кафедрой (невыбранные)</div>
`);
$('#unselectedHT').append(row)
$('#headSecTable').on('click', function(){
  localStorage.setItem('role', 2)
  localStorage.setItem('back', window.location.href)
  window.location.href = "../users/table_users.html"
})
$('#unselectedHT').addClass('droppable')

$.ajax({
  type: "post",
  url: "requests/read_heads.php",
  dataType: "json",
  success: function (response) {
    console.log(response);

    response.forEach(row =>{
      row = $(`
            <div class="rowHT draggable" data-id="${row.id_user}">${row.full_name}</div>
            `)
            $("#unselectedHT").append(row)
    })
  },
  error: function(xhr, status, error) {
    console.log(error);
  }
});

function addRowsInTable(nameColumn = 'id_department', orderBy = 'ASC'){
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
          if(row.head_id == null){
            row = $(`
            <tr class="rowTable" data-id="${row.id_department}">
                <td id="name"><input maxlength="45" placeholder="Введите название" class="form-control" type="text" name="name" value="${row.name}"></td>
                <td id="head" class="droppableMain"> </td>
                <td><button type="submit" class="delBtn btn btn-primary">Удалить</button></td>
            </tr>
                `)
          }else{
            row = $(`
        <tr class="rowTable" data-id="${row.id_department}">
            <td id="name"><input maxlength="45" placeholder="Введите название" class="form-control" type="text" name="name" value="${row.name}"></td>
            <td id="head" class="droppableMain">  <div class="rowHT draggable" data-id="${row.head_id}">${row.full_name}</div></td>
            <td><button type="submit" class="delBtn btn btn-primary">Удалить</button></td>
        </tr>
            `)
          }
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
          if($('#unselectedHT').children().length < 3){
            $('#unselectedHT').addClass('emptyTable')
            }
          $('.draggable').draggable({
            start: function() {
            },
            stop: function() {
             
            }
        });
        dropMainTable('.droppableMain')
        $('.droppable').droppable({
          tolerance: 'pointer',
          drop: function(event, ui) {
            $('#cln').remove()
            idDepartment = ui.draggable.parent().parent().attr('data-id')
            $(this).append(ui.draggable.css({
              left: '0',
              top: '0'
            }).hide().fadeIn(150))
            if($(this).children().length > 2){
              $(this).removeClass('emptyTable')
              }
            $.ajax({
              url: 'requests/clear_head_req.php', 
              type: 'POST', 
              data: {
                id_department: idDepartment,
              },
              success: function(response) {
              },
              error: function(xhr, status, error) {
                console.log(error);
              }
            });
            ui.draggable.draggable()
          },
          activate: function() {
          },
          deactivate: function(event, ui) {
            ui.draggable.css({
              left: '0',
              top: '0'
            })
          },
          over: function(event, ui) {
            let draggableID = ui.draggable.attr('data-id')
            let exist = false;
            let children = $($(this).children()).each(function () {
              if($(this).attr('data-id') == draggableID){
                exist = true
                return 0;
              }
              })
            if(exist) return 0;
            $(this).append(ui.draggable.clone().addClass('mbDrop').attr('id', 'cln').css({
              left: '0',
              top: '0',
            }).addClass('fadeInAnimation'))
          },
          out: function() {
            $('#cln').remove()
          }
      });
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
            id_department: id,
            name: this.name,
            value: this.value,
          },
          success: function(response) {
            console.log(response);
          },
          error: function(xhr, status, error) {
            console.log(error);
          }
        });
    })
  }
  function addEventOnChangeAddRow(objInputs) {
        let row = $(objInputs).parent().parent()

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


      let rowHT = $(row).find('.rowHT')


      id = $(row).attr('data-id')
      $(row).fadeOut(500, function() {
        $('.droppable').append(rowHT.css({
          left: '0',
          top: '0'
        }))
        rowHT.draggable()
        $(rowHT).hide().fadeIn(500)
        $(row).remove();
      });
      $.ajax({
          url: 'requests/delete_req.php',
          type: 'POST',
          data:{
              id_department: id
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
        <td id="name"><input maxlength="45" placeholder="Введите название" class="form-control" type="text" name="name" value=""></td>
        <td id="head" class="droppableMain"> </td>
        <td><button type="submit" class="delBtn btn btn-primary">Удалить</button></td>
      </tr>            `)
            $(row).css('display', 'none');
              $("#mainTable").append(row)
              $(row).fadeIn(500);
              dropMainTable(".newRowTable #head")
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
    if(sortNowNameColumn === 'id_department' && sortNowOrderBy === 'ASC'){
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
      let rowData = $(this).find('td input[type=text], .rowHT')
      let found = false

      rowData.each(function(){
        if($(this).is(':input')) str = this.value.toLowerCase()
        else str = $(this).text().toLowerCase()
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
})
