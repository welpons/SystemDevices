<?php

namespace App\Tests\SystemDevices\Infrastructure\Util;

use PHPUnit\Framework\TestCase;
use App\SystemDevices\Infrastructure\Util\ArrayToXml;

/**
 * Description of ArrayToXmlTest
 *
 * @author felix
 */
class ArrayToXmlTest extends TestCase
{
    public function testArraToXmlAsDomDocument()
    {
        include('array.php');
        
        $result = new ArrayToXml($array, 'customrootname');
        
        $this->assertTrue($result->toDom() instanceof \DOMDocument);
    }        
            
    
}
