<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailIndex = 2;
    $phoneIndex = 3;

    $firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $formEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $formPhone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

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
    }

    if (isset($formError['email']) === false
        && isset($formError['phone']) === false) {
        $handle = fopen('registros.txt', 'r');

        while (($line = fgetcsv($handle, 1000)) !== false) {
            $fileEmail = $line[$emailIndex];
            $filePhone = $line[$phoneIndex];

            if ($email === $fileEmail) {
                $formError['email'] = 'Este email já esta em uso, tente outro';
                break;
            }

            if ($formPhone === $filePhone) {
                $formError['phone'] = 'Este telefone já esta em uso, tente outro';
                break;
            }
        }
    }

    fclose($handle);

    if (isset($formError['email']) === false
        && isset($formError['phone']) === false
        && ($handle = fopen('registros.txt', 'a+'))) {
        fputcsv($handle, [
            $firstName,
            $lastName,
            $email,
            $formPhone,
            $login,
            password_hash($password, PASSWORD_BCRYPT),
        ]);

        fclose($handle);
    }
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
    <input type="text" id="email" name="email" placeholder="name@example.com" value="<?= htmlentities(isset($formError['email']) ? $formEmail ?? '' : '') ?>">
    <?php if (isset($formError['email'])) {
        echo sprintf('<p>%s</p>', htmlentities($formError['email']));
    } ?>

    <br>

    <label for="email">Telefone</label>
    <input type="text" id="phone" name="phone" placeholder="XX99999999" value="<?= htmlentities(isset($formError['phone']) ? $formPhone ?? '' : '') ?>">
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
