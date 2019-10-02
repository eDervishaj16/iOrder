var selected = false;
var i = 0;

function alterCell(x){
    var prevText = x.innerText;
    if(i%2!=0) {
        selected = true;
        i++;
    }
    else {
        selected = false;
        i++;
    }
    if(selected == false) {
        if (x.hasChildNodes()) {
            x.removeChild(x.firstChild);
        }
        var inputField = document.createElement("input");
        inputField.setAttribute("type", "text");
        inputField.id = "inputField";
        inputField.placeholder = prevText;
        inputField.autofocus = true;
        inputField.value = prevText;
        x.appendChild(inputField);

        var saveBtn = document.createElement("Button");
        saveBtn.id = "save";
        saveBtn.style.backgroundColor = '#3b4f9d';
        saveBtn.style.color = "white";
        saveBtn.textContent = "Save";
        saveBtn.setAttribute("onclick", "saveText(this.parentNode, document.getElementById('inputField').value, this.parentNode.getAttribute('name'))");
        var cancelBtn = document.createElement("Button");
        cancelBtn.textContent = "Cancel";
        cancelBtn.setAttribute("onclick", "cancel(this.parentNode, document.getElementById('inputField').placeholder)");
        cancelBtn.id = "cancel";
        cancelBtn.style.backgroundColor = '#3b4f9d';
        cancelBtn.style.color = "white";
        var newLine = document.createElement("br");
        x.appendChild(newLine);
        x.appendChild(saveBtn);
        x.appendChild(cancelBtn);
    }
}

function saveText(td, newText, tdType) {
    console.log("name "+tdType);
    if(tdType == "user"){
        var reg = /[0-9a-zA-Z_.]{4,}$/;
        if(newText.match(reg)){
            while (td.hasChildNodes()) {
                td.removeChild(td.lastChild);
            }
            var text = document.createTextNode(newText);
            td.appendChild(text);
        }
        else{
            alert("Invalid username format");
        }

    }
    if(tdType == "password"){
        var reg = /^.*(?=.{6,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/;
        if(newText.match(reg)){
            while (td.hasChildNodes()) {
                td.removeChild(td.lastChild);
            }
            var text = document.createTextNode(newText);
            td.appendChild(text);
        }
        else {
            alert("Invalid password format");
        }
    }
    if(tdType == "lvl"){
        if(!isNaN(parseInt(newText))){
            while (td.hasChildNodes()) {
                td.removeChild(td.lastChild);
            }
            var text = document.createTextNode(newText);
            td.appendChild(text);
        }
        else {
            alert("Level must be a number");
        }
    }
    if(tdType == "name"){
        var reg = /[a-zA-Z]{2,}$/;
        if(newText.match(reg)){
            while (td.hasChildNodes()) {
                td.removeChild(td.lastChild);
            }
            var text = document.createTextNode(newText);
            td.appendChild(text);
            selected = false;
            console.log(selected);
        }
        else{
            alert("Invalid name format");
            selected = true;
            console.log(selected);
        }
    }
    if(tdType == "surname"){
        var reg = /[a-zA-Z]{2,}$/;
        if(newText.match(reg)){
            while (td.hasChildNodes()) {
                td.removeChild(td.lastChild);
            }
            var text = document.createTextNode(newText);
            td.appendChild(text);
            selected = false;
            console.log(selected);
        }
        else {
            alert("Invalid surname format");
            selected = true;
            console.log(selected);
        }
    }
    if(tdType == "city"){
        var reg = /[a-zA-Z]{2,}$/;
        if(newText.match(reg)){
            while (td.hasChildNodes()) {
                td.removeChild(td.lastChild);
            }
            var text = document.createTextNode(newText);
            td.appendChild(text);
            selected = false;
            console.log(selected);
        }
        else {
            alert("Invalid city name format");
            selected = true;
            console.log(selected);
        }
    }
    if(tdType == "add1" || tdType == 'add2'){
        var reg = /[a-zA-Z]{2,}$/;
        if(newText.match(reg)){
            while (td.hasChildNodes()) {
                td.removeChild(td.lastChild);
            }
            var text = document.createTextNode(newText);
            td.appendChild(text);
            selected = false;
            console.log(selected);
        }
        else {
            alert("Invalid address format");
            selected = true;
            console.log(selected);
        }
    }
    if(tdType == "phoneNr"){
        if(!isNaN(parseInt(newText))){
            while (td.hasChildNodes()) {
                td.removeChild(td.lastChild);
            }
            var text = document.createTextNode(newText);
            td.appendChild(text);
            selected = false;
            console.log(selected);
        }
        else {
            alert("The telephone number should have only numbers");
            selected = true;
            console.log(selected);
        }
    }
}

function cancel(td, prevText) {
    while(td.hasChildNodes()){
        td.removeChild(td.lastChild);
    }
    var text = document.createTextNode(prevText);
    td.appendChild(text);

}
