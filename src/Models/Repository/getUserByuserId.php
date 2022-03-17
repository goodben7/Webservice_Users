<?php

namespace App\Models\Repository;

use App\Models\User;
use App\Models\Database;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \PDO;

class getUserByuserId extends user 
{
    public function Action(Request $request, Response $response, array $args) 
    {
        $db = new Database();
        $this->userId = $request->getAttribute('id');
        $sql = "SELECT * FROM $this->table WHERE userId =  $this->userId";
        $query = $db->getConnection()->prepare($sql);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if ($row == true) 
        {
            $response->getBody()->write(json_encode($row));
            return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
        }
        else
        {
            $error = array("message" => "NOT FOUND");
            $response->getBody()->write(json_encode($error));
            return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(404);
        }
    }	
}
