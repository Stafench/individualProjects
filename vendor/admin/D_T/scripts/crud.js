const listItemMain = $(`<button type="button" class="list-groups list-group-item list-group-item-action" aria-current="true"></button>`)
const listItemModal = $(`<button type="button" class="list-item list-group-item list-teachers list-group-item-action" aria-current="true"></button>`)
let modalTable = new bootstrap.Modal(document.getElementById('modalTable'), { 
    keyboard: false
  })
let dataIDdepartment;
let selectedOnly;
let nameDepartment;




function addRowsInMainTable(nameColumn = 'id_department', orderBy = 'ASC'){
$.ajax({
    url: 'requests/read_req.php',
    type: 'POST', 
    dataType: 'json',
    data: {
      nameColumn: nameColumn,
      orderBy: orderBy
    }, 
    success: function(response) {
      console.log(response);
      response.forEach(row => {
        $('.list-group-groups').append(listItemMain.clone(true).text(row.name).attr('data-id', row.id_department))
      });
    },
    error: function(xhr, status, error) {
      console.log(error);
    }
  });
}
addRowsInMainTable()
// $(document).on('click', '.list-group-item', function(){
//     if($(this).hasClass('active')) $(this).removeClass('active');
//     else $(this).addClass('active');
    
// })
function addRowsInModalTable(orderBy = 'ASC', departmentID, unselected = false){
    $.ajax({
        url: 'requests/read_teachers_req.php',
        type: 'POST', 
        dataType: 'json',
        data: {
          orderBy: orderBy,
          departmentID: departmentID,
          unselected: unselected
        }, 
        success: function(response) {
          console.log(response);
          response.forEach(row => {
            let elem = listItemModal.clone(true)
            $('.list-group-students').append($(elem).text(row.full_name).attr('data-id', row.id_user))
            if(row.have == 1) $(elem).addClass('active');
          });
        },
        error: function(xhr, status, error) {
          console.log(error);
        }
      });
}
$(document).on('click', '.list-groups', function(){
    modalTable.toggle()
    nameDepartment = $(this).text()
    $('.nameDepartment').text(nameDepartment)
    dataIDdepartment =$(this).attr('data-id')
    $('.list-group-students').empty()
    addRowsInModalTable(undefined, dataIDdepartment)
})
$('.close-modal').click(function(){
    modalTable.toggle()
    $('#switchSelected').prop('checked', false)
})
function switchSelected(selectSwitch){
    if(selectSwitch){
        $('.list-group-students button:not(.active)').hide()
    }
    else{
        $('.list-group-students button:not(.active)').show()
    }
}
$('#switchSelected').click(function(){
    selectedOnly = $(this).prop("checked")
    $('.list-group-students').empty()
    addRowsInModalTable(undefined, dataIDdepartment, false)
    $('#switchUnselected').prop("checked", false)
    setTimeout(() => {
        switchSelected(selectedOnly)
    }, 10);
    
})
$('#switchUnselected').click(function(){
    $('.list-group-students').empty()
    $('#switchSelected').prop("checked", false)
    if($(this).prop("checked")){
        addRowsInModalTable(undefined, dataIDdepartment, true)
    }
    else{
        addRowsInModalTable(undefined, dataIDdepartment, false)
    }
    
})
$('#modalTable').on('hidden.bs.modal', function (e) {
    $('#switchSelected').prop("checked", false)
    $('#switchUnselected').prop("checked", false)
    $('#searchInput').val('')
  });
$(document).on('click', '.list-teachers', function(){
    // console.log($(this).attr('data-id'));
    let teacherID = $(this).attr('data-id')
    let elemList = this
    if($(this).hasClass('active')){
        $(this).removeClass('active')
        $.ajax({
            url: 'requests/remove_row_teacher_department_req.php',
            type: 'POST', 
            data: {
                teacherID: teacherID
            }, 
            success: function(response) {
              console.log("Удалено успешно.");
            },
            error: function(xhr, status, error) {
              console.log(error);
            }
          });
    }
    else{
    $.ajax({
        url: 'requests/exist_teacher.php',
        type: 'POST', 
        data: {
            teacherID: teacherID
        }, 
        success: function(response) {
          console.log(response);
          if(response === '1'){
            $.ajax({
                url: 'requests/update_teacher_department_req.php',
                type: 'POST', 
                data: {
                    teacherID: teacherID,
                    departmentID: dataIDdepartment
                }, 
                success: function(response) {
                  console.log("Изменено успешно.");
                },
                error: function(xhr, status, error) {
                  console.log(error);
                }
              });
          }
          else{
            $.ajax({
                url: 'requests/insert_teacher_department_req.php',
                type: 'POST', 
                data: {
                    teacherID: teacherID,
                    departmentID: dataIDdepartment
                }, 
                success: function(response) {
                  console.log("Добавлено успешно.");
                },
                error: function(xhr, status, error) {
                  console.log(error);
                }
              });
          }
          $(elemList).addClass("active")
        },
        error: function(xhr, status, error) {
          console.log(error);
        }
      });
    }
})
$('.exit').click(function(){
    window.location.href  = "../../../../index.php";
})

$('#searchInput').change(function(){
    $('.list-group-students .list-item').each(function(){
        $(this).show()
        $(this).addClass('list-group-item')
      })
      switchSelected(selectedOnly)
    searchText = this.value.toLowerCase()
    $('.list-group-students .list-item').each(function(){
        str = $(this).text().toLowerCase()
          if(!str.includes(searchText)){
            $(this).hide().removeClass('list-group-item')
          }
    })
})