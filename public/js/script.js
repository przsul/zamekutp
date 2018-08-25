$(document).ready(function() {

  $("#search").val("");
  $("#last_name").val("");
  $("#first_name").val("");
  $("#card_id").val("");

  $.getJSON("getData.php", function(result) {
    count = result.length;
    if(count == 1)
      $("#whitelistHeader").text("Whitelist: " + count + " person");
    else
      $("#whitelistHeader").text("Whitelist: " + count + " persons");

    $.each(result, function(i, field) {
      $("#persons").append(`
          <tr class="person">
          <td>${field.id}</td>
          <td>${field.last_name}</td>
          <td>${field.first_name}</td>
          <td>${field.card_id}</td>
          <td class="cross text-center"><i class="fa fa-times-circle"></i></td>
          </tr>
      `);
    });

    $("i.fa").click(function() {
      if (confirm("Are you sure to delete this person?")) {
        var personID = $(this).parent().prev().prev().prev().prev().text();
        var data = {id: personID};
        $.post("deleteData.php", data); 
        $(this).closest("tr").fadeOut("fast");
        count = count-1;
        if(count == 1)
          $("#whitelistHeader").text("Whitelist: " + count + " person");
        else
          $("#whitelistHeader").text("Whitelist: " + count + " persons");
      }
    });

    $("button.btn").click(function() {
      if(($.trim($('#last_name').val()).length == 0) || 
         ($.trim($('#first_name').val()).length == 0) || 
         ($.trim($('#card_id').val()).length == 0)) {
        alert("Complete the form.");
        return 1;        
      }

      var _last_name = $("#last_name").val();
      var _first_name = $("#first_name").val();
      var _card_id = $("#card_id").val();

      var data = {last_name: _last_name, first_name: _first_name, card_id: _card_id};
      $.post("addData.php", data, function() {
        location.reload();
      }); 
    });
  });

  $("#search").keyup(function () {
    var value = $(this).val().toLowerCase();
    $("#persons tr").filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });

});
