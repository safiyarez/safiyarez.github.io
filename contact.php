
<?php 

    require_once(__DIR__ . '/vendor/autoload.php');
    use \Mailjet\Resources;   
    /* installer composer ca ne marche pas  */


    define('API_PUBLIC_KEY', '0771bc572362cd8ac2b02d9a57d82d05');
    define('API_PRIVATE_KEY', '68e53b330ba3beee132ccca79c356a06');
    $mj = new \Mailjet\Client('API_PUBLIC_KEY', 'API_PRIVATE_KEY',true,['version' => 'v3.1']);


    if(!empty($_POST['firstname']) && !empty($_POST['email']) && !empty($_POST['message'])){
        $firstname = htmlspecialchars($_POST['firstname']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        $body = [
            'Messages' => [
              [
                'From' => [
                  'Email' => "safiyarezig78@gmail.com",
                  'Name' => "SAFIYA"
                ],

                'To' => [
                  [
                    'Email' => "safiyarezig78@gmail.com",
                    'Name' => "SAFIYA"
                  ]
                ],
                
                'Subject' => "Demande de renseignement",
                'TextPart' => "$email,$message",
            ]
            ]
        ];
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            $response->success();
            echo "Email envoyé avec succès !";
        }
        else{
            echo "Email non valide";
        }

    } 
    else {
        header('Location: index.php');
        die();
    }

?>
             
         