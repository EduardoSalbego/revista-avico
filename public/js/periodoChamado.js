function add() {
    var table = document.getElementById("view-table");
    var row = table.insertRow(1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);

    cell1.innerHTML = '<td><input type="date" name="dataInicio[]" class="form-control" style="border-radius: 0% !important;border-color: transparent !important; border-bottom: solid 2px black !important;" required></td>';
    cell2.innerHTML = '<td><input type="date" name="dataFinal[]" class="form-control" style="border-radius: 0% !important; border-color: transparent !important; border-bottom: solid 2px black !important;" required></td>';
    cell3.innerHTML = '<td><input type="date" name="dataDivulgacao[]" class="form-control" style="border-radius: 0% !important; border-color: transparent !important;  border-bottom: solid 2px black !important;" required></td>';
    cell4.innerHTML = '<td><input type="date" name="dataMaximaAvaliacao[]" class="form-control" style="border-radius: 0% !important; border-color: transparent !important; border-bottom: solid 2px black !important;" required></td>';
}

function del() {
    var qtdRows = document.getElementById("view-table").rows.length - 1;
    if(qtdRows > 1)
        document.getElementById("view-table").deleteRow(1);
} 
