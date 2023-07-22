<?php

namespace PageMaker;

class Pagination
{
    protected $data;
    protected $dataPerPage;
    protected $currentPage;

    public function __construct(array $data, int $dataPerPage = 10, int $currentPage = 1)
    {
        $this->data = $data;
        $this->dataPerPage = $dataPerPage;
        $this->currentPage = $currentPage;
    }

    public function getData(): array
    {
        $start = ($this->currentPage - 1) * $this->dataPerPage;
        return array_slice($this->data, $start, $this->dataPerPage);
    }

    public function getPaginationLinks(): string
    {
        $links = [];
        $totalPages = ceil(count($this->data) / $this->dataPerPage);

        for ($i = 1; $i <= $totalPages; $i++) {
            array_push($links, "<a href=\"?page=$i\">$i</a>");
        }

        return implode(" ", $links);
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getTotalPages(): int
    {
        return ceil(count($this->data) / $this->dataPerPage);
    }

    public function setDataPerPage(int $dataPerPage): void
    {
        $this->dataPerPage = $dataPerPage;
    }

    public function setCurrentPage(int $currentPage): void
    {
        $this->currentPage = $currentPage;
    }
}
