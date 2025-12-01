<?php
// Check if it is an AJAX request
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

// If it is AJAX, set the header to JSON
if ($isAjax) {
   header('Content-Type: application/json');
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Get and sanitize form data
   $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
   $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
   $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
   $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

   $response = [];

   // Validate inputs
   if (empty($name) || empty($email) || empty($subject) || empty($message)) {
      $response = ['status' => 'error', 'message' => 'Por favor, preencha todos os campos.'];
   } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $response = ['status' => 'error', 'message' => 'Endereço de e-mail inválido.'];
   } else {
      // Email configuration
      $to = 'samumioni02@gmail.com';
      $email_subject = "Novo contato: $subject";

      // Construct the email body
      $email_body = "Você recebeu uma nova mensagem do formulário de contato do Edenshop.\n\n";
      $email_body .= "Nome: $name\n";
      $email_body .= "Email: $email\n";
      $email_body .= "Assunto: $subject\n";
      $email_body .= "Mensagem:\n$message\n";

      // Headers
      $headers = "From: noreply@edenshop.com\r\n";
      $headers .= "Reply-To: $email\r\n";
      $headers .= "X-Mailer: PHP/" . phpversion();

      // Send email
      if (mail($to, $email_subject, $email_body, $headers)) {
         $response = ['status' => 'success', 'message' => 'Mensagem enviada com sucesso! Entraremos em contato em breve.'];
      } else {
         $response = ['status' => 'error', 'message' => 'Ocorreu um erro ao enviar sua mensagem. Tente novamente mais tarde.'];
      }
   }

   // Return response based on request type
   if ($isAjax) {
      echo json_encode($response);
   } else {
      // Fallback for non-AJAX requests (Standard POST)
      // Output a simple HTML page with SweetAlert
      ?>
      <!DOCTYPE html>
      <html lang="pt-BR">

      <head>
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <title>Enviando...</title>
         <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
         <style>
            body {
               font-family: sans-serif;
               background-color: #f4f4f4;
            }
         </style>
      </head>

      <body>
         <script>
            document.addEventListener('DOMContentLoaded', () => {
               Swal.fire({
                  title: '<?php echo ($response['status'] === 'success') ? 'Mensagem Enviada!' : 'Erro!'; ?>',
                  text: '<?php echo addslashes($response['message']); ?>',
                  icon: '<?php echo $response['status']; ?>',
                  confirmButtonColor: '<?php echo ($response['status'] === 'success') ? '#2e8b57' : '#d33'; ?>'
               }).then(() => {
                  window.location.href = 'contact.php';
               });
            });
         </script>
      </body>

      </html>
      <?php
   }

} else {
   // Not a POST request
   if ($isAjax) {
      echo json_encode(['status' => 'error', 'message' => 'Método de requisição inválido.']);
   } else {
      // Redirect back to contact page if accessed directly via GET
      header("Location: contact.php");
      exit;
   }
}
?>