//Commission Rate:
comRate = 0.08; // 8%
// simple function to calculate rooms
function calculateRooms(people, pair) {
  var rooms = people;
  if (pair) {
    if (people % 2 == 1) {
      rooms = Math.floor(people / 2) + 1;
    } else {
      rooms = people / 2;
    }
  }
  return rooms;
}
// another simple function to calculate total room expense
function calculateRoomExpense(bookfee, rate, time, rooms) {
  var expense = rate * time * rooms + bookfee;
  return expense;
}

// function to calculate flight expense
function calculateFlightExpense(passengers, ticketcost){
    return passengers*ticketcost;
}

// function to calculate subtotal cause it requires a bit of string fuckery
function calculateSubtotal(Dtotal, Ftotal){
    dtot = parseFloat(Dtotal.substring(1));
    ftot = parseFloat(Ftotal.substring(1));
    return (dtot + ftot).toFixed(2);
}

// function to calculate commission cause why not
function calculateCommission(subtot){
    comm = comRate * parseFloat(subtot.substring(1));
    return comm.toFixed(2);
}

function calculateTotal(Stotal, commi){
    stot = parseFloat(Stotal.substring(1));
    commitot = parseFloat(commi.substring(1));
    return (stot + commitot).toFixed(2);
}
// small arrray of destinations to test
var destinations = [
  (dest0 = {
    //default value
    id: 0,
    nightly: 0,
    booking: 0,
    ticket: 0,
  }),
  (dest1 = {
    id: 1,
    nightly: 300,
    booking: 50,
    ticket: 3500,
  }),
  (dest2 = {
    id: 2,
    nightly: 400,
    booking: 90,
    ticket: 5000,
  }),
  (dest3 = {
    id: 3,
    nightly: 700,
    booking: 75,
    ticket: 2500,
  }),
];

// destination id choice
var destchoice = 0;
// number of people traveling
var party = 0;
// whether to pair up people in rooms
var pairing = false;
// how many nights the party is staying for
var nights = 0;
$(function () {
  // if destination changes, update pointer to choice
  $("#destlist").on("change", function () {
    destchoice = $(this).val();
    updateItems();
  });

  // grab value of party size on update
  $("#partysize").on("input", function () {
    party = $(this).val();
    updateItems();
  });
  // grab state of pairing on update
  $(".paircheck").on("input", function () {
    pairing = $(this).val() === 'true';
    updateItems();
  });

  $("#nights").on("input", function () {
    nights = $(this).val();
    updateItems();
  });

  $('#flightinput').on("input", function(){
    destinations[destchoice].ticket = $(this).val();
    updateItems();
  });

  
  function updateItems() {
    $("#rooms").val(calculateRooms(party, pairing)); // calculate number of rooms
    var roomRate = destinations[destchoice].nightly; // update room rate
    var bookingfee = destinations[destchoice].booking; // update booking fee
    $("#destsubtotal").val("$" + calculateRoomExpense(bookingfee,roomRate,nights,$('#rooms').val()).toString()); // calculate room costs

    var flightticket = destinations[destchoice].ticket; // get ticket price
    $("#flightsubtotal").val("$" + calculateFlightExpense(party, flightticket).toString()); // calculate flight cost

    // add to subtotal
    $("#subtotal").val("$" + calculateSubtotal($('#destsubtotal').val(), $('#flightsubtotal').val()));
    //calculate commission
    $('#commission').val("$" + calculateCommission($('#subtotal').val()));
    // calculate total
    $('#total').val("$" + calculateSubtotal($("#subtotal").val(), $("#commission").val()));
  }
});
