<?php

namespace Controllers\TrabajoGrupal;

use \Dao\TrabajoGrupal\Usuarios as DaoUsuarios;
use \Views\Renderer as Renderer;

class Usuarios extends \Controllers\PublicController{
    public function run(): void{
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->listUsers();
                break;
            case 'POST':
                if (isset($_GET['usercod'])) {
                    $this->editUser();
                } else {
                    $this->createUser();
                }
                break;
            default:
                throw new \Exception('Invalid request method');
        }
    }

    private function listUsers(): void{
        $viewData = [];
        $viewData["usuarios"] = DaoUsuarios::readAllUsuarios();
        Renderer::render('trabajogrupal/formusuarios', $viewData);
    }

    private function createUser(): void{
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $useremail = filter_var($_POST['useremail'], FILTER_SANITIZE_EMAIL);

        
        $sql = "INSERT INTO usuario (username, useremail ) VALUES (?,)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('ssi...', $username, $useremail);
        $stmt->execute();

        Renderer::render('trabajogrupal/formusuarios', $viewData);
    }

    private function editUser(): void{
        $usercod = filter_var($_GET['usercod'], FILTER_SANITIZE_NUMBER_INT);
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $useremail = filter_var($_POST['useremail'], FILTER_SANITIZE_EMAIL);

        $sql = "UPDATE usuario SET username = ?, useremail = ?, ... WHERE usercod = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('ssii', $username, $useremail, $usercod);
        $stmt->execute();


        Renderer::render('trabajogrupal/formusuarios', $viewData);
    }

}
