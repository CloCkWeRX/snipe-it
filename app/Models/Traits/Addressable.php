<?php
namespace App\Models\Traits;

/**
 * This trait allows Presenters to have a formatted address, coordinates.
 */
trait Addressable
{
    public function coordinates()
    {
        if (empty($this->model->latitude) || empty($this->model->longitude)) {
            return null;
        }
        return $this->model->latitude . "," . $this->model->longitude;
    }

    public function formattedAddress($separator = ", ")
    {
        $lines = [];
        if ($this->model->address) {
            $lines[] = $this->model->address;
        }
        if ($this->model->address2) {
            $lines[] = $this->model->address2;
        }
        $line3 = [];
        if ($this->model->city) {
            $line3[] = $this->model->city;
        }
        if ($this->model->state) {
            $line3[] = $this->model->state;
        }
        if ($this->model->zip) {
            $line3[] = $this->model->zip;
        }
        if (!empty($line3)) {
            $lines[] = implode(" ", $line3);
        }
        if ($this->model->country) {
            $lines[] = strtoupper($this->model->country);
        }

        return implode($separator, $lines);
    }
}
