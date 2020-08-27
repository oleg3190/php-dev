<?php
namespace App\Interfaces;

interface ChatInterface
{
    public function getAll($request = null);

    public function create($request);

    public function remove($owner,$message,$index);
}