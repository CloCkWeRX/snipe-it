<?php

namespace App\Importer;

use App\Models\Manufacturer;
use Illuminate\Support\Facades\Log;

class ManufacturerImporter extends ItemImporter
{
    protected $manufacturers;

    protected function handle($row)
    {
        parent::handle($row);
        $this->createManufacturerIfNotExists($row);
    }

    /**
     * Create a manufacturer if a duplicate does not exist.
     *
     * @param array $row
     */
    public function createManufacturerIfNotExists(array $row)
    {

        $editingManufacturer = false;

        $manufacturer = Manufacturer::where('name', '=', $this->findCsvMatch($row, 'name'))->first();

        if ($this->findCsvMatch($row, 'id') != '') {
            // Override manufacturer if an ID was given
            \Log::debug('Finding manufacturer by ID: ' . $this->findCsvMatch($row, 'id'));
            $manufacturer = Manufacturer::find($this->findCsvMatch($row, 'id'));
        }


        if ($manufacturer) {
            if (! $this->updating) {
                $this->log('A matching manufacturer ' . $this->item['name'] . ' already exists');
                return;
            }

            $this->log('Updating Manufacturer');
            $editingManufacturer = true;
        } else {
            $this->log('No Matching Manufacturer, Create a new one');
            $manufacturer = new Manufacturer();
            $manufacturer->created_by = auth()->id();
        }

        // Pull the records from the CSV to determine their values
        $this->item['name'] = trim($this->findCsvMatch($row, 'name'));
        $this->item['months'] = trim($this->findCsvMatch($row, 'months'));
        $this->item['support_phone'] = trim($this->findCsvMatch($row, 'support_phone'));
        $this->item['fax'] = trim($this->findCsvMatch($row, 'fax'));
        $this->item['support_email'] = trim($this->findCsvMatch($row, 'support_email'));
        $this->item['contact'] = trim($this->findCsvMatch($row, 'contact'));
        $this->item['url'] = trim($this->findCsvMatch($row, 'url'));
        $this->item['support_url'] = trim($this->findCsvMatch($row, 'support_url'));
        $this->item['warranty_lookup_url'] = trim($this->findCsvMatch($row, 'warranty_lookup_url'));
        $this->item['notes'] = trim($this->findCsvMatch($row, 'notes'));


        Log::debug('Item array is: ');
        Log::debug(print_r($this->item, true));


        if ($editingManufacturer) {
            Log::debug('Updating existing manufacturer');
            $manufacturer->update($this->sanitizeItemForUpdating($manufacturer));
        } else {
            Log::debug('Creating manufacturer');
            $manufacturer->fill($this->sanitizeItemForStoring($manufacturer));
        }

        if ($manufacturer->save()) {
            $this->log('Manufacturer ' . $manufacturer->name . ' created or updated from CSV import');
            return $manufacturer;
        } else {
            Log::debug($manufacturer->getErrors());
            $this->logError($manufacturer, 'Manufacturer "' . $this->item['name'] . '"');
            return $manufacturer->errors;
        }
    }
}
