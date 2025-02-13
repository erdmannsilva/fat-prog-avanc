<?php
require_once("db.php");
require_once("globals.php");
?>
<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmes</title>
    <link rel="shortcut icon" href="img/logo.ico">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.3/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<header>
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <!-- Logo -->
            <a href="<?= $BASE_URL ?>" class="navbar-brand d-flex align-items-center">
                <img src="<?= $BASE_URL ?>img/logo.png" alt="Filmes" id="logo">
                <span id="filmes-title">Filmes</span>
            </a>

            <!-- Botão do menu para dispositivos móveis -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
                aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Barra de navegação -->
            <div class="collapse navbar-collapse" id="navbar">
                <!-- Formulário de pesquisa -->
                <form action="<?= $BASE_URL ?>search.php" method="GET" id="search-form" class="d-flex mx-auto">
                    <input type="text" name="q" id="search" class="form-control me-2"
                        placeholder="Buscar Filmes" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                <!-- Link de login/cadastro -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="<?= $BASE_URL ?>auth.php" class="nav-link">Entrar / Cadastrar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<?php if(!empty($flassMessage["msg"])): ?>
<div class="msg-container">
<p class="msg <?= $flassMessage["type"] ?>"><?= $flassMessage["msg"]
?></p>
</div>
<?php endif; ?>
</body>
</html>
