@extends('layouts.app')

@section('content')
<!-- The user can get our real time stock in specified product.
 http://affiliate.strawberrynet.com/affiliate/cgi/directListXML.aspx?siteID=shopbxb&langID=1&currency=US$&prodID=112079
-->
<div class="container">
	<div class = "panel panel-primary">
	   <div class = "panel-heading">
	      <h1 class = "panel-title">Product Information</h1>
	   </div>	   
	   <div class = "panel-body">	
			<form id="product-information-form">
			    <p>Language:</p>
			    <select style="color: 2b3073; width: 152; font-size: 13; font-family: Arial;" name="langID" form="product-information-form">
			        <option value="1">English</option>
			        <option value="120">Arabic</option>
			        <option value="10">Chinese</option>
			        <option value="150">Czech</option>
			        <option value="240">Greek</option>
			        <option value="190">Hindi</option>
			        <option value="350">Indonesian</option>
			        <option value="20">Japanese</option>
			        <option value="30">Korean</option>
			        <option value="310">Malaysian</option>
			        <option value="160">Norwegian</option>
			        <option value="370">Persian</option>
			        <option value="140">Polish</option>
			        <option value="130">Portuguese</option>
			        <option value="210">Romanian</option>
			        <option value="100">Russian</option>
			        <option value="80">SimpChinese</option>
			        <option value="60">Spanish</option>
			        <option value="110">Thai</option>
			        <option value="90">Turkish</option>
			    </select>
			    <p>Currency:</p>
			    <select style="color: #012950; width: 215; font-size: 13; font-family: Arial;" name="curID" form="product-information-form">
			        <option value="US$">US Dollar (US$)</option>
			        <option value="AUD">Australian Dollar (AUD)</option>
			        <option value="CAD">Canadian Dollar (CAD)</option>
			        <option value="CNY">Chinese Yuan (CNY)</option>
			        <option value="EUR">Euro (EUR)</option>
			        <option value="HKD">Hong Kong Dollar (HKD)</option>
			        <option value="KRW">South Korean Won (KRW)</option>
			        <option value="GBP">UK Pound</option>
			        <option value="JPY">Japanese Yen</option>
			    </select>
			    <p>Product ID:</p>
			    <input name="prodID" type="text" value="" required/>
			    <br><br>
			    <input type="submit" value="Find Product">
			</form>
			<br/>
			<table class="table table-striped">
			    <thead>
			      <tr>
			        <th>ProdId</th>
			        <th>ProdNum</th>
			        <th>ProdBrandLangName</th>
			        <th>ProdLineLangName</th>
			        <th>ProdCatgName</th>
			        <th>ProdLangSize</th>
			        <th>InvQty</th>
			        <th>SellingPrice</th>
			        <th>RefPrice</th>
			        <th>Currency</th>
			        <th>ImageURL</th>
			        <th>Description</th>
			      </tr>
			    </thead>
			    <tbody id="product-info-response">
			    </tbody>
		    </table>
	   </div>
	</div>
	<br/>
	<div id = "debug-box">
		<div class="alert alert-info fade in">
		    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		    <strong>Coming soon ...</strong>
		</div> 
	  {{-- <div class="alert alert-success fade in">
	    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	    <strong>Success!</strong> This alert box could indicate a successful or positive action.
	  </div>
	  <div class="alert alert-warning fade in">
	    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	    <strong>Warning!</strong> This alert box could indicate a warning that might need attention.
	  </div>
	  <div class="alert alert-danger fade in">
	    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	    <strong>Danger!</strong> This alert box could indicate a dangerous or potentially negative action.
	  </div> --}}
	</div>
</div>
@endsection