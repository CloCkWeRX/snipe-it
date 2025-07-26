@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{ $manufacturer->name }}
 {{ trans('general.manufacturer') }}
@parent
@stop

@section('header_right')

  <a href="{{ route('manufacturers.index') }}" class="btn btn-primary text-right" style="margin-right: 10px;">{{ trans('general.back') }}</a>


  <div class="btn-group pull-right">
     <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
     <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
        <li><a href="{{ route('manufacturers.edit', $manufacturer->id) }}">{{ trans('admin/manufacturers/table.update') }}</a></li>
        <li><a href="{{ route('manufacturers.create') }}">{{ trans('admin/manufacturers/table.create') }}</a></li>
      </ul>
  </div>
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">
    <div class="nav-tabs-custom">

      <ul class="nav nav-tabs">
        <li class="active">

          <a href="#assets" data-toggle="tab">
            <span class="hidden-lg hidden-md">
              <i class="fas fa-barcode fa-2x"></i>
            </span>
            <span class="hidden-xs hidden-sm">
                {{ trans('general.assets') }}
                {!! ($manufacturer->assets()->AssetsForShow()->count() > 0 ) ? '<badge class="badge badge-secondary">'.number_format($manufacturer->assets()->AssetsForShow()->count()).'</badge>' : '' !!}
            </span>
          </a>

        </li>
        <li>
          <a href="#licenses" data-toggle="tab">
            <span class="hidden-lg hidden-md">
               <x-icon type="licenses" class="fa-2x" />
            </span>
            <span class="hidden-xs hidden-sm">
              {{ trans('general.licenses') }}
              {!! ($manufacturer->licenses->count() > 0 ) ? '<badge class="badge badge-secondary">'.number_format($manufacturer->licenses->count()).'</badge>' : '' !!}
            </span>

          </a>
        </li>
        <li>
          <a href="#accessories" data-toggle="tab">

             <span class="hidden-lg hidden-md">
              <x-icon type="accessories" class="fa-2x" />
            </span>
            <span class="hidden-xs hidden-sm">
              {{ trans('general.accessories') }}
              {!! ($manufacturer->accessories->count() > 0 ) ? '<badge class="badge badge-secondary">'.number_format($manufacturer->accessories->count()).'</badge>' : '' !!}
            </span>
          </a>
        </li>
        <li>
          <a href="#consumables" data-toggle="tab">

             <span class="hidden-lg hidden-md">
               <x-icon type="consumables" class="fa-2x" />
            </span>
            <span class="hidden-xs hidden-sm">
              {{ trans('general.consumables') }}
              {!! ($manufacturer->consumables->count() > 0 ) ? '<badge class="badge badge-secondary">'.number_format($manufacturer->consumables->count()).'</badge>' : '' !!}
            </span>
          </a>
        </li>

        <li>
          <a href="#components" data-toggle="tab">

             <span class="hidden-lg hidden-md">
               <x-icon type="components" class="fa-2x" />
            </span>
            <span class="hidden-xs hidden-sm">
              {{ trans('general.components') }}
              {!! ($manufacturer->components->count() > 0 ) ? '<badge class="badge badge-secondary">'.number_format($manufacturer->components->count()).'</badge>' : '' !!}
            </span>

          </a>
        </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane fade in active" id="assets">

          @include('partials.asset-bulk-actions')
          <div class="table table-responsive">
          <table
                  data-columns="{{ \App\Presenters\AssetPresenter::dataTableLayout() }}"
                  data-cookie-id-table="assetsListingTable"

                  data-id-table="assetsListingTable"
                  data-toolbar="#assetsBulkEditToolbar"
                  data-bulk-button-id="#bulkAssetEditButton"
                  data-bulk-form-id="#assetsBulkForm"
                  data-search="true"
                  data-search-highlight="true"
                  data-show-print="true"
                  data-side-pagination="server"
                  data-side-pagination="server"
                  data-sort-order="asc"
                  id="assetsListingTable"
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.assets.index', ['manufacturer_id' => $manufacturer->id, 'itemtype' => 'assets']) }}"
                  data-export-options='{
              "fileName": "export-manufacturers-{{ str_slug($manufacturer->name) }}-assets-{{ date('Y-m-d') }}",
              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
              }'>
          </table>
          </div>

        </div> <!-- /.tab-pane assets -->

        <div class="tab-pane fade" id="licenses">

          <table
                  data-columns="{{ \App\Presenters\LicensePresenter::dataTableLayout() }}"
                  data-cookie-id-table="licensesTable"

                  data-id-table="licensesTable"



                  data-show-footer="true"
                  data-side-pagination="server"
