<?php
    include "util.php";
    include "_cabecalho.php";
?>

<main class="pagina-mvv pagina-faq">

    <h1 class="Tsimples">Perguntas Frequentes</h1>

    <hr class="sep2">

    <section class="caixapf">

        <article class="pf-card">
            <button class="pf-toggle-btn" type="button"
                aria-expanded="false" onclick="toggleCard(this)">
                <span class="material-symbols-outlined pf-icon">local_shipping</span>
                <span class="pf-pergunta">Onde pegar o produto?</span>
                <span class="material-symbols-outlined pf-seta">expand_more</span>
            </button>

            <div class="pf-content">
                <p>
                    Os produtos são retirados em uma sala indicada pela equipe.
                    Para realizar o pagamento, basta chamar um integrante, que
                    conferirá o valor total e fornecerá as instruções para o Pix.
                    Após a confirmação do pagamento, você receberá a orientação
                    para retirar seus produtos.
                </p>
            </div>
        </article>

        <article class="pf-card">
            <button class="pf-toggle-btn" type="button"
                aria-expanded="false" onclick="toggleCard(this)">
                <span class="material-symbols-outlined pf-icon">storefront</span>
                <span class="pf-pergunta">
                    A loja realmente vende produtos ou é apenas um projeto?
                </span>
                <span class="material-symbols-outlined pf-seta">expand_more</span>
            </button>

            <div class="pf-content">
                <p>
                    Sim! A KeyStyle realmente vende produtos. Nossa loja virtual
                    foi desenvolvida pelo grupo ao longo de vários meses.
                    Os produtos são preparados, gravados quando necessário,
                    embalados e verificados quanto à qualidade e às dimensões.
                    Como sua produção envolve custos, os preços incluem uma
                    margem necessária para a sustentabilidade do projeto.
                </p>
            </div>
        </article>

        <article class="pf-card">
            <button class="pf-toggle-btn" type="button"
                aria-expanded="false" onclick="toggleCard(this)">
                <span class="material-symbols-outlined pf-icon">lock_reset</span>
                <span class="pf-pergunta">
                    Esqueci minha senha. Como posso recuperá-la?
                </span>
                <span class="material-symbols-outlined pf-seta">expand_more</span>
            </button>

            <div class="pf-content">
                <p>
                    Clique em "Entrar" no cabeçalho da loja. Na página de login,
                    localize o link "Esqueceu a senha?". Informe seu e-mail e
                    siga as instruções recebidas para redefinir sua senha.
                    Depois, volte à página de login para acessar sua conta.
                </p>
            </div>
        </article>

        <article class="pf-card">
            <button class="pf-toggle-btn" type="button"
                aria-expanded="false" onclick="toggleCard(this)">
                <span class="material-symbols-outlined pf-icon">security</span>
                <span class="pf-pergunta">
                    O que acontece com minhas informações de login?
                </span>
                <span class="material-symbols-outlined pf-seta">expand_more</span>
            </button>

            <div class="pf-content">
                <p>
                    Suas informações são utilizadas para autenticar seu acesso
                    à KeyStyle. A senha é armazenada de forma protegida por hash
                    no sistema. Mantenha suas credenciais em segurança e evite
                    compartilhar sua conta com outras pessoas.
                </p>
            </div>
        </article>

        <article class="pf-card">
            <button class="pf-toggle-btn" type="button"
                aria-expanded="false" onclick="toggleCard(this)">
                <span class="material-symbols-outlined pf-icon">calendar_month</span>
                <span class="pf-pergunta">
                    Até quando posso comprar os produtos?
                </span>
                <span class="material-symbols-outlined pf-seta">expand_more</span>
            </button>

            <div class="pf-content">
                <p>
                    A participação da KeyStyle segue o cronograma da Semana
                    do Colégio do CTI Bauru, de 21 a 23 de outubro de 2026.
                    A disponibilidade dos produtos está sujeita ao período
                    de funcionamento da empresa e ao estoque disponível.
                </p>
            </div>
        </article>

        <article class="pf-card">
            <button class="pf-toggle-btn" type="button"
                aria-expanded="false" onclick="toggleCard(this)">
                <span class="material-symbols-outlined pf-icon">payments</span>
                <span class="pf-pergunta">
                    Quais formas de pagamento são aceitas?
                </span>
                <span class="material-symbols-outlined pf-seta">expand_more</span>
            </button>

            <div class="pf-content">
                <p>
                    Atualmente, aceitamos exclusivamente Pix. Não disponibilizamos
                    pagamento com cartão ou dinheiro físico. A equipe fornecerá
                    as instruções para realizar o pagamento durante o atendimento.
                </p>
            </div>
        </article>

        <article class="pf-card">
            <button class="pf-toggle-btn" type="button"
                aria-expanded="false" onclick="toggleCard(this)">
                <span class="material-symbols-outlined pf-icon">inventory_2</span>
                <span class="pf-pergunta">
                    Qual é a procedência dos materiais?
                </span>
                <span class="material-symbols-outlined pf-seta">expand_more</span>
            </button>

            <div class="pf-content">
                <p>
                    Os materiais variam conforme o produto. Os chaveiros são
                    adquiridos de uma empresa especializada em personalização.
                    Já os colares utilizam cordões e pingentes gravados,
                    selecionados em lojas on-line considerando o custo-benefício
                    e a qualidade.
                </p>
            </div>
        </article>

        <article class="pf-card">
            <button class="pf-toggle-btn" type="button"
                aria-expanded="false" onclick="toggleCard(this)">
                <span class="material-symbols-outlined pf-icon">contact_support</span>
                <span class="pf-pergunta">
                    Vocês têm algum canal de comunicação?
                </span>
                <span class="material-symbols-outlined pf-seta">expand_more</span>
            </button>

            <div class="pf-content">
                <p>
                    Sim! Você pode entrar em contato por e-mail ou Instagram.
                    O e-mail é utilizado principalmente para dúvidas e
                    informações adicionais, enquanto o Instagram divulga
                    produtos, combos e novidades sobre o projeto.
                </p>

                <p>
                    <strong>E-mail:</strong>
                    <a href="mailto:keystyleltda@gmail.com">
                        keystyleltda@gmail.com
                    </a>
                </p>

                <p>
                    <strong>Instagram:</strong>
                    <a href="https://www.instagram.com/Keystyle.ltda/"
                       target="_blank" rel="noopener noreferrer">
                        @Keystyle.ltda
                    </a>
                </p>
            </div>
        </article>

        <article class="pf-card">
            <button class="pf-toggle-btn" type="button"
                aria-expanded="false" onclick="toggleCard(this)">
                <span class="material-symbols-outlined pf-icon">event_available</span>
                <span class="pf-pergunta">
                    Posso encomendar um produto para retirar no local?
                </span>
                <span class="material-symbols-outlined pf-seta">expand_more</span>
            </button>

            <div class="pf-content">
                <p>
                    Para consultar a possibilidade de encomenda, entre em
                    contato com a equipe por e-mail. O pagamento e a retirada
                    devem seguir as orientações da KeyStyle, incluindo a
                    utilização do site quando solicitado. O prazo informado
                    para retirada durante a Semana do Colégio é até
                    23 de outubro de 2026, às 12h.
                </p>
            </div>
        </article>

    </section>
</main>

<?php
    include "_rodape.php";
?>