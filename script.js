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