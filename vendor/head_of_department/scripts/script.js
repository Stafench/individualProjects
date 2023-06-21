$('.exit').click(function(){
    $.ajax({
        url: '../signout.php',
        type: 'POST',
        success: function(response) {
        },
        error: function(xhr, status, error) {
          console.log(error);
        }
      });
    window.location.href  = "../../../index.php";
})
$.ajax({
    url: 'requests/read_req.php',
    type: 'POST',
    dataType: 'json', 
    success: function(response) {
      console.log(response);
      counter = 1
      response.forEach(row => {
        row = (`
        <tr class="rowTable" data-id="${row.id_user}">
            <th>${counter}</th>
            <td class="fullNameTD">${row.full_name}</td>
            <td><input type="number" class="form-control" name="amount" value="${row.numbers_of}"></td>
          </tr>
        `)
        $('tbody').append($(row))
        counter++;
      });
      addEventHighlightRowOnFocus('input')
      addEventHighlightRow();
      addEventOnChangeUpdateRow('.rowTable input[type=number]') 
    },
    error: function(xhr, status, error) {
      console.log(error);
    }
  });
 function addEventHighlightRow(){
        $('.rowTable').hover(function () {
            if($('input').is(':focus')){
              return 0;
            }
            $(this).addClass('hoveredRow');
            }, function () {
              if($('input').is(':focus')){
                return 0;
              }
              $(this).removeClass('hoveredRow');
            });
 }
 $(document).ready(function () {
    $(document).keydown(function (event) { 
      if (event.which === 13) {
      $(':focus').blur()
      }
    });
})
 function addEventHighlightRowOnFocus(objInputs) {
    $(objInputs).focus(function () { 
      $($(this).parent().parent()).addClass('hoveredRow');
    });
    $(objInputs).blur(function () { 
      $($(this).parent().parent()).removeClass('hoveredRow');
    });
  }

  function addEventOnChangeUpdateRow(objInputs) {
    $(objInputs).change( function () {
      let row = $(this).parent().parent()
      id = $(row).attr('data-id')
      console.log(id);
      $.ajax({
          url: 'requests/update_req.php', 
          type: 'POST', 
          data: {
            id: id,
            numbers: this.value
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
  $('#searchInput').change(function(){
    searchInTable()
  })
  function searchInTable(){
    $('.rowTable').each(function(){
      $(this).show()
    })
    let searchText = $('#searchInput').val().toLowerCase();
    $('.rowTable').each(function(){
      let rowData = $(this).find('td')
      let found = false

      rowData.each(function(){

          str = $(this).text().toLowerCase()
          if(str.includes(searchText)){
            found = true
          }

        if(found) {
          found = true;
          return false;
        }

      })
      if(found) $(this).show()
        else $(this).hide()
    })
  }
  