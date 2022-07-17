// Botões de salvar e cancelar do formulário de modificação
const botaoSalvar = $("button[id='salvar']");
const botaoCancelar = $("button[id='cancelar']");

// Ícone do menu de pesquisa e campo de entrada da pesquisa
const iconeProcurar = $("i[id='procurar']");
const entradaPesquisa = $("input[name='consulta']");

// Formulário de consulta e de modificação
const formularioConsulta = $("form[method='get']");
const formularioAlteracao = $("form[method='put']");

// Caixa de mensagem ao usuário e caixa de seleção do formulário de modificação
const divisaoMensagem = $("div[id='alerta']");
const caixaSelecao = $("input[id='termos']");

// Título da página para inserir nos alertas
const tituloPagina = $("div[id='titulo']");

// Copia os dados do formulário para a constante, caso precise resetar o formulário
let dadosFormulario = formularioAlteracao.serializeArray();

// Botão para fechar a caixa de mensagem e ícone do cabeçalho do alerta
const botaoMensagem = $("i[id='botao-alerta']");
const iconeMensagem = $("i[id='icone-alerta']");

// Botões de tema, aumentar e diminuir fonte
const botaoTema = $("a[id='mudar-tema']");
const botaoAumentaFonte = $("a[id='aumentar-fonte']");
const botaoDiminuiFonte = $("a[id='diminuir-fonte']");

// Botões de autenticação
const botaoAutenticar = $("a[id='autenticar']");
const botaoDesautenticar = $("a[id='desautenticar']");
const botaoLogar = $("div[id='logar']");
const botaoFechar = $("div[id='fechar']");

// Modal de autenticação
const modalAutenticacao = $("div[id='modal-autenticacao']");
const formularioAutenticacao = $("form[id='formulario-login']");
const entradaLogin = $("input[id='username']");
const entradaSenha = $("input[id='password']");
const entradaLogout = $("input[id='logout']");

// Tema do sistema
const temaEscuro = globalThis.matchMedia("(prefers-color-scheme: dark)").matches;

// Tratador de exceções global
globalThis.onerror = () => true;

// Fecha/oculta a caixa de mensagem
botaoMensagem.click(function() {
	divisaoMensagem.hide();
});


// Ajusta o tamanho da fonte ao iniciar a página
let tamanhoFonte = localStorage.getItem("fonte");
if(tamanhoFonte) {
	$("p").css("font-size", tamanhoFonte + "px");
}

// Tema da página
if(localStorage.getItem("tema") !== null) {
	if(localStorage.getItem("tema") === "escuro") {
		$("link[id='tema-escuro']").attr("disabled", false);
		$("button").addClass("inverted");
	}
	else {
		$("link[id='tema-escuro']").attr("disabled", true);
	}
}
else {
	$("link[id='tema-escuro']").attr("disabled", !temaEscuro);
}

// Muda o tema da página
botaoTema.click(function() {
	if((localStorage.getItem("tema") === null && temaEscuro) || localStorage.getItem("tema") === "escuro") {
		localStorage.setItem("tema", "claro");
		$("link[id='tema-escuro']").attr("disabled", true);
		$("button").removeClass("inverted");
	}
	else {
		localStorage.setItem("tema", "escuro");
		$("link[id='tema-escuro']").attr("disabled", false);
		$("button").addClass("inverted");
	}
});

// Aumenta o tamanho da fonte da página ao clicar no botão
botaoAumentaFonte.click(function() {
	// Aumenta a fonte em 20%
	let tamanhoFonteAtual = Number.parseFloat($("p").css("font-size"));
	let novoTamanhoFonte = tamanhoFonteAtual * 1.2;
	$("p").css("font-size", novoTamanhoFonte + "px");
	localStorage.setItem("fonte", novoTamanhoFonte);
});

// Diminui o tamanho da fonte da página ao clicar no botão
botaoDiminuiFonte.click(function() {
	// Diminui a fonte em 20%
	let tamanhoFonteAtual = Number.parseFloat($("p").css("font-size"));
	let novoTamanhoFonte = tamanhoFonteAtual * 0.8;
	$("p").css("font-size", novoTamanhoFonte + "px");
	localStorage.setItem("fonte", novoTamanhoFonte);
});

// Altera a cor das tags "J" e dos números dos versículos
$("j").css("color", "#910091");
$(".versiculo").css("color", "#999");

// Habilita o menu suspenso
$(".dropdown.ui").dropdown();

// Desabilita o botão de salvar a modificação e a caixa de mensagem
botaoSalvar.attr("disabled", true);
divisaoMensagem.css("display", "none");

// Desabilita e habilita o botão de salvar a modificação ao clicar na caixa de seleção
caixaSelecao.change(function() {
	if($(this).is(":checked")) {
		botaoSalvar.attr("disabled", false);
	}
	else {
		botaoSalvar.attr("disabled", true);
	}
});

