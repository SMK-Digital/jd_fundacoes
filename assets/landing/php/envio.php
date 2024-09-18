<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Carrega o autoloader do Composer
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $assunto = htmlspecialchars($_POST['assunto']);
    $nome = htmlspecialchars($_POST['nome']);
    $fone = htmlspecialchars($_POST['fone']);
    $email = htmlspecialchars($_POST['email']);
    $msg = htmlspecialchars($_POST['msg']);

    // Validação básica
    if (!empty($nome) && !empty($email)) {
        // Cria uma instância do PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor SMTP
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Habilita saída de depuração detalhada
            $mail->isSMTP(); // Envia usando SMTP
            $mail->Host = 'smtp.titan.email'; // Define o servidor SMTP para envio
            $mail->SMTPAuth = true; // Habilita autenticação SMTP
            $mail->Username = 'contato@jdfundacoes.com.br'; // Nome de usuário SMTP
            $mail->Password = 'JDfund@2024'; // Senha SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Habilita criptografia TLS implícita
            $mail->Port = 465; // Porta TCP para conexão, use 587 se tiver configurado `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->CharSet = 'UTF-8'; // Define o charset para UTF-8

            // Destinatários
            $mail->setFrom('contato@jdfundacoes.com.br', 'Mailer');
            $mail->addAddress('contato@jdfundacoes.com.br', 'Contato JD Fundações'); // Adiciona um destinatário
            $mail->addAddress('vkehl@aasp.org.br'); // Adiciona outro destinatário
            $mail->addReplyTo('contato@jdfundacoes.com.br', 'Informações JD Fundações');

            // Conteúdo do e-mail
            $mail->isHTML(true); // Define o formato do e-mail para HTML
            $mail->Subject = 'Contato via Site JD Fundações';

            $body = "Mensagem enviada através do Site JD Fundações, segue informações abaixo:<br>
                    Assunto: $assunto<br>
                    Nome: $nome<br>
                    Telefone: $fone<br>
                    E-mail: $email<br>
                    Mensagem:<br> $msg";

            $mail->Body = $body;

            // Envia o e-mail
            $mail->send();
            // Redireciona para a página de agradecimento
            header('Location: https://jdfundacoes.com.br/agradecimento.html');
            exit;
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
