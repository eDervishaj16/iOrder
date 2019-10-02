//Displays all the rows that the user has selected
function displayLogInInfo(){
    var place = document.getElementsByTagName("form")[0];

    place.innerHTML = "<input style = \"width: 220px; margin-left: 5px;\" name = \"username\" type = \"text\" placeholder= \"Username\"><br><span id = \"error\">"+
    "\<\?php echo $unErr;\?\></span><br><input style = \"width: 220px; margin-left: 5px;\" name = \"password\" type = \"password\" placeholder=\"Password\"><br>"+
    "<span id = \"error\">\<\?php echo $pwErr;\?\></span><br><input id = \"loginBtn\" type = \"submit\" name = \"myLogin\" value = \"Log In\">";

    var place2 = document.getElementById("signUp");

    place2.innerHTML = "<button name = \"forgotPassBtn\" onclick = \"window.location.href = \'forgotPass.php\'\">Forgott your password?</button>"+
    "<button name = \"singupBtn\" onclick = \"window.location.href =\'signup.php\'\">Sign Up</button>";
}

function displayItems(){
    var data;
    var i = 0;
    var myTable = "<table id = 'ordersTable'>"
    do{
        var row = "row" + i;
        i++;
        data = sessionStorage.getItem(row);
        if(!(data===null)){
            myTable += "<tr>"+data+"</tr>";
        }
    }while(!(data === null));

    myTable += "</table>";
    document.getElementById("orderedItems").innerHTML = "<table name='defaultTable' id='rowInformation'><tr id='mainRow'><td name='qtyRow'>Qty.</td><td name='itemRow'>Item</td><td name='priceRow'>Price</td><td name='dropRow'></td></tr></table>" + myTable;

    updateTotPrice(document.getElementById("ordersTable"));

    if(myTable == "<table id = 'ordersTable'></table>"){
        document.getElementById("orderedItems").innerHTML = "<div id = \"emptyTable\"><label name = 'noitems'>It looks like you have no items in your bag. Press below to go back to the menu!</label><br><br><button name = 'select' id = 'backBtn' onclick = 'changeToMenu()'>Go back!</button></div>"
        document.getElementById("orderedItems").setAttribute("name", "empty");
    }
    
}

// Deletes the clicked row
function removeRow(myTD){
    var i = myTD.parentNode.rowIndex;

    document.getElementById("ordersTable").deleteRow(i);
    updateTotPrice(document.getElementById("ordersTable"));

    var myTable = document.getElementById("ordersTable");
    if(myTable.getElementsByTagName("tr").length == 0){
        document.getElementById("orderedItems").innerHTML = "<div id = \"emptyTable\"><label name = 'noitems'>It looks like you have no items in your bag. Press below to go back to the menu!</label><br><button name = 'select' id = 'backBtn' onclick = 'changeToMenu()'>Go back!</button></div>"
        document.getElementById("orderedItems").setAttribute("name", "empty");
    }
}

//Upadtes the price
function updateTotPrice(myTable){
    var rows = myTable.getElementsByTagName("tr");
    var priceContainer = myTable.parentElement.parentElement.childNodes[5].childNodes[1];
    var price = 0;

    for(var i = 0; i < rows.length; i++){
        price += rows[i].childNodes[0].innerHTML * rows[i].childNodes[2].innerHTML;
    }
    priceContainer.innerHTML = price;
}

// Go back to the menu
function changeToMenu(){
    window.location = "user.php";
    sessionStorage.clear();
}


// Adding the items to the database
function addToDB(){
    var myTable = document.getElementById("ordersTable");
    var items = "";
    var price = 0;
    var len;
    if(myTable.getElementsByTagName("tbody")[0].childNodes != null){

        myRows = myTable.getElementsByTagName("tbody")[0].childNodes;
        len = myRows.length;

        for(var i = 0; i < len; i++){
            items += myRows[i].childNodes[0].innerText + " " + myRows[i].childNodes[1].innerText + ",";
            console.log(items);
            price += parseInt(myRows[i].childNodes[2].innerText);
            console.log(price);
        }
    }

    jQuery.post("itemsForDB.php", {
        items: items,
        price: price
    }, function(){
        alert("Order submited!");
    });

}
