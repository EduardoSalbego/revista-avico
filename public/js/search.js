var limite = 20;

function newAuthor(id, nome){

    html = `<li id="selected-author-`+ id +`" class="selected-author ms-2 list-group-item-sm">
                <input type="text" name="autor_id[]" value="` + id + `" id="autor_id" hidden>            
                <span class="ms-3" id="autor-` + id + `">` + nome + `</span>
                <button onclick="removeAuthor(` + id + `)" type="button" id="selected-icon" class="btn">
                        <i class="fa fa-times fa-1x mb-1" style="transition:none !important;" aria-hidden="true"></i>            
                </button>
            </li> 
            `;

    document.getElementById('author').innerHTML += html;
}


function add() {
    var table = document.getElementById("artigos-table");
    if((table.rows.length - 1) < limite){
        var row = table.insertRow(1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);   
        cell1.innerHTML = '<input name="artigo[]" style="border-style:none;" class="form-control form-control-sm" type="file" accept="application/pdf" required>';
        cell2.innerHTML = '<input name="tituloArtigo[]" style="border-radius: 0% !important;border-color: transparent !important;border-bottom: solid 2px black !important;" class="form-control form-control-sm" type="text" required>';
    }
}

function del() {
    var qtdRows = document.getElementById("artigos-table").rows.length - 1;
    if(qtdRows > 1)
        document.getElementById("artigos-table").deleteRow(1);
} 



function search(str) {

    if (str.length <= 0) {
        document.getElementById('revista').innerHTML = "";
        return;
    }

    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
        document.getElementById("revista").innerHTML=this.responseText;
        }
    }
    xmlhttp.open("GET","/search?q="+str,true);
    xmlhttp.send();
}


function searchAuthor(str) {

    if (str.length <= 0) {
        document.getElementById('autor').innerHTML = "";
        return;
    }

    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
        document.getElementById("autor").innerHTML=this.responseText;
        }
    }
    xmlhttp.open("GET","/search/autor?q="+str,true);
    xmlhttp.send();
}
  

function select(id, qtd){
    var revista = document.getElementById(id);
    limite = qtd;
    document.getElementById("revista_id").value = id;
    document.getElementById("pesq").value = revista.innerHTML;
    document.getElementById('revista').innerHTML = "";

}

function selectAuthor(id){
    var autor = document.getElementById(id);
    newAuthor(id, autor.innerHTML);
    document.getElementById("autores").value = "";
    document.getElementById('autor').innerHTML = "";

}

function removeAuthor(id){
    var elem = document.getElementById("selected-author-" + id);
    elem.parentNode.removeChild(elem);
}



