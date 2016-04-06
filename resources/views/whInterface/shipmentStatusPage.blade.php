@extends('layouts.app')

@section('content')
<div class="container">
<div class = "panel panel-primary">
   <div class = "panel-heading">
      <h1 class = "panel-title">Shipment Status</h1>
   </div>
    <div class="row panel-body">
        <div class="col-md-3" >
            <form id="shipment-information-form">
                <p>Start Date:</p>
                <input type="date" name="dateFrom" value="" />
                <p>End Date:</p>
                <input type="date" name="dateTo" value="" />
                
                <p>Site:</p>
                <select style="color: 2b3073; width: 152; font-size: 13; font-family: Arial;" name="siteID">
                    <option value="shopbxb">Global</option>
                    <option value="charliehung">China</option>
                    <option value="shopbxb1">Europe</option>
                </select>
                <br/>
                
                {{-- <p>Status:</p>
                <select name ="status" form="shipmentStatus">
                    <option value="0,1,2,4,5,6">All</option>
                    <option value="0">Processing</option>
                    <option value="1">Dispatched</option>
                    <option value="2">Waiting for Stock Purchase</option>
                    <option value="4">Partial Shipment</option>
                    <option value="5">Canceled due to out of stock</option>
                    <option value="6">Split Shipment</option>
                </select> --}}
                
                {{-- <p>Language:</p>
                <select name ="language">
                    <option value="en">English</option>
                    <option value="zh-TW">Chinese (Trad.)</option>
                    <option value="zh-CN">Chinese (Simp.)</option>
                    <option value="ja">Japanese</option>
                    <option value="ko">Korean</option>
                    <option value="de">German Deutsch</option>
                    <option value="es">Spanish Espanol</option>
                    <option value="it">Italian Italiano</option>
                </select> --}}
                
                {{-- <h2>Options</h2>
                <p>Order Number:</p>
                <input type="text" name="orderNumber" value="">
                <p>Reference Number:</p>
                <input type="text" name="referenceNumber" value=""><br><br> --}}
                <input type="hidden" name="remark" value="1">
                <input type="submit" value="Show Status">
            </form>
        </div>
        <div class="col-md-9" style="border: #E2D0D0 solid 1px; height: 393px; overflow: auto;">
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Order Date</th>
                    <th>Customer Name</th>
                    <th>Shipment Status</th>
                    <th>Shipment Date</th>
                    <th>Shipment RefNo</th>
                    <th>Courier</th>
                    <th>affiliate RefNo</th>
                  </tr>
                </thead>
                <tbody id="shipment-info-response">
                    
                </tbody>
            </table>    
        </div>
    </div>
​    <div id = "debug-box">
    
    </div>
</div>
</div>
@endsection
