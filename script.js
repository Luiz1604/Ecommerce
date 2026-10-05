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