function abrirMenu() {
            document.getElementById('menuLateral').classList.add('ativo');
            document.getElementById('fundoEscuro').classList.add('ativo');
        }

        function fecharMenu() {
            document.getElementById('menuLateral').classList.remove('ativo');
            document.getElementById('fundoEscuro').classList.remove('ativo');
        }

let slideAtual = 0;
const slides = document.querySelectorAll('.slide');
const pontos = document.querySelectorAll('.ponto');

function mostrarSlide(indice) {
  if (indice >= slides.length) slideAtual = 0;
  else if (indice < 0) slideAtual = slides.length - 1;
  else slideAtual = indice;

  slides.forEach(slide => slide.classList.remove('ativo'));
  pontos.forEach(ponto => ponto.classList.remove('ativo'));

  slides[slideAtual].classList.add('ativo');
  pontos[slideAtual].classList.add('ativo');
}

function mudarSlide(direcao) {
  mostrarSlide(slideAtual + direcao);
  reiniciarAutoPlay();
}

function irParaSlide(indice) {
  mostrarSlide(indice);
  reiniciarAutoPlay();
}

let autoPlay = setInterval(() => {
  mudarSlide(1);
}, 5000);

function reiniciarAutoPlay() {
  clearInterval(autoPlay);
  autoPlay = setInterval(() => {
    mudarSlide(1);
  }, 7000);
}

function previewImagem(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

function atualizarPreviaFoto(input) {
    if (input.files && input.files[0]) {
        const leitor = new FileReader();
        
        leitor.onload = function(e) {
            document.getElementById('imagemPrevia').src = e.target.result;
        }
        
        leitor.readAsDataURL(input.files[0]);
    }
}

function mascaraEmail(input) {
    let valor = input.value.replace(/\s+/g, "").toLowerCase();
    
    valor = valor.replace(/[^a-z0-9@._-]/g, "");
    
    const partes = valor.split("@");
    if (partes.length > 2) {
        valor = partes[0] + "@" + partes.slice(1).join("");
    }
    
    input.value = valor;
}

// Máscara para Telefone / Celular
function mascaraTelefone(input) {
    let valor = input.value.replace(/\D/g, ""); 
    
    valor = valor.substring(0, 11);

    if (valor.length > 10) {
  
        valor = valor.replace(/^(\d{2})(\d{5})(\d{4})$/, "($1) $2-$3");
    } else if (valor.length > 6) {

        valor = valor.replace(/^(\d{2})(\d{4})(\d{0,4})$/, "($1) $2-$3");
    } else if (valor.length > 2) {

        valor = valor.replace(/^(\d{2})(\d{0,5})$/, "($1) $2");
    }
    
    input.value = valor;
}

// animação de botao thema dark

document.addEventListener("DOMContentLoaded", () => {

    const btnToggle = document.getElementById("btn-tema-toggle");
    const container = document.getElementById("lottie-container");
    const htmlElement = document.documentElement;

    if (!btnToggle || !container) return;

    // =========================================================
    // 1. DEFINIÇÃO DO TEMA INICIAL
    // =========================================================

    const temaSalvo = localStorage.getItem("tema_preferido");
    const prefereEscuro =
        window.matchMedia("(prefers-color-scheme: dark)").matches;

    const temaInicial =
        temaSalvo || (prefereEscuro ? "dark" : "light");

    htmlElement.setAttribute("data-theme", temaInicial);

    // =========================================================
    // 2. CARREGA A ANIMAÇÃO
    // =========================================================

    const prefixo = window.prefixoSite || "";

    const anim = lottie.loadAnimation({
        container: container,
        renderer: "svg",
        loop: false,
        autoplay: false,
        path: `${prefixo}theme-toggle3.json`
    });

    // =========================================================
    // 3. FRAMES IMPORTANTES DA ANIMAÇÃO
    // =========================================================

    /*
        Pela estrutura do JSON:

        30  = estado claro
        115 = estado escuro

        A animação entre eles é:
        30 → 115 = Dia → Noite
        115 → 30 = Noite → Dia
    */

    const FRAME_DIA = 30;
    const FRAME_NOITE = 115;

    // =========================================================
    // 4. POSICIONA O BOTÃO NO ESTADO CORRETO AO CARREGAR
    // =========================================================

    function fixarQuadro() {

        if (!anim.totalFrames) return;

        const tema =
            htmlElement.getAttribute("data-theme");

        if (tema === "dark") {
            anim.goToAndStop(FRAME_NOITE, true);
        } else {
            anim.goToAndStop(FRAME_DIA, true);
        }
    }

    anim.addEventListener("DOMLoaded", fixarQuadro);
    anim.addEventListener("data_ready", fixarQuadro);

    // =========================================================
    // 5. CONTROLE DA ANIMAÇÃO MANUAL
    // =========================================================

    let executando = false;
    let animFrameId = null;

    function animarManual(
        frameInicio,
        frameFim,
        duracaoMs,
        callbackConclusao
    ) {

        if (animFrameId) {
            cancelAnimationFrame(animFrameId);
        }

        const tempoInicio = performance.now();

        function renderizar(tempoAtual) {

            const decorrido =
                tempoAtual - tempoInicio;

            let progresso =
                decorrido / duracaoMs;

            if (progresso >= 1) {
                progresso = 1;
            }

            const frameAtual =
                frameInicio +
                (frameFim - frameInicio) *
                progresso;

            anim.goToAndStop(frameAtual, true);

            if (progresso < 1) {

                animFrameId =
                    requestAnimationFrame(renderizar);

            } else {

                // Garante que o último frame
                // seja exatamente o estado desejado
                anim.goToAndStop(frameFim, true);

                animFrameId = null;

                if (callbackConclusao) {
                    callbackConclusao();
                }
            }
        }

        animFrameId =
            requestAnimationFrame(renderizar);
    }

    // =========================================================
    // 6. CLIQUE DO BOTÃO
    // =========================================================

    btnToggle.addEventListener("click", () => {

        if (executando || !anim.totalFrames) {
            return;
        }

        executando = true;

        const temaAtual =
            htmlElement.getAttribute("data-theme");

        const novoTema =
            temaAtual === "dark"
                ? "light"
                : "dark";

        // Muda o tema da página imediatamente
        htmlElement.setAttribute(
            "data-theme",
            novoTema
        );

        localStorage.setItem(
            "tema_preferido",
            novoTema
        );

        const duracao = 1000;

        // =====================================================
        // DIA → NOITE
        // =====================================================

        if (novoTema === "dark") {

            animarManual(
                FRAME_DIA,
                FRAME_NOITE,
                duracao,
                () => {
                    executando = false;
                }
            );

        }

        // =====================================================
        // NOITE → DIA
        // =====================================================

        else {

            animarManual(
                FRAME_NOITE,
                FRAME_DIA,
                duracao,
                () => {
                    executando = false;
                }
            );
        }
    });
});