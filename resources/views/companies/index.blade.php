@extends('layouts/default')

{{-- Page title --}}
@section('title')
  {{ trans('general.companies') }}
  @parent
@stop

{{-- Page content --}}
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-default">
        <div class="box-body">
            <table
              data-columns="{{ \App\Presenters\CompanyPresenter::dataTableLayout() }}"
              data-cookie-id-table="companiesTable"
              data-id-table="companiesTable"
              data-side-pagination="server"
              data-sort-order="asc"
              id="companiesTable"
              data-buttons="companyButtons"
              class="table table-striped snipe-table"
              data-url="{{ route('api.companies.index') }}"
              data-export-options='{
                        "fileName": "export-companies-{{ date('Y-m-d') }}",
                        "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                        }'>
            </table>
        </div>
      </div>
    </div>
    <div class="well">
      <h4>{{ trans('admin/companies/general.about_companies') }}</h4>
      <p>{{ trans('admin/companies/general.about_companies_description') }}</p>
    </div>
  </div>
@stop

@section('moar_scripts')
  @include ('partials.bootstrap-table')
@stop
