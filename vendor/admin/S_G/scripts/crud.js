const listItemMain = $(`<button type="button" class="list-groups list-group-item list-group-item-action" aria-current="true"></button>`)
const listItemModal = $(`<button type="button" class="list-group-item list-students list-group-item-action" aria-current="true"></button>`)
let modalTable = new bootstrap.Modal(document.getElementById('modalTable'), { 
    keyboard: false
  })
let dataIDgroup;
let selectedOnly;
let nameGroup;




function addRowsInMainTable(nameColumn = 'id_group', orderBy = 'ASC'){
$.ajax({
    url: '../groups/requests/read_req.php',
    type: 'POST', 
    dataType: 'json',
    data: {
      nameColumn: nameColumn,
      orderBy: orderBy
    }, 
    success: function(response) {
      console.log(response);
      response.forEach(row => {
        $('.list-group-groups').append(listItemMain.clone(true).text(row.name).attr('data-id', row.id_group))
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
function addRowsInModalTable(orderBy = 'ASC', groupID, unselected = false){
    $.ajax({
        url: 'requests/read_students_req.php',
        type: 'POST', 
        dataType: 'json',
        data: {
          orderBy: orderBy,
          groupID: groupID,
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
    nameGroup = $(this).text()
    $('.nameGroup').text(nameGroup)
    dataIDgroup =$(this).attr('data-id')
    $('.list-group-students').empty()
    addRowsInModalTable(undefined, dataIDgroup)
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
    addRowsInModalTable(undefined, dataIDgroup, false)
    $('#switchUnselected').prop("checked", false)
    setTimeout(() => {
        switchSelected(selectedOnly)
    }, 10);
    
})
$('#switchUnselected').click(function(){
    $('.list-group-students').empty()
    $('#switchSelected').prop("checked", false)
    if($(this).prop("checked")){
        addRowsInModalTable(undefined, dataIDgroup, true)
    }
    else{
        addRowsInModalTable(undefined, dataIDgroup, false)
    }
    
})
$('#modalTable').on('hidden.bs.modal', function (e) {
    $('#switchSelected').prop("checked", false)
    $('#switchUnselected').prop("checked", false)
    $('#searchInput').val('')
  });
$(document).on('click', '.list-students', function(){
    // console.log($(this).attr('data-id'));
    let studentID = $(this).attr('data-id')
    let elemList = this
    if($(this).hasClass('active')){
        $(this).removeClass('active')
        $.ajax({
            url: 'requests/remove_row_student_group_req.php',
            type: 'POST', 
            data: {
                studentID: studentID
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
        url: 'requests/exist_student.php',
        type: 'POST', 
        data: {
            studentID: studentID
        }, 
        success: function(response) {
          console.log(response);
          if(response === '1'){
            $.ajax({
                url: 'requests/update_student_group_req.php',
                type: 'POST', 
                data: {
                    studentID: studentID,
                    groupID: dataIDgroup
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
                url: 'requests/insert_student_group_req.php',
                type: 'POST', 
                data: {
                    studentID: studentID,
                    groupID: dataIDgroup
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
    $('.list-group-students .list-group-item').each(function(){
        $(this).show()
      })
      switchSelected(selectedOnly)
    searchText = this.value.toLowerCase()
    $('.list-group-students .list-group-item').each(function(){
        str = $(this).text().toLowerCase()
          if(!str.includes(searchText)){
            $(this).hide()
          }
    })
})