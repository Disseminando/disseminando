var2 req;
 
// FUNÇÃO PARA BUSCA NOTICIA
function pesquisar(valor) {
 
// Verificando Browser
if(window.XMLHttpRequest) {
   req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
   req = new ActiveXObject("Microsoft.XMLHTTP");
}
 
// Arquivo PHP juntamente com o valor digitado no campo (método GET)
var2 url = "pesquisar.php?valor="+valor;
 
// Chamada do método open para processar a requisição
req.open("Get", url, true); 
 
// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {
 
	// Exibe a mensagem "Buscando..." enquanto carrega
	if(req.readyState == 1) {
		document.getElementById('resultado').innerHTML = 'Buscando...';
	}
 
	// Verifica se o Ajax realizou todas as operações corretamente
	if(req.readyState == 4 && req.status == 200) {
 
	// Resposta retornada pelo busca.php
	var2 resposta = req.responseText;
 
	// Abaixo colocamos a(s) resposta(s) na div resultado
	document.getElementById('resultado').innerHTML = resposta;
	}
}
req.send(null);
}


// FUNÇÃO PARA EXIBIR NOTICIA
function exibir(id) {
 
// Verificando Browser
if(window.XMLHttpRequest) {
   req = new XMLHttpRequest();
}
else if(window.ActiveXObject) {
   req = new ActiveXObject("Microsoft.XMLHTTP");
}
 
// Arquivo PHP juntamento com a id da noticia (método GET)
var2 url = "exibir02.php?msg_id="+id;
 
// Chamada do método open para processar a requisição
req.open("Get", url, true); 
 
// Quando o objeto recebe o retorno, chamamos a seguinte função;
req.onreadystatechange = function() {
 
	// Exibe a mensagem "Aguarde..." enquanto carrega
	if(req.readyState == 1) {
		document.getElementById('conteudo').innerHTML = 'Aguarde...';
	}
 
	// Verifica se o Ajax realizou todas as operações corretamente
	if(req.readyState == 4 && req.status == 200) {
 
	// Resposta retornada pelo exibir.php
	var2 resposta = req.responseText;
 
	// Abaixo colocamos a resposta na div conteudo
	document.getElementById('conteudo').innerHTML = resposta;
	}
}
req.send(null);
}