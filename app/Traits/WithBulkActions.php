<?php

namespace App\Traits;

/**
 * @property mixed selectedRowsQuery
 */
trait WithBulkActions
{
    public bool $selectPage = false;
    public bool $selectAll = false;
    public $selected = [];

    public function selectPageRows(): void
    {
        $this->selected = $this->rows->pluck('id')->map(fn($id) => (string)$id);
    }

    public function updatedSelected(): void
    {
        $this->selectAll = false;
        $this->selectPage = false;
    }

    public function updatedSelectPage($value)
    {
        if ($value) return $this->selectPageRows();

        $this->selected = [];
    }

    public function selectAll(): void
    {
        $this->selectAll = true;
    }

    public function getSelectedRowsQueryProperty()
    {
        return (clone $this->rowsQuery)
            ->unless($this->selectAll, fn($query) => $query->whereKey($this->selected));
    }

    // delete checked/selected rows
    public function deleteSelected(): void
    {
        $this->selectedRowsQuery->delete();

        $this->cancel();
        $this->alert('success', 'Deleted Successfully');
    }
}
