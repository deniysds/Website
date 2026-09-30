<?php

namespace Modules\Website\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Website\Models\WebsiteCollaboration;

class CollaborationItemsImport implements ToCollection, WithHeadingRow
{
    protected WebsiteCollaboration $collaboration;
    protected string $mode;
    protected int $importedCount = 0;
    protected int $totalUnits = 0;
    protected array $errors = [];

    public function __construct(WebsiteCollaboration $collaboration, string $mode = 'append')
    {
        $this->collaboration = $collaboration;
        $this->mode = $mode;
    }

    /**
     * Process imported rows.
     */
    public function collection(Collection $rows): void
    {
        if ($this->mode === 'replace') {
            $this->collaboration->items()->delete();
        }

        // Get current max order_no and current count
        $currentMaxOrder = (int) $this->collaboration->items()->max('order_no');
        $itemCounter = $this->collaboration->items()->count();

        foreach ($rows as $index => $row) {
            $rowNum = $index + 2; // Accounting for 1-based index and heading row

            // Extract item name using various possible column keys
            $name = trim((string) (
                $row['nama_peralatan'] ??
                $row['nama_alat'] ??
                $row['nama'] ??
                $row['equipment_name'] ??
                $row['item_name'] ??
                $row['name'] ?? ''
            ));

            if ($name === '') {
                continue; // Skip empty row
            }

            // Extract item number / code
            $itemNumber = trim((string) (
                $row['nomor'] ??
                $row['nomor_urut'] ??
                $row['no'] ??
                $row['kode'] ??
                $row['item_number'] ?? ''
            ));

            if ($itemNumber === '') {
                $itemCounter++;
                $itemNumber = (string) $itemCounter;
            }

            // Extract unit
            $unit = trim((string) (
                $row['satuan'] ??
                $row['unit'] ??
                $row['satuan_alat'] ?? 'Unit'
            ));
            if ($unit === '') {
                $unit = 'Unit';
            }

            // Extract quantity
            $quantityRaw = $row['jumlah'] ??
                $row['qty'] ??
                $row['quantity'] ??
                $row['unit_count'] ?? 1;

            $quantity = (int) filter_var($quantityRaw, FILTER_SANITIZE_NUMBER_INT);
            if ($quantity < 1) {
                $quantity = 1;
            }

            // Extract specifications / notes
            $specifications = trim((string) (
                $row['spesifikasi_merk_catatan'] ??
                $row['spesifikasi_catatan'] ??
                $row['spesifikasi'] ??
                $row['catatan'] ??
                $row['keterangan'] ??
                $row['specifications'] ?? ''
            ));

            $currentMaxOrder++;

            $this->collaboration->items()->create([
                'item_number'    => $itemNumber,
                'name'           => $name,
                'unit'           => $unit,
                'quantity'       => $quantity,
                'specifications' => $specifications ?: null,
                'order_no'       => $currentMaxOrder,
            ]);

            $this->importedCount++;
            $this->totalUnits += $quantity;
        }
    }

    public function getImportedCount(): int
    {
        return $this->importedCount;
    }

    public function getTotalUnits(): int
    {
        return $this->totalUnits;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
