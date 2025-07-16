
<?php

// Fonction pour l'email de reset de mot de passe
// incorpore le lien dans le texte

function returnHTMLEmailResetPassword(string $password) : string {
    $HTMLEmailResetPassword = "
        <!DOCTYPE html>
<html lang='fr'>
  <head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Réinitialisation de votre mot de passe</title>
    <style>
      /* Reset pour les clients e-mail */
      body, table, td, a {
        -webkit-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
      }
      table, td {
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
      }
      img {
        -ms-interpolation-mode: bicubic;
        border: 0;
        height: auto;
        line-height: 100%;
        outline: none;
        text-decoration: none;
      }
      table {
        border-collapse: collapse !important;
      }
      body {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
      }

      /* Responsive */
      @media screen and (max-width: 600px) {
        .email-container {
          width: 100% !important;
        }
        .fluid {
          width: 80% !important;
          max-width: 80% !important;
          height: auto !important;
        }
        .stack-column,
        .stack-column-center {
          display: block !important;
          width: 100% !important;
          max-width: 100% !important;
          direction: ltr !important;
        }
        .stack-column-center {
          text-align: center !important;
        }
        .bigger-text {
        font-size: 16px !important;
        }
        .text {
            font-size: 12px !important;
        }
        .smaller-text {
            font-size: 10px !important;
        }
      }
    </style>
  </head>

  <body style='background-color: #f4f4f4; padding: 0; margin: 0;'>

    <center style='width: 100%; background-color: #f4f4f4;'>
      <table width='100%' border='0' cellpadding='0' cellspacing='0' role='presentation'>
        <tr>
          <td align='center'>

            <!-- Email Container -->
            <table class='email-container' width='600' cellpadding='0' cellspacing='0' style='max-width: 600px; background-color: #ffffff; border-radius: 8px; overflow: hidden;'>

              <!-- Header -->
              <tr>
                <td align='center' style='background-color: #000000; padding: 20px;'>
                  <img src='https://fneto-prod.fr/timecapsule/img/timecapsule-logo.png' width='200' class='fluid' alt='Timecapsule Logo' style='display: block;'>
                </td>
              </tr>

              <!-- Body -->
              <tr>
                <td align='left' style='padding: 30px 40px; font-family: Arial, sans-serif; color: #333333; font-size: 16px; line-height: 24px;'>
                  <p style='margin-top: 0;' class='text'>Bonjour,</p>
                  <p style='margin: 20px 0; text-align: center;' class='text'>
                    Vous avez demandé à réinitialiser votre mot de passe.<br>
                    Pour terminer cette action, cliquez sur le bouton ci-dessous :
                  </p>

                  <!-- Bouton -->
                  <table cellpadding='0' cellspacing='0' border='0' align='center' style='margin: 30px auto;'>
                    <tr>
                      <td bgcolor='#000000' style='border-radius: 8px;'>
                        <a href=" . $password . " target='_blank' style='display: inline-block; padding: 14px 28px; font-family: Arial, sans-serif; color: #ffffff; text-decoration: none; font-weight: bold; border-radius: 8px; text-align: center;' class='bigger-text'>
                          Réinitialiser votre mot de passe
                        </a>
                      </td>
                    </tr>
                  </table>

                  <p style='font-style: italic; font-size: 13px; color: #888888; text-align: center; margin: 0 0 15px 0;' class='smaller-text'>(Valable 1 heure)</p>
                  <p style='text-align: center; margin: 0; font-size: 16px;' class='text'>
                    Si ce n'était pas vous, ignorez ce message.<br>
                    L'équipe TimeCapsule
                  </p>
                </td>
              </tr>

            </table>

          </td>
        </tr>
      </table>
    </center>

  </body>
</html>
        ";
    return $HTMLEmailResetPassword;
}


?>