// Altera o título da página
document.title += " - " + (tituloPagina.data("title")
? tituloPagina.data("title") + " (" + tituloPagina.text() + ")"
: tituloPagina.text());

// Coloca os dados originais no formulário
botaoCancelar.click(function() {
	let index = 0;
	dadosFormulario.forEach(function(objeto) {
		if($("[name='" + objeto.name + "']").length > 1) {
			$("[name='" + objeto.name + "']").eq(index).val(objeto.value);
			index++;
		}
		else {
			$("[name='" + objeto.name + "']").val(objeto.value);
		}
	});
});

// Envia os dados para a API salvar as modificações
botaoSalvar.click(function(evento) {
	evento.preventDefault();
	if(formularioAlteracao.length !== 0) {
		if(caixaSelecao.is(":checked")) {
			let sucesso = false;

			$.ajax({
				type: "url",
				method: "put",
				url: formularioAlteracao.attr("action"),
				data: formularioAlteracao.serialize(),
				dataType: "json",
				beforeSend: function() {
					sucesso = false;
					formularioAlteracao.addClass("loading");
				},
				complete: function() {
					formularioAlteracao.removeClass("loading");
					divisaoMensagem.css("display", "");
				},
				success: function(data) {
					sucesso = data.sucesso;
					if(data.sucesso) {
						divisaoMensagem.addClass("green").removeClass("blue red yellow");
						iconeMensagem.addClass("paper plane").removeClass("exclamation info times shield alternate search");
						divisaoMensagem.find("span[id='cabecalho-alerta']").text(tituloPagina.text() + " modificado(a) com sucesso.");
						dadosFormulario = formularioAlteracao.serializeArray();
					}
					else {
						divisaoMensagem.addClass("red").removeClass("blue green yellow");
						iconeMensagem.addClass("times").removeClass("exclamation info paper plane shield alternate search");
						divisaoMensagem.find("span[id='cabecalho-alerta']").text(tituloPagina.text() + " não pode ser modificado(a).");
					}
					divisaoMensagem.children("p[id='texto-alerta']").text(data.mensagem);
				},
				error: function(response) {
					divisaoMensagem.addClass("red").removeClass("blue green yellow");
					iconeMensagem.addClass("times").removeClass("exclamation info paper plane shield alternate search");
					divisaoMensagem.find("span[id='cabecalho-alerta']").text(tituloPagina.text() + " não pode ser modificado(a).");
					divisaoMensagem.children("p[id='texto-alerta']").text(response?.responseJSON?.mensagem || "Houve uma falha ao realizar a modificação.");
				}
			});
			return sucesso;
		}
		else {
			divisaoMensagem.css("display", "");
			divisaoMensagem.addClass("yellow").removeClass("blue green red");
			iconeMensagem.addClass("exclamation").removeClass("info paper plane times shield alternate search");
			divisaoMensagem.find("span[id='cabecalho-alerta']").text(tituloPagina.text() + " não pode ser modificado(a).");
			divisaoMensagem.children("p[id='texto-alerta']").text("Confirme o termo de modificação para efetuar a modificação.");
			return false;
		}
	}
	else {
		return false;
	}
});

// Envia a pesquisa para API consultar os autores, testamentos, versões, versículos
let enviaPesquisa = function(evento) {
	evento.preventDefault();
	entradaPesquisa.val(entradaPesquisa.val().toUpperCase());
	if(formularioConsulta.length !== 0 && entradaPesquisa.length !== 0 && entradaPesquisa.val().length > 0) {
		$.ajax({
			type: "url",
			method: "get",
			url: formularioConsulta.attr("action"),
			data: formularioConsulta.serialize(),
			dataType: "json",
			beforeSend: function() {
				entradaPesquisa.attr("disabled", true);
			},
			complete: function() {
				entradaPesquisa.attr("disabled", false);
				divisaoMensagem.css("display", "");
			},
			success: function(data) {
				let sucesso = data.sucesso;
				if(sucesso) {
					divisaoMensagem.addClass("green").removeClass("blue red yellow");
					iconeMensagem.addClass("search").removeClass("exclamation info times shield alternate");
					divisaoMensagem.find("span[id='cabecalho-alerta']").text("Pesquisa realizada com sucesso.");
				}
				else {
					divisaoMensagem.addClass("red").removeClass("blue green yellow");
					iconeMensagem.addClass("times").removeClass("exclamation info paper plane shield alternate search");
					divisaoMensagem.find("span[id='cabecalho-alerta']").text("Pesquisa realizada com sucesso.");
				}
				divisaoMensagem.children("p[id='texto-alerta']").text(data.mensagem);
				divisaoMensagem.children("a[id='link-alerta']").attr("href", data.resultado.abreviado).show();
			},
			error: function(response) {
				divisaoMensagem.addClass("red").removeClass("blue green yellow");
				iconeMensagem.addClass("times").removeClass("exclamation info paper plane shield alternate search");
				divisaoMensagem.find("span[id='cabecalho-alerta']").text("Não foi possível fazer a pesquisa.");
				divisaoMensagem.children("p[id='texto-alerta']").text(response?.responseJSON?.mensagem || "Houve uma falha ao realizar a consulta.");
				divisaoMensagem.children("a[id='link-alerta']").hide();
			}
		});
	}
}

