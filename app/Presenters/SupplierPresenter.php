<?php

namespace App\Presenters;

/**
 * Class SupplierPresenter
 */
class SupplierPresenter extends Presenter
{
    public function coordinates()
    {
        if (empty($this->model->latitude) || empty($this->model->longitude)) {
            return null;
        }
        return $this->model->latitude . "," . $this->model->longitude;
    }
}
