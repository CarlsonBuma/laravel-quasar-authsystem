<?php
 
namespace App\Exceptions;
 
use Exception;
 
class customException extends Exception
{
    // ...
 
    /**
     * Get the exception's context information.
     *
     * @return array
     */
    public function context()
    {
        // Code
    }
}