// Envia a pesquisa ao clicar no botão
iconeProcurar.click(function(evento) {
	enviaPesquisa(evento);
});

// Envia a pesquisa ao submeter
formularioConsulta.submit(function(evento) {
	enviaPesquisa(evento);
});

// Envia a pesquisa ao clicar "Enter"
entradaPesquisa.keyup(function(evento) {
	if(evento.keyCode === 13) {
		enviaPesquisa(evento);
	}
});

// Abre o modal de login
botaoAutenticar.click(function() {
	modalAutenticacao.modal("show");
});

// Autentica o usuário
botaoLogar.click(function() {
	if(formularioAutenticacao.length !== 0 && entradaLogin.length !== 0 && entradaLogin.val().length > 0
		&& entradaSenha.length !== 0 && entradaSenha.val().length > 0) {
		entradaLogout.val("0");
		$.ajax({
			type: "url",
			method: "post",
			url: formularioAutenticacao.attr("action"),
			data: formularioAutenticacao.serialize(),
			dataType: "json",
			beforeSend: function() {
				entradaLogin.attr("disabled", true);
				entradaSenha.attr("disabled", true);
			},
			complete: function() {
				entradaLogin.attr("disabled", false);
				entradaSenha.attr("disabled", false);
				divisaoMensagem.show();
			},
			success: function(data) {
				let sucesso = data.sucesso;
				if(sucesso) {
					divisaoMensagem.addClass("green").removeClass("blue red yellow");
					iconeMensagem.addClass("shield alternate").removeClass("exclamation info times search");
					divisaoMensagem.find("span[id='cabecalho-alerta']").text("Autenticação concluída.");
					botaoAutenticar.hide();
					botaoDesautenticar.show();
				}
				else {
					divisaoMensagem.addClass("red").removeClass("blue green yellow");
					iconeMensagem.addClass("times").removeClass("exclamation info paper plane shield alternate search");
					divisaoMensagem.find("span[id='cabecalho-alerta']").text("Falha na autenticação.");
				}
				divisaoMensagem.children("p[id='texto-alerta']").text(data.mensagem);
			},
			error: function(response) {
				divisaoMensagem.addClass("red").removeClass("blue green yellow");
				iconeMensagem.addClass("times").removeClass("exclamation info paper plane shield alternate search");
				divisaoMensagem.find("span[id='cabecalho-alerta']").text("Não foi possível fazer a autenticação.");
				divisaoMensagem.children("p[id='texto-alerta']").text(response?.responseJSON?.mensagem || "Houve uma falha ao realizar a autenticação.");
			}
		});
	}
});

// Desautentica o usuário
botaoDesautenticar.click(function() {
	if(formularioAutenticacao.length !== 0) {
		entradaLogout.val("1");
		$.ajax({
			type: "url",
			method: "post",
			url: formularioAutenticacao.attr("action"),
			data: formularioAutenticacao.serialize(),
			dataType: "json",
			complete: function() {
				entradaLogin.attr("disabled", false);
				entradaSenha.attr("disabled", false);
				divisaoMensagem.show();
			},
			success: function(data) {
				let sucesso = data.sucesso;
				if(!sucesso) {
					divisaoMensagem.addClass("green").removeClass("blue red yellow");
					iconeMensagem.addClass("shield alternate").removeClass("exclamation info times search");
					divisaoMensagem.find("span[id='cabecalho-alerta']").text("Desautenticação concluída.");
					botaoDesautenticar.hide();
					botaoAutenticar.show();
					divisaoMensagem.children("p[id='texto-alerta']").text("Usuário desauntenticado com sucesso.");
				}
				else {
					divisaoMensagem.addClass("red").removeClass("blue green yellow");
					iconeMensagem.addClass("times").removeClass("exclamation info paper plane shield alternate search");
					divisaoMensagem.find("span[id='cabecalho-alerta']").text("Falha na desautenticação.");
					divisaoMensagem.children("p[id='texto-alerta']").text("Não foi possível desautenticar do sistema.");
				}
			},
			error: function(response) {
				divisaoMensagem.addClass("red").removeClass("blue green yellow");
				iconeMensagem.addClass("times").removeClass("exclamation info paper plane shield alternate search");
				divisaoMensagem.find("span[id='cabecalho-alerta']").text("Não foi possível fazer a desautenticação.");
				divisaoMensagem.children("p[id='texto-alerta']").text(response?.responseJSON?.mensagem || "Houve uma falha ao realizar a desautenticação.");
			}
		});
	}
});
