<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);

    // Validação básica
    if (!empty($name) && !empty($email)) {

        // Cria uma instância do PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.titan.email'; // Substitua pelo seu servidor SMTP
            $mail->SMTPAuth   = true;
            $mail->Username   = 'contato@jdfundacoes.com.br'; // Substitua pelo seu email
            $mail->Password   = 'JDfund@2024'; // Substitua pela sua senha
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->CharSet = 'UTF-8';

            // Destinatários
            $mail->setFrom('contato@jdfundacoes.com.br', 'Mailer'); // Substitua pelo seu email
            $mail->addAddress('contato@jdfundacoes.com.br', 'Contato'); // Substitua pelo seu email de destino
            $mail->addAddress('vkehl@aasp.org.br');               //Name is optional
            $mail->addReplyTo($email, $name);

            // Conteúdo do email
            $mail->isHTML(true);
            $mail->Subject = 'Novo pedido de orçamento JD Fundações';
            $mail->Body    = "Nome: $name<br>Email: $email<br>";

            // Envia o email
            $mail->send();
            
            // Redireciona para a página de agradecimento
            header('Location: https://jdfundacoes.com.br/agradecimento.html');
            exit();
        } catch (Exception $e) {
            echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
        }
    } else {
        echo "Por favor, preencha todos os campos.";
    }
} else {
    echo "Método de requisição inválido.";
}
?>


