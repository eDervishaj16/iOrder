var index;
function indexRow(x) {
    index = x.rowIndex;
    console.log("Row index="+index);
}
function deleteR() {
    var rows = document.getElementsByClassName("rows");
    for(var i=0; i<rows.length; i++){
        if(i==index-1){
            var id = rows[i].getElementsByTagName("td")[0].innerHTML;
            console.log("id "+id);
            var order = rows[i].getElementsByTagName("td")[1].innerHTML;
            var price = rows[i].getElementsByTagName("td")[2].innerHTML;
            var client = rows[i].getElementsByTagName("td")[3].innerHTML;
            var address1 = rows[i].getElementsByTagName("td")[4].innerHTML;
            var address2 = rows[i].getElementsByTagName("td")[5].innerHTML;
            jQuery.post("delete_insert_orders.php",
                {
                    id: id, order: order, price: price, client: client, address1: address1, address2: address2
                });

        }
    }
    document.getElementsByTagName("table")[0].deleteRow(index);
}