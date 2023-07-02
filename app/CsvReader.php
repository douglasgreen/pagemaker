<?php

namespace PageMaker;

class CSVReader
{
    protected $file;
    protected $delimiter;
    protected $length;
    protected $headers;

    public function __construct(string $file, string $delimiter = ',', int $length = 1000)
    {
        if (!file_exists($file) || !is_readable($file)) {
            throw new Exception("$file not readable");
        }
        $this->file = fopen($file, 'r');
        $this->delimiter = $delimiter;
        $this->length = $length;

        // Read the first line to get the headers
        $this->headers = fgetcsv($this->file, $this->length, $this->delimiter);
    }

    public function getRecords(): array
    {
        $data = [];
        while (($row = fgetcsv($this->file, $this->length, $this->delimiter)) !== false) {
            $data[] = array_combine($this->headers, $row);
        }
        return $data;
    }

    public function __destruct()
    {
        if ($this->file) {
            fclose($this->file);
        }
    }
}
