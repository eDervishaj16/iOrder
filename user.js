// GLOBAL VARIABLES
var i = 0; // Used to insert rows in the orders table

function goToNextPage(){

    saveSelItems(document.getElementById("ordersTable"));

    // Get the index of the current page
    var index = document.getElementsByName("currentPage")[0].innerText;
    var maxPages = document.getElementsByName("lastPage")[0].innerText;

    if(index < maxPages){
        ++index;
        var pageToGo = "userPg"+index+".php";
        window.location.href = pageToGo;
    }
}

function goToPrevPage(){

    saveSelItems(document.getElementById("ordersTable"));
    
    // Get the index of the current page
    var index = document.getElementsByName("currentPage")[0].innerText;
    if(index == 2){
        --index;
        window.location.href = "user.php";
    }else if(index > 2){
        --index;
        var pageToGo = "userPg"+index+".php";
        window.location.href = pageToGo;
    }
}

// Selects / Deselcts the clicked element
function changeSelected(){
    // Get the element that is beeing clicked
    var myItem = document.getElementsByName("clicked")[0];
    // if unselected select
    if(myItem.getAttribute("class") == "unselected"){
        myItem.setAttribute("class", "selected");
        addToOrder(myItem);
        myItem.childNodes[9].setAttribute("id", "activeDisplayParagraph");
    }else{
        myItem.setAttribute("class", "unselected");
        removeFromOrder(myItem);
        myItem.childNodes[9].setAttribute("id", "displayParagraph");
    }
}


// Adds an item to the "My Orders" table
function addToOrder(myItem){

    var myOrders = document.getElementById("ordersTable");

    var rows = myOrders.getElementsByTagName("tr");
    var itemName = myItem.childNodes[3].innerText;
    var existing = false;

    // Checking if the item is already put in the table
    if(rows.length > 0){
        for(var i = 0; i < rows.length; i++){
            if(rows[i].getAttribute("name") == itemName){
                existing = true;
            }
        }
    }

    if(!existing){
        // Insert all
        var row = myOrders.insertRow(i);

        // This is used to uniquely identify a row
        row.setAttribute("name", myItem.childNodes[3].innerText);

        // Quantity
        var c1 = row.insertCell(0);
        var quantityRow = myItem.childNodes[7];
        c1.innerHTML = quantityRow.childNodes[3].innerText;
        c1.setAttribute("name", "qtyRow");
        

        // Name
        var c2 = row.insertCell(1);
        c2.innerHTML = myItem.childNodes[3].innerText;
        c2.setAttribute("name", "itemRow");

        // Price
        var c3 = row.insertCell(2);
        c3.innerHTML = quantityRow.childNodes[7].innerText;
        c3.setAttribute("name", "priceRow");

        //Button
        var c4 = row.insertCell(3);
        c4.innerHTML = "<i class='far fa-trash-alt'></i>";
        c4.setAttribute("name", "dropRow");
        c4.setAttribute("id", "remItemIcon");
        c4.setAttribute("onclick", "removeRow(this)");

        // Change the attribute of the item selected
        myItem.setAttribute("name", "itemToSelect");

        // Increment so the other item is inserted in the other row
        i++;
    }

    // Updates the total price of the products
    updateTotPrice(myOrders);

}

// Removes the clicked item from "My Orders" table
function removeFromOrder(myItem){

    var myOrders = document.getElementById("ordersTable");

    var rows = myOrders.getElementsByTagName("tr");
    var itemName = myItem.childNodes[3].innerText;

    // Checking if the item is already put in the table
    for(var i = 0; i < rows.length; i++){
        if(rows[i].getAttribute("name") == itemName){
            myOrders.deleteRow(i);
            myItem.setAttribute("name", "itemToSelect");
        }
    }

    // Updates the total price of the products
    updateTotPrice(myOrders);
    saveSelItems(myOrders);
}

// Decreases the quantity of a product
function decreaseQty(){
    var clickedBtn = document.getElementsByName("decrease")[0];
    var currentVal = clickedBtn.parentElement.childNodes[3];

    if(currentVal.innerText > 1){
        currentVal.innerText = --currentVal.innerText;
        var newPrice = changePrice(clickedBtn.parentElement.childNodes[7], currentVal.innerText);
        updateTableData(clickedBtn.parentElement.parentElement.childNodes[3], currentVal.innerText, newPrice);
    }
    clickedBtn.setAttribute("name", "minus");

    
    // Updates the total price of the products
    updateTotPrice(document.getElementById("ordersTable"));
    saveSelItems(document.getElementById("ordersTable"));
}

// Increase the quantity of a product
function increaseQty(){
    var clickedBtn = document.getElementsByName("increase")[0];
    var currentVal = clickedBtn.parentElement.childNodes[3];

    currentVal.innerText = ++currentVal.innerText;
    var newPrice = changePrice(clickedBtn.parentElement.childNodes[7], currentVal.innerText);
    updateTableData(clickedBtn.parentElement.parentElement.childNodes[3],  currentVal.innerText, newPrice);
    clickedBtn.setAttribute("name", "plus");

    
    // Updates the total price of the products
    updateTotPrice(document.getElementById("ordersTable"));
    saveSelItems(document.getElementById("ordersTable"));
}

