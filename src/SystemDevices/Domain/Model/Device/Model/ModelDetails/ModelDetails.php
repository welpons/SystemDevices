<?php



namespace App\SystemDevices\Domain\Model\Device\Model\ModelDetails;

/**
 * Description of ModelDetails
 *
 * @author Welpons <welpons@gmail.com>
 */
class ModelDetails
{
    
    /**
     * Official name
     * 
     * @var string 
     */
    private $name;
    
    /**
     * Model number or product number
     * 
     * @var string 
     */
    private $modelNumber;
    
    /**
     * Device manufacturer
     * 
     * @var string 
     */
    private $manufacturer;
    
    public function __construct(string $name, string $modelNumber, string $manufacturer)
    {
        $this->name = $name;
        $this->modelNumber = $modelNumber;
        $this->manufacturer = $manufacturer;
    }

    
    public function name(): string 
    {
        return $this->name;
    }

    public function modelNumber(): string 
    {
        return $this->modelNumber;
    }
    
    public function manufacturer(): string
    {
        return $this->manufacturer;
    }

    
}
