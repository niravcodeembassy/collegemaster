<?php

namespace App\Repository\Contracts;

use Illuminate\Http\Request;

interface Cart
{
    public function add();
    public function update();
    public function remove();
    public function get();
    public function count();
    public function mapCart();
}
