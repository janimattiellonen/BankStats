<?php
namespace Stats\BankBundle\Service;

use Stats\BankBundle\Service\UploaderException,
    Symfony\Component\HttpFoundation\File\File,
    Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploader
{
    /**
     * @var string
     */
    private $uploadDirectory;
    
    /**
     *
     * @param string $uploaDirectory 
     */
    public function __construct($uploadDirectory)
    {
        $this->uploadDirectory = $uploadDirectory;
    }
    
    /**
     *
     * @param UploadedFile $file
     * @return true
     * 
     * @throws UploaderException if the file was not uploaded properly
     */
    public function upload(UploadedFile $file)
    {
        if(!$this->isAllowedFile($file) )
        {
            throw UploaderException::createInvalidMimeTypeException($file->getClientOriginalName() , $file->getMimeType() );
        }
        
        try
        {
            $tempName = tempnam($this->uploadDirectory, 'TEMP_');

            $newFile = $file->move($this->uploadDirectory, $tempName);

            $this->setUploadedFile($newFile);
        }
        catch(\Exception $e)
        {
            throw UploaderException::createFailedToUploadException($file->getClientOriginalName(), $e);
        }
        
        return true;
    }
    
    /**
     * @param File $file 
     */
    protected function setUploadedFile(File $file)
    {
        $this->uploadedFile = $file;
    }
    
    /**
     *
     * @return File
     */
    public function getUploadedFile()
    {
        return $this->uploadedFile;
    }
    
    /**
     * Signals that the file processing is done and that the temporary file can be deleted.
     */
    public function done()
    {
        unlink($this->uploadedFile->getPath() );
        $this->uploadedFile = null;
    }
    
    /**
     * @return array
     */
    public function getAllowedMimeTypes()
    {
        return array('text/plain', 'text/csv');
    }
    
    /**
     * @param UploadedFile $file
     * @return boolean
     */
    public function isAllowedFile(UploadedFile $file)
    {
        return in_array($file->getMimeType(), $this->getAllowedMimeTypes() );
    }
}