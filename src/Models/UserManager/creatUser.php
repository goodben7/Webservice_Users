<?php 

namespace App\Models\UserManager;

use App\Models\User;
use App\Models\Database;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \PDO;

class creatUser extends User 
{
	public function Action(Request $request, Response $response, array $args) 
    { 
        $db = new Database();
        $data = $request->getParsedBody();
        $this->name=htmlspecialchars(strip_tags($data["name"]));
        $this->middleName=htmlspecialchars(strip_tags($data["middleName"]));
        $this->firstName=htmlspecialchars(strip_tags($data["firstName"]));
        $this->phoneNumber=htmlspecialchars(strip_tags($data["phoneNumber"]));
        $this->password=htmlspecialchars(strip_tags($data["password"]));
        $this->password = password_hash($data["password"], PASSWORD_BCRYPT);
        $this->role=htmlspecialchars(strip_tags($data ["role"]));
        $this->pays=htmlspecialchars(strip_tags($data ["pays"]));
        $this->userId = random_int(1000000000, 9999999999);

        $sql = "SELECT COUNT(*) AS nbr FROM $this->table WHERE 
        phoneNumber = $this->phoneNumber";
        $query = $db->getConnection()->prepare($sql);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        if ($data['nbr'] == 1)
        {
            $error = array("message" => "Application Error The Phone Number Used Already Exists");
            $response->getBody()->write(json_encode($error));
            return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(400); 
        }

        $sql = "INSERT INTO " . $this->table . " SET name=:name, middleName=:middleName, 
        firstName=:firstName, phoneNumber=:phoneNumber, password=:password, 
        role=:role, pays=:pays, userId=:userId"; 

        $query = $db->getConnection()->prepare($sql);

        $query->bindParam(":name", $this->name);
        $query->bindParam(":middleName", $this->middleName);
        $query->bindParam(":phoneNumber", $this->phoneNumber);
        $query->bindParam(":firstName", $this->firstName);
        $query->bindParam(":password", $this->password);
        $query->bindParam(":role", $this->role);
        $query->bindParam(":pays", $this->pays);
        $query->bindParam(":userId", $this->userId);
        $query = $query->execute();
    
        if ($query == true) 
        {
            
        	$sql = "SELECT * FROM $this->table ORDER BY ID DESC LIMIT 1";
        	$query = $db->getConnection()->prepare($sql);
        	$query->execute();
        	$row = $query->fetch(PDO::FETCH_ASSOC);
            $response->getBody()->write(json_encode($row));
            return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
        }
        else
        {
            $error = array("message" => "Application Error");
            $response->getBody()->write(json_encode($error));
            return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
        }
    }	
}