<<<<<<< HEAD
                  data-show-columns="true"
                  data-show-export="true"
                  data-show-refresh="true"
                  data-show-fullscreen="true"
=======



>>>>>>> 9c61d2eb22e545e6b24df1ac7482a36a7fa2eb96
                  data-sort-order="asc"
                  id="licensesTable"
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.licenses.index', ['manufacturer_id' => $manufacturer->id]) }}"
                  data-export-options='{
              "fileName": "export-manufacturers-{{ str_slug($manufacturer->name) }}-licenses-{{ date('Y-m-d') }}",
              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
              }'>
          </table>


        </div><!-- /.tab-pan licenses-->

        <div class="tab-pane fade" id="accessories">

          <table
                  data-columns="{{ \App\Presenters\AccessoryPresenter::dataTableLayout() }}"
                  data-cookie-id-table="accessoriesTable"

                  data-id-table="accessoriesTable"



                  data-show-footer="true"
                  data-side-pagination="server"
<<<<<<< HEAD
                  data-show-columns="true"
                  data-show-export="true"
                  data-show-refresh="true"
                  data-show-fullscreen="true"
=======



>>>>>>> 9c61d2eb22e545e6b24df1ac7482a36a7fa2eb96
                  data-sort-order="asc"
                  id="accessoriesTable"
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.accessories.index', ['manufacturer_id' => $manufacturer->id]) }}"
                  data-export-options='{
              "fileName": "export-manufacturers-{{ str_slug($manufacturer->name) }}-accessories-{{ date('Y-m-d') }}",
              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
              }'>
          </table>


        </div> <!-- /.tab-pan accessories-->

        <div class="tab-pane fade" id="consumables">

          <table
                  data-columns="{{ \App\Presenters\ConsumablePresenter::dataTableLayout() }}"
                  data-cookie-id-table="consumablesTable"

                  data-id-table="consumablesTable"



                  data-show-footer="true"
                  data-side-pagination="server"
<<<<<<< HEAD
                  data-show-columns="true"
                  data-show-export="true"
                  data-show-refresh="true"
                  data-show-fullscreen="true"
=======



>>>>>>> 9c61d2eb22e545e6b24df1ac7482a36a7fa2eb96
                  data-sort-order="asc"
                  id="consumablesTable"
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.consumables.index', ['manufacturer_id' => $manufacturer->id]) }}"
                  data-export-options='{
              "fileName": "export-manufacturers-{{ str_slug($manufacturer->name) }}-consumables-{{ date('Y-m-d') }}",
              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
              }'>
          </table>

        </div> <!-- /.tab-pan consumables-->

        <div class="tab-pane fade" id="components">

          <table
                  data-columns="{{ \App\Presenters\ComponentPresenter::dataTableLayout() }}"
                  data-cookie-id-table="componentsTable"

                  data-id-table="componentsTable"



                  data-show-footer="true"
                  data-side-pagination="server"
<<<<<<< HEAD
                  data-show-columns="true"
                  data-show-export="true"
                  data-show-refresh="true"
                  data-show-fullscreen="true"
=======



