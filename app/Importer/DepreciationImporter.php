<?php

namespace App\Importer;

use App\Models\Depreciation;
use Illuminate\Support\Facades\Log;

class DepreciationImporter extends ItemImporter
{
    protected $depreciations;

    protected function handle($row)
    {
        parent::handle($row);
        $this->createDepreciationIfNotExists($row);
    }

    /**
     * Create a depreciation if a duplicate does not exist.
     *
     * @param array $row
     */
    public function createDepreciationIfNotExists(array $row)
    {

        $editingDepreciation = false;

        $depreciation = Depreciation::where('name', '=', $this->findCsvMatch($row, 'name'))->first();

        if ($this->findCsvMatch($row, 'id') != '') {
            // Override depreciation if an ID was given
            \Log::debug('Finding depreciation by ID: ' . $this->findCsvMatch($row, 'id'));
            $depreciation = Depreciation::find($this->findCsvMatch($row, 'id'));
        }


        if ($depreciation) {
            if (! $this->updating) {
                $this->log('A matching depreciation ' . $this->item['name'] . ' already exists');
                return;
            }

            $this->log('Updating Depreciation');
            $editingDepreciation = true;
        } else {
            $this->log('No Matching Depreciation, Create a new one');
            $depreciation = new Depreciation();
            $depreciation->created_by = auth()->id();
        }

        // Pull the records from the CSV to determine their values
        $this->item['name'] = trim($this->findCsvMatch($row, 'name'));
        $this->item['months'] = trim($this->findCsvMatch($row, 'months'));

        Log::debug('Item array is: ');
        Log::debug(print_r($this->item, true));


        if ($editingDepreciation) {
            Log::debug('Updating existing depreciation');
            $depreciation->update($this->sanitizeItemForUpdating($depreciation));
        } else {
            Log::debug('Creating depreciation');
            $depreciation->fill($this->sanitizeItemForStoring($depreciation));
        }

        if ($depreciation->save()) {
            $this->log('Depreciation ' . $depreciation->name . ' created or updated from CSV import');
            return $depreciation;
        } else {
            Log::debug($depreciation->getErrors());
            $this->logError($depreciation, 'Depreciation "' . $this->item['name'] . '"');
            return $depreciation->errors;
        }
    }
}
