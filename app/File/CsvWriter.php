<?php

namespace PageMaker\File;

class CSVWriter
{
    protected $file;
    protected $delimiter;

    public function __construct(string $file, string $delimiter = ',')
    {
        $this->file = fopen($file, 'w');
        $this->delimiter = $delimiter;
    }

    public function writeRecords(array $records): void
    {
        // If there are records and we have not written a header row yet, write it
        if (!empty($records)) {
            fputcsv($this->file, array_keys(reset($records)), $this->delimiter);
        }

        // Write each record
        foreach ($records as $record) {
            fputcsv($this->file, $record, $this->delimiter);
        }
    }

    public function __destruct()
    {
        if ($this->file) {
            fclose($this->file);
        }
    }
}
