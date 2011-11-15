<?php

namespace Stats\Component\Csv;

class Parser
{
    /**
     * @var string
     */
    protected $delimiter;
    
    /**
     * @var string
     */
    protected $enclosure;
    
    /**
     * @var boolean
     */
    protected $hasHeader;
    
    /**
     *
     * @param string $delimiter default = ','
     * @param string $enclosure default = '"'
     * @param boolean $hasHeader default = true
     */
    public function __construct($delimiter = ",", $enclosure = '"', $hasHeader = true)
    {
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->hasHeader = $hasHeader;
    }
    
    public function parse($csvString)
    {
        $lines = explode("\n", $csvString);
        
        $data = array();
        
        array_shift($lines);
        
        $lines = array_filter($lines, function($data)
        {
            return strlen(trim($data) ) > 0;
        });
            
        foreach($lines as $line)
        {
            $line = trim($line);
            
            $row = explode("\t", $line);
            
            array_walk($row, function(&$data)
            {
                $data = trim($data);
                $data = preg_replace("'\s+'", " ", $data);
            });
            
            
            
            $data[] = $this->normalize($row, 13);
            
            echo "\n\n";
        }
        
        $header = array();
        
        if($this->hasHeader)
        {
            $header = array_shift($data);
        }
        
        return array(
          'header' => $header,
          'content' => $data,
        );
    }
    
    protected function normalize(array $cols, $expectedSize)
    {
        $size = count($cols);
        
        if($size == $expectedSize)
        {
            return $cols;
        }
        else if($size < $expectedSize)
        {
            $diff = $expectedSize - $size;
            
            for($i = 0; $i < $diff; $i++)
            {
                array_push($cols, "");
            }
        }
        
        return $cols;
        
    }
}