<?php

$firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
$lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
$formEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$formPhone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);

// Email validation
$email = filter_var($formEmail, FILTER_VALIDATE_EMAIL);
if ($formEmail === '') {
    $formError['email'] = 'Email é obrigatório';
} elseif ($email === false) {
    $formError['email'] = 'Email inválido';
}

// Phone validation
$phoneLen = strlen($formPhone);
if ($formPhone !== ''
    && (!is_numeric($formPhone)
        || $phoneLen > 11
        || $phoneLen < 10)) {
    $formError['phone'] = 'Telefone inválido';
    $phone = false;
}

if ($phone !== false && $email !== false) {

}

?>

<form method="post">
    <h1>Formulário</h1>

    <label for="inputFirstName">Nome</label>
    <input type="text" name="first_name" id="inputFirstName" placeholder="Nome">

    <br>

    <label for="inputLastName">Sobrenome</label>
    <input type="text" name="last_name" id="inputLastName" placeholder="Sobrenome">

    <br>

    <label for="email">Email</label>
    <input type="text" id="email" name="email" placeholder="name@example.com" value="<?= htmlentities($email === false ? $formEmail ?? '' : '') ?>">
    <?php if (isset($formError['email'])) {
        echo sprintf('<p>%s</p>', htmlentities($formError['email']));
    } ?>

    <br>

    <label for="email">Telefone</label>
    <input type="text" id="phone" name="phone" placeholder="XX99999999" value="<?= htmlentities($phone === false ? $formPhone ?? '' : '') ?>">
    <?php if (isset($formError['phone'])) {
        echo sprintf('<p>%s</p>', htmlentities($formError['phone']));
    } ?>

    <br>

    <label for="inputUser">Login</label>
    <input type="text" name="login" id="inputUser" placeholder="login">

    <br>

    <label for="inputPassword">Senha</label>
    <input type="password" name="password" id="inputPassword" placeholder="senha">

    <br>

    <button type="submit" class="btn btn-lg btn-primary btn-block">Enviar</button>
</form>
