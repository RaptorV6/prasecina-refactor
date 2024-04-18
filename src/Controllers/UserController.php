<?php

namespace Refactor\Controllers;

use Refactor\Models\UserModel;

class UserController {
    private $userModel;
    public function __construct(UserModel $userModel) {
        $this->userModel = $userModel;
    }
    public function handleRequest($request) {
        // logic to handle user requests
    }
}

// Example usage of the controller
$controller = new UserController($userModel);
$controller->handleRequest($request);
?>