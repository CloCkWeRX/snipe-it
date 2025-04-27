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

        $editingLocation = false;

        $depreciation = Depreciation::where('name', '=', $this->findCsvMatch($row, 'name'))->first();

        if ($this->findCsvMatch($row, 'id') != '') {
            // Override location if an ID was given
            \Log::debug('Finding location by ID: ' . $this->findCsvMatch($row, 'id'));
            $location = Location::find($this->findCsvMatch($row, 'id'));
        }


        if ($location) {
            if (! $this->updating) {
                $this->log('A matching Location ' . $this->item['name'] . ' already exists');
                return;
            }

            $this->log('Updating Location');
            $editingLocation = true;
        } else {
            $this->log('No Matching Location, Create a new one');
            $location = new Location();
            $location->created_by = auth()->id();
        }

        // Pull the records from the CSV to determine their values
        $this->item['name'] = trim($this->findCsvMatch($row, 'name'));

        Log::debug('Item array is: ');
        Log::debug(print_r($this->item, true));


        if ($editingLocation) {
            Log::debug('Updating existing location');
            $location->update($this->sanitizeItemForUpdating($location));
        } else {
            Log::debug('Creating location');
            $location->fill($this->sanitizeItemForStoring($location));
        }

        if ($location->save()) {
            $this->log('Location ' . $location->name . ' created or updated from CSV import');
            return $location;
        } else {
            Log::debug($location->getErrors());
            $this->logError($location, 'Location "' . $this->item['name'] . '"');
            return $location->errors;
        }
    }
}
