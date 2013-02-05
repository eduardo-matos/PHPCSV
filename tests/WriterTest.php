<?php

namespace Tests;

use Csv\Writer;

class WriterTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->writer = new Writer;
    }

    public function tearDown()
    {
        unset($this->writer);
    }

    public function testOutputHeader()
    {
        $this->writer->setParamHeader(array('nome', 'idade'));

        $expected = '"nome";"idade"';

        $this->assertEquals($expected, $this->writer->save());
    }

    public function testEscapeQuotes()
    {
        $this->writer->setParamHeader(array('nome', 'ida"de'));

        $expected = '"nome";"ida""de"';

        $this->assertEquals($expected, $this->writer->save());
    }

    public function testOutputRows()
    {
        $this->writer->setData(array(
            array('Eduardo', 'Matos'),
            array('Maria', 'Elidaiana'),
            array('João', 'Padilha'),
        ));

        $expected = '"Eduardo";"Matos"' . PHP_EOL . '"Maria";"Elidaiana"' . PHP_EOL . '"João";"Padilha"';

        $this->assertEquals($expected, $this->writer->save());
    }

    public function testOutputHeaderAndRows($value='')
    {
        $this->writer->setParamHeader(array('Nome', 'Sobrenome'));
        $this->writer->setData(array(
            array('Eduardo', 'Matos'),
            array('Maria', 'Elidaiana'),
            array('João', 'Padilha'),
        ));

        $expected  =           '"Nome";"Sobrenome"';
        $expected .= PHP_EOL . '"Eduardo";"Matos"';
        $expected .= PHP_EOL . '"Maria";"Elidaiana"';
        $expected .= PHP_EOL . '"João";"Padilha"';

        $this->assertEquals($expected, $this->writer->save());
    }
}