>>>>>>> 9c61d2eb22e545e6b24df1ac7482a36a7fa2eb96
                  data-sort-order="asc"
                  id="componentsTable"
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.components.index', ['manufacturer_id' => $manufacturer->id]) }}"
                  data-export-options='{
              "fileName": "export-manufacturers-{{ str_slug($manufacturer->name) }}-components-{{ date('Y-m-d') }}",
              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
              }'>
          </table>

        </div> <!-- /.tab-pan consumables-->

      </div> <!-- /.tab-content -->
    </div>  <!-- /.nav-tabs-custom -->
  </div><!-- /. col-md-9 -->

  <div class="col-md-3">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-default">
          <div class="box-header with-border">
            <div class="box-heading">
                <h2 class="box-title"> {{ trans('general.moreinfo') }}:</h2>
            </div>
          </div><!-- /.box-header -->
          
          <div class="box-body">

            @if ($manufacturer->image)
                <img src="{{ Storage::disk('public')->url(app('manufacturers_upload_path').e($manufacturer->image)) }}" class="img-responsive"></li>
            @endif


            <ul class="list-unstyled" style="line-height: 25px;">
                @if ($manufacturer->url)
                    <li>
                        <i class="fas fa-globe-americas"></i> <a href="{{ $manufacturer->url }}">{{ $manufacturer->url }}</a>
                    </li>
                @endif

                @if ($manufacturer->support_url)
                    <li>
                        <x-icon type="more-info" /> <a href="{{ $manufacturer->support_url }}">{{ $manufacturer->support_url }}</a>
                    </li>
                @endif

                @if ($manufacturer->support_phone)
                    <li>
                        <i class="fas fa-phone"></i>
                        <a href="tel:{{ $manufacturer->support_phone }}">{{ $manufacturer->support_phone }}</a>

                    </li>
                @endif

                @if ($manufacturer->support_email)
                    <li>
                        <i class="far fa-envelope"></i> <a href="mailto:{{ $manufacturer->support_email }}">{{ $manufacturer->support_email }}</a>
                    </li>
                @endif


                @if ($manufacturer->notes)
                    <li>
                        <strong>{{ trans('general.notes') }}</strong>:
                        {!! nl2br(Helper::parseEscapedMarkedownInline($manufacturer->notes)) !!}
                    </li>
                @endif

                @if ($manufacturer->created_at)
                    <li>
                        <strong>{{ trans('general.created_at') }}</strong>:
                        {{ Helper::getFormattedDateObject($manufacturer->created_at, 'datetime', false) }}
                    </li>
                @endif

                @if ($manufacturer->adminuser)
                    <li>
                        <strong>{{ trans('general.created_by') }}</strong>:
                        {{ $manufacturer->adminuser->present()->name() }}
                    </li>
                @endif
            </ul>
          </div>
          </div>


        @can('update', \App\Models\Manufacturer::class)
              <div class="col-md-12" style="padding-bottom: 5px;">
                  <a href="{{ ($manufacturer->deleted_at=='') ? route('manufacturers.edit', $manufacturer->id) : '#' }}" style="width: 100%;" class="btn btn-sm btn-warning btn-social hidden-print{{ ($manufacturer->deleted_at!='') ? ' disabled' : '' }}">
                      <x-icon type="edit" />
                      {{ trans('admin/manufacturers/table.update') }}
                  </a>
              </div>
              @if ($manufacturer->url)
                  <div class="col-md-12" style="padding-bottom: 5px;">
                      <form action="{{route('manufacturers.parse', $manufacturer->id)}}" method="POST">
                          @csrf
                          <button style="width: 100%;" class="btn btn-sm btn-info btn-social hidden-print">
                              <x-icon type="info-circle" />
                              Update details from URL
                          </button>
                      </form>
                  </div>
              @endif
          @endcan
      </div>
    </div>
  </div>
</div> <!-- /.row -->
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'manufacturer' . $manufacturer->name . '-export', 'search' => false])

@stop
