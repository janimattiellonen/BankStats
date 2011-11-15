<?php
namespace Stats\BankBundle\Service;

class UploaderException extends \Exception
{
    public static function createInvalidMimeTypeException($file, $mimetype)
    {
        return new self("The file $file with the mime type $mimetype is not supported");
    }
    
    public static function createFailedToUploadException($file, \Exception $e)
    {
        return new self("Failed to upload the file $file. Error: " . $e->getMessage() );
    }
}