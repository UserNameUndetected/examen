//Onclick verwijderen, warning and delete
$('.verwijderItem').on('click', function () {
  let id = $(this).attr('id').replace('item-', '');
  let removeThis = $(this).closest('tr');

  if (confirm('Weet je zeker dat je dit item wilt verwijderen? Het is niet mogelijk om het weer terug te halen')) {

    // ajax call
    $.ajax({
      url: 'ajax.php',
      type: 'POST',
      data: {
        'deleteMenuitemcode': id,
      },
      success: function () {
        removeThis.remove();
      },
    });
  }
});

//shows messaegs
$('.messageBox').each(function () {
  //remove trailing spaces
  var text = $(this).text().replace(/^\s\s*/, '').replace(/\s\s*$/, '');

  //if div has text in it, display div.
  if (text !== '') {
    $(this).removeClass('d-none')
  }
});

//delete reservation ajax call
$('.reservationVerwijderen').on('click', function () {

  //Confirmation message
  if (confirm("Weet je zeker dat je deze reservatie wilt verwijderen? Het is niet mogelijk om hem weer terug te halen")) {

    let removeThis = $(this).closest('tr');
    let datum = $(this).parent().find('.verwijderDatum').val();
    let tijd = $(this).parent().find('.verwijderTijd').val();
    let tafel = $(this).parent().find('.verwijderTafel').val();

    if (datum.length !== 0 && tijd.length !== 0 && tafel.length !== 0) {
      // ajax call
      $.ajax({
        url: 'ajax.php',
        type: 'POST',
        data: {
          'verwijderDatum': datum,
          'verwijderTijd': tijd,
          'verwijderTafel': tafel,
        },
        success: function (e) {
          removeThis.remove();
        },
        error: function (e) {
          alert('Er is iets fout gegaan tijdens het verwijderen van de reservering')
        }
      });
    }
  }
});

//On click geleverd
$('.bestellingGeleverd').on('click', function () {

  //Confirmation message
  if (confirm("Klopt het dat dit product klaar is om te serveren?")) {

    let bestellingID = $(this).parent().find('.bestellingID').val();

    $.ajax({
      url: 'ajax.php',
      type: 'POST',
      data: {
        'bestellingID': bestellingID,
      },
      success: function (e) {
        location.reload();
      },
      error: function (e) {
        alert('Er is iets fout gegaan tijdens het klaarzetten van het product')
      }
    })
  }
});