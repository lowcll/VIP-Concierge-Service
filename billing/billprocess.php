<?php
// grab opening form parts
$namegenurl = $_POST['genurl'];
unset($_POST['genurl']);
$title = $_POST['nametitle'];
unset($_POST['nametitle']);
$fname = $_POST['fname'];
unset($_POST['fname']);
$lname = $_POST['lname'];
unset($_POST['lname']);
$email = $_POST['email'];
unset($_POST['email']);

//destination array
$destarray = array('Select', 'Place 1', 'Place 2', 'Place 3');


// build file name
$filename = $namegenurl.".html";
//check if exists, if so delete it
if(file_exists("bills/".$filename)){
    unlink("bills/".$filename);
}

//create file in append+ mode
$genfile = fopen("bills/".$filename,'a+');

// opening part of html document
$opener = <<<txt
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Your Bill</title>
    <link rel="stylesheet" href="bill-style.css" />
  </head>
  <body>
    <header>
      <nav>
        <ul>
          <li><a href="../home.html">Home</a></li>
          <li><a href="../destinations.html">Destinations</a></li>
          <li><a href="../reviews.html">Reviews</a></li>
          <li><a href="../contact.html">Contact Us</a></li>
        </ul>
      </nav>
    </header>
txt;

// write opener to file
fwrite($genfile, $opener);

// create greeting
$greeting = <<<txt
    <h1>Generated Bill</h1>
    <h3>$title $lname, $fname</h3>
txt;
// write greeting to file
fwrite($genfile, $greeting);

// do fancy stuff to make a table

// extract info from post array
$partysize = array_shift($_POST);
$pair = array_shift($_POST);
$destindex = array_shift($_POST);
$rooms = array_shift($_POST);
$nights = array_shift($_POST);
$destsubtotal = array_shift($_POST);
$flightinput = array_shift($_POST);
$flightsub = array_shift($_POST);
$subtotal = array_shift($_POST);
$commission = array_shift($_POST);
$total = array_shift($_POST);
$destination = $destarray[$destindex];
//create the table
$table = <<<txt
    <table>
        <thead>
            <th>Item</th>
            <th>Amount</th>
        </thead>
        <tr>
            <td>Amount of Travelers</td>
            <td>$partysize</td>
        </tr>
        <tr>
            <td>Destination</td>
            <td>$destination</td>
        </tr>
        <tr>
            <td>Rooms</td>
            <td>$rooms</td>
        </tr>
        <tr>
            <td>Nights</td>
            <td>$nights</td>
        </tr>
        <tr class="subtotal">
            <td>Destination Subtotal</td>
            <td>$destsubtotal</td>
        </tr>
        <tr class="subtotal">
            <td>Flight Subtotal</td>
            <td>$flightsub</td>
        </tr>
        <tr class="subtotal">
            <td>Subtotal</td>
            <td>$subtotal</td>
        </tr>
        <tr class="commission">
            <td>Service Fees</td>
            <td>$commission</td>
        </tr>
        <tr class="total">
            <td>Total</td>
            <td>$total</td>
        </tr>
    </table>
txt;
// write table to file
fwrite($genfile, $table);


// form and footer
$footer = <<<txt
<br><br>    
<form method="post">
   <fieldset>
    <legend>Payment Info</legend>
    <label for="CCnum">Credit Card Number:</label>
    <input type="text" name="CCnum" id="CCnum" placeholder="#### #### #### ####"> <br><br>
    <label for="CVC">CVC:</label>
    <input type="number" name="CVC" id="CVC" placeholder="CVC"><br><br>
    <label for="expdate">Expiration Date:</label>
    <input type="month"><br> <br>
    <label for="name">Name on Card:</label>
    <input type="text" name="name" id="name" placeholder="John Doe"><br><br>
    <input type="submit" value="Make Payment">
   </fieldset>
    
</form>
<footer>
    &copy; VIP Travel Concierge Services, 2023
</footer>
</body>
</html>
txt;
// write to file
fwrite($genfile, $footer);


// close file
fclose($genfile);
// redirect to generated bill
header('Location: bills/'. $filename);
?>