<?php
namespace Application\Procedures;

use Routeless\Core\RPC\Controller;

class Hello extends Controller
{
    public function ping() {
        return 'pong!';
    }
}