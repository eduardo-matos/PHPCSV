<?php

namespace Csv;

/**
 * Helper for creating/writing CSV documents.
 * @license Public Domain
 */
class Writer
{
    /**
     * The data to be written
     * @var array|null
     */
    protected $data = array();

    /**
     * The entry delimiter
     * @var string
     */
    protected $delimit = ';';

    /**
     * The char enclosing an antry
     * @var string
     */
    protected $enclose = '"';

    /**
     * The char escaping an enclosing char
     * @var string
     */
    protected $escape = '"';

    /**
     * The line terminator. Defaults to PHP_EOL @link http://php.net/manual/en/reserved.constants.php
     * @var string
     */
    protected $terminate = PHP_EOL;

    /**
     * The header
     * @var array|null
     */
    protected $header = null;

    /**
     * Constructor with optional parameters
     * @param array $data The data
     * @param array $params  The parameter array. Allowed keys are: header,delimit,enclose,escape,terminate
     */
    public function __construct(array $data = null, array $params = null)
    {
        $this->data = $data;
        if(null !== $params) {
            $this->setParams($params);
        }
    }

    /**
     * Set optional parameters. If there is a setter method for an array key - the method will be called
     * @param array $params
     */
    protected function setParams(array $params)
    {
        foreach($params as $key => $param) {
            if(method_exists($this, 'setParam'.  ucfirst($key))) {
                call_user_func(array($this,'setParam'.ucfirst($key)), $param);
            }
        }
    }

    /**
     * Getter
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Setter
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * Getter
     * @return array|null
     */
    public function getParamHeader()
    {
        return $this->header;
    }

    /**
     * Setter
     * @param array $header
     */
    public function setParamHeader(array $header)
    {
        $this->header = $header;
    }

    /**
     * Getter
     * @return string
     */
    public function getParamDelimit()
    {
        return $this->delimit;
    }

    /**
     * Setter
     * @param string $delimit
     */
    public function setParamDelimit($delimit)
    {
        $this->delimit = $delimit;
    }

    /**
     * Getter
     * @return string
     */
    public function getParamEnclose()
    {
        return $this->enclose;
    }

    /**
     * Setter
     * @return string
     */
    public function setParamEnclose($enclose)
    {
        $this->enclose = $enclose;
    }

    /**
     * Getter
     * @return string
     */
    public function getParamEscape()
    {
        return $this->escape;
    }

    /**
     * Setter
     * @return string
     */
    public function setParamEscape($escape)
    {
        $this->escape = $escape;
    }

    /**
     * Getter
     * @return string
     */
    public function getParamTerminate()
    {
        return $this->terminate;
    }

    /**
     * Setter
     * @return string
     */
    public function setParamTerminate($terminate)
    {
        $this->terminate = $terminate;
    }

    /**
     * Formats a row
     * @param array $data
     * @return string
     */
    protected function formatRow(array $data)
    {
        $buffer = array();
        foreach((array)$data as $key => $item)
        {
            $buffer[] = $this->getParamEnclose()
                    .str_replace($this->getParamEnclose(), $this->getParamEscape().$this->getParamEnclose(), $item)
                    .$this->getParamEnclose();
        }
        return implode($this->getParamDelimit(), $buffer);
    }

    /**
     * Outputs the complete csv string.
     * @return string
     */
    protected function toString()
    {
        $buffer = array();
        if(null !== $this->getParamHeader())
            $buffer[] = $this->formatRow($this->getParamHeader());
        foreach((array)$this->getData() as $row)
            $buffer[] = $this->formatRow($row);

        return implode($this->getParamTerminate(), $buffer);
    }

    /**
     * Save/Output the csv string
     * If there is no parameter - the string will be returned
     * If there is a parameter - the string will be saved
     * @param string $fileName
     * @return string|void
     */
    public function save($fileName = null)
    {
        if(null === $fileName) {
            return $this->toString();
        } else {
            file_put_contents($fileName, $this->toString());
        }
    }
}
