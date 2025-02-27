<?php
require_once("templates/header.php");
require_once("models/User.php");
require_once("DAO/UserDAO");
$UserDAO = new UserDao($conn, $BASE_URL);
$UserDATA = $UserDAO->verifyToken(true);
if($UserDATA-> image==''){
    $UserDATA->image=user.png;
}
?>
<div class="row">
<div class="col-md-4">
<h1><?= $fullName ?></h1>
<p class="page-description">Altere seus dados no formulário
abaixo:</p>
<div class="form-group">
<label for="name">Nome:</label>
<input type="text" class="form-control" id="name" name="name"
placeholder="Digite o seu nome" value="<?= $userData->name ?>">
</div>
<input type="submit" class="btn card-btn" value="Alterar">
</div>
<div class="col-md-4">
<div id="profile-image-container" style="background-image: url('<?=
$BASE_URL ?>img/users/<?= $userData->image ?>')"></div>
<div class="form-group">
<label for="image">Foto:</label>
<input type="file" class="form-control-file" name="image">
</div>
<div class="form-group">
<label for="bio">Sobre você:</label>
<textarea class="form-control" name="bio" id="bio" rows="5"
placeholder="Conte quem você é, o que faz e onde trabalha..."><?=
$userData->bio ?></textarea>
</div>
</div>
</div>
</form>
<div class="row" id="change-password-container">
<div class="col-md-4">
<h2>Alterar a senha:</h2>
<p class="page-description">Digite a nova senha e confirme, para
alterar sua senha:</p>
<form action="<?= $BASE_URL ?>user_process.php"
method="POST">
<input type="hidden" name="type" value="changepassword">
<div class="form-group">
<label for="password">Senha:</label>
<input type="password" class="form-control" id="password"
name="password" placeholder="Digite a sua nova senha"></div>
<div class="form-group">
<label for="confirmpassword">Confirmação de senha:</label>
<input type="password" class="form-control" id="confirmpassword"
name="confirmpassword" placeholder="Confirme a sua nova senha">
</div>
<input type="submit" class="btn card-btn" value="Alterar Senha">
</form>
</div>
</div>
</div>
</div>
<?php
require_once("templates/footer.php");
?>