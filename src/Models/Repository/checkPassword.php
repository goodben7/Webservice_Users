<?php

namespace App\Models\Repository;

use App\Models\User;
use App\Models\Database;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \PDO;

class checkPassword extends user 
{
    public function Action(Request $request, Response $response, array $args) 
    {
        $db = new Database();
        $data = $request->getParsedBody();
        $this->phoneNumber=htmlspecialchars(strip_tags($data ["phoneNumber"]));
        $this->password=htmlspecialchars(strip_tags($data ["password"]));

        $sql = "SELECT COUNT(*) AS nbr FROM $this->table WHERE 
        phoneNumber = $this->phoneNumber";
        $query = $db->getConnection()->prepare($sql);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        
        if ($data['nbr'] == 1) 
        {
            $sql = "SELECT password FROM  $this->table  WHERE 
            phoneNumber = $this->phoneNumber" ;
            $query = $db->getConnection()->prepare($sql);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);
            $password_hash = $data['password'];

            if(password_verify($this->password, $password_hash))
            {
                $sql = "SELECT id FROM $this->table  WHERE phoneNumber =$this->phoneNumber";
                $query = $db->getConnection()->prepare($sql);
                $return = $query->execute();
                $data = $query->fetch(PDO::FETCH_ASSOC);
                $response->getBody()->write(json_encode($data));
                return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
            } 
            else 
            {
                $error = array("message" => "Authentification error access denied");
                $response->getBody()->write(json_encode($error));
                return $response
                ->withHeader('content-type', 'application/json')
                ->withStatus(401);
            }    
        }
        else
        {
            $error = array("message" => "Authentification error access");
            $response->getBody()->write(json_encode($error));
            return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(401);
        }
    }	
}
