function searchEditor(str) {

    if (str.length <= 0) {
        document.getElementById('editor').innerHTML = "";
        return;
    }

    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
        document.getElementById("editor").innerHTML=this.responseText;
        }
    }
    xmlhttp.open("GET","/search/editor?q="+str,true);
    xmlhttp.send();
}

function selectEditor(id){
    var revista = document.getElementById(id);
    document.getElementById("editor_id").value = id;
    document.getElementById("editor_input").value = revista.innerHTML;
    document.getElementById('editor').innerHTML = "";

}