//Change the price according to the quantity
function changePrice(currentPrice, currentQty){
    currentPrice.innerHTML = currentPrice.getAttribute("name") * currentQty;
    return currentPrice.innerHTML;
}

// Updates the table data incase the user changes something after
function updateTableData(itemName, newQty, newPrice){
    var myTable = document.getElementById("ordersTable");
    var rows = myTable.getElementsByTagName("tr");

    for(var i = 0; i < rows.length; i++){
        if(rows[i].getAttribute('name') == itemName.innerText){
            rows[i].childNodes[0].innerHTML = newQty;
            rows[i].childNodes[2].innerHTML = newPrice;
        }
    }
}

// Calculates and displays the toal price in the "My Orders" table
function updateTotPrice(myTable){
    if(myTable.hasChildNodes()){
        var rows = myTable.getElementsByTagName("tr");
        var priceContainer = myTable.parentElement.parentElement.childNodes[5].childNodes[1];
        var price = 0;

        for(var i = 0; i < rows.length; i++){
            price += rows[i].childNodes[0].innerHTML * rows[i].childNodes[2].innerHTML;
        }
        priceContainer.innerHTML = price;
    }
}

// Deletes an item from the "My Orders" table when clicking the icon
function removeRow(myRow){

    // Removes the green circle from the items that were deselected
    var myMenu = document.getElementById("menu");

    var selectedItems = myMenu.getElementsByClassName("selected");

    for(var i = 0; i < selectedItems.length; i++){
        if(selectedItems[i].childNodes[3].innerHTML == myRow.parentElement.childNodes[1].innerHTML){
            selectedItems[i].childNodes[9].setAttribute("id", "displayParagraph");
            selectedItems[i].setAttribute("class", "unselected");
        }
    }

    var i = myRow.parentNode.rowIndex;
    document.getElementById("ordersTable").deleteRow(i);

    // Updates the total price of the products
    updateTotPrice(document.getElementById("ordersTable"));
    saveSelItems(document.getElementById("ordersTable"));
}

// Goes to the my orders page with all the items the user has selected
function goToOrdersPage(){
    sessionStorage.clear();

    var myTable = document.getElementById("ordersTable");
    var myRows = myTable.getElementsByTagName("tbody")[0].getElementsByTagName("tr");


    var rowLen = myRows.length;

    if(!(myRows === undefined)){
        for(var i = 0; i < rowLen; i++){
            var str = "row" + i;
            var row = myRows[i].innerHTML;
            sessionStorage.setItem(str, row);
        }
        window.location = "myOrders.php";
    }
}

// ERROR IN THIS PART OF THE CODE - WHEN SWITCHING PAGES YOU DO NOT SAVE THE ORDERS
// Saves the user selected items when switching pages
function saveSelItems(myTable){
    
    if(myTable.getElementsByTagName("tr").length > 0){
        var myRows = myTable.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
        var rowLen = myRows.length;
    }
    
    // Clear the previews stored variables
    sessionStorage.clear();
    

    if(rowLen > 0){
        for(var i = 0; i < rowLen; i++){
            var str = "row" + i;
            var row = myRows[i].innerHTML;
            sessionStorage.setItem(str, row);
        }
    }
}

// Fills table with the items the  has selected when switching pages
function writeToOrders(){

    var myTable = document.getElementById("ordersTable");

    // Adding new elements
    if(sessionStorage.length > 0){
        var rowsToInsers = "";
        for(var i = 0; i < sessionStorage.length; i++){
            var row = "row"+i;
            var data = sessionStorage.getItem(row);
            if(!(data === undefined)){
                rowsToInsers += "<tr>" +data+ "</tr>";
            }
        }
        myTable.innerHTML = rowsToInsers;
    }

    updateTotPrice(myTable);
    markAlreadySelectedItems(myTable);
}

// Marks the items the user has already selected
function markAlreadySelectedItems(myTable){
    
    if(myTable.getElementsByTagName("tr").length > 0){
        var myRows = myTable.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
        var myMenu = document.getElementById("menu");
        var myItems = myMenu.getElementsByClassName("unselected");
        var itemName;

        for(var i = 0; i < myRows.length; i++){
            itemName = myRows[i].childNodes[1].innerHTML;

            for(var j = 0; j < myItems.length; j++){
                var myTD = myItems[j];
                if(myTD.childNodes[3].innerHTML == itemName){
                    if(myTD.getAttribute("class") == "unselected"){
                        myTD.setAttribute("class", "selected");
                        myTD.childNodes[9].setAttribute("id", "activeDisplayParagraph");
                        myTD.setAttribute("name", "itemToSelect");
                    }else{
                        myTD.setAttribute("class", "unselected");
                        removeFromOrder(myTD);
                        myTD.childNodes[9].setAttribute("id", "displayParagraph");
                    }
                    // Because of unique item names
                    j = myItems.length;
                }
            }
        }
    }
}