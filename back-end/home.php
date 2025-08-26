<?php

session_start();


if (!isset($_SESSION['token'])) {
    header('Location: cadastro/Cadastro.php'); // Redirecionar para a página de cadastro se não estiver autenticado
    exit();
    echo "Você não está autenticado. Por favor, faça o cadastro.";
}
require_once __DIR__ . '/dao/CampoDAO.php';
require_once __DIR__ . '/model/Campo.php';
require_once __DIR__ . '/dao/ModuloDAO.php';
require_once __DIR__ . '/model/Modulo.php';
require_once __DIR__ . '/dao/CardDAO.php';
require_once __DIR__ . '/model/Card.php';
require_once __DIR__ . '/dao/DadosDAO.php';
require_once __DIR__ . '/model/Dados.php';




$camposDAO = new CampoDAO();
$dadosDAO = new DadosDAO();
$cardsDAO = new CardDAO();
$moduloDAO = new ModuloDAO();

$campos = $camposDAO->listarCamposPorEmpresa($_SESSION['id_empresa']);



$cards = [];
$modulos = [];
$dados = [];

if (isset($_GET['id_tabela'])) {
    $id_modulo = $_GET['id_tabela'];
    $cards = $cardsDAO->listarCardsPorModulo($id_modulo);
} else {
    $modulos = $moduloDAO->listarModulosPorEmpresa($_SESSION['id_empresa']);
}
if (isset($_GET['id'])) {
    $id_campo = $_GET['id'];
    $modulos = $moduloDAO->listarModulosPorCampo($id_campo, $_SESSION['id_empresa']);
}



?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://unpkg.com/akar-icons-fonts"></script>
    <link rel="stylesheet" href="../js/sidebar.js">
</head>
<html>

<body>
    <div class="container">
        <header class="header">
            <div class="logo">
                <img src="../img-back-end/logomarca1.png" alt="Logo">
            </div>
            <div class="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Pesquisa">
            </div>
            <div class="title">
                <h1>Gestão & Solução</h1>
            </div>
            <div class="menu-icon">
                <a href="informacoes.html"><i class="fa fa-info-circle"></i></a>
                <a href="configuracao.html"><i class="ai-settings-horizontal"></i> </a>
            </div>
            <a href="acoes/sair.php"><button>Sair</button></a>
        </header>

        <aside class="sidebar">
            <?php foreach ($campos as $campo): ?>
                <a href="?id=<?= $campo->getIdCampo(); ?>">
                    <nav>
                        <ul>
                            <li style="background-color: <?= $campo->getCor(); ?>"><?= $campo->getNome(); ?></li>
                        </ul>
                    </nav>
                </a>
            <?php endforeach; ?>
            <div class="add-button">
                <a href="acoes/Addcampo.php"><i class="fas fa-plus-circle"></i></a>
            </div>
        </aside>


        <main class="main-content">

            <!-- modulos -->
            <ul>
                <?php foreach ($modulos as $modulo): ?>
                    <li><a href="?id_tabela=<?= $modulo->getId(); ?>"><?= $modulo->getNome(); ?></a></li>
                <?php endforeach; ?>
            </ul>

            <!-- cards -->
            <div class="cards-table">
                <?php foreach ($cards as $card): ?>
                    <div class="card">
                        <h3><?= $card->getTitulo(); ?></h3>
                        <?php foreach ($dadosDAO->buscarDadosPorCard($card->getId()) as $dado): ?>
                            <p><?= $dado->getValor(); ?></p>
                        <?php endforeach; ?>
                        <a href="acoes/Adddados.php?id_card=<?= $card->getId() ?>&id_tabela=<?= $_GET['id_tabela'] ?>">Adicionar</a>
                    </div>
                <?php endforeach; ?>
            </div>
 
            <!-- adicionar campo -->

            <?php if (isset($_GET['id'])): ?>
                <a href="acoes/Adicionarmodulo.php?id_campo=<?= $_GET['id']; ?>">Adicionar</a>
            <?php endif; ?>
            <!-- adicionar tabela -->

            <?php if (isset($_GET['id_tabela'])): ?>
                <a href="acoes/Addcard.php?id_tabela=<?= $_GET['id_tabela'] ?>">Adicionar</a>
            <?php endif; ?>

        </main>
    </div>

</body>

</html>