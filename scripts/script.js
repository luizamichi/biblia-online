// Tema do sistema
const temaEscuro = globalThis.matchMedia("(prefers-color-scheme: dark)").matches;

// Tratador de exceções global
globalThis.onerror = () => true;

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
