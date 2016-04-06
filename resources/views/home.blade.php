@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <h3>Download Inventory files</h3>
                            <button type="button" class="btn btn-link"><a href="{{ url('/inventory') }}">Download Inventory files page</a></button>
                        </div>
                        <div class="col-sm-4">
                            <h3>Product Information</h3>
                            <button type="button" class="btn btn-link"><a href="{{ url('/product') }}">Product Information page</a></button>
                        </div>
                        <div class="col-sm-4">
                            <h3>Shipment Status</h3>
                            <button type="button" class="btn btn-link"><a href="{{ url('/shipment') }}">Shipment status page</a></button>        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
