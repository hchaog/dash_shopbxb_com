<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

ini_set('max_execution_time', 0);
ini_set('memory_limit', '512M');
//ini_set('pcre.backtrack_limit', '104857600');

class FormHandlerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function inventoryDownloadPostHandler()
    {
        $formData = Input::all();
        //check if currency is cny or hkd
        if(input::get('currency') == 'CNY' || input::get('currency') == 'HKD'){
            $formData['siteID'] = 'charliehung';
        }
        else{
            $formData['siteID'] = 'shopbxb';
        }

        //post form data to wh
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, getenv('WH_INVENTORY_DOWNLOAD_URL'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, urldecode(http_build_query($formData)));
        curl_setopt($ch, CURLOPT_HEADER, FALSE); 
        $xml = curl_exec($ch);

        //check header for encoding information
        $xmlheader = substr($xml, 0, 50);
        preg_match("/<\?xml version='1.0' encoding=\'(.*)\'\?>/", $xmlheader, $m);

        //find encoding type
        $encoding = $m[1];
        $xml = iconv("$encoding", "UTF-8//IGNORE", $xml);
        $xmlstr = str_replace("encoding='$encoding'", "encoding='UTF-8'", $xml);

        $products = simplexml_load_string($xmlstr,
            'SimpleXMLElement',
            LIBXML_NOERROR | LIBXML_ERR_NONE
        );

         //create a template file store inventory
        $tmpfname = tempnam(sys_get_temp_dir(), "inventory");
        $handle = fopen($tmpfname, "w");

        //create file name
        $filename = 'InventoryFile'.date("Y-m-d");

        switch (input::get('output')){
            case 'txt':
                header("Content-Type: text/plain; charset=utf-8");         
                header("Content-Disposition: attachment; filename=$filename.txt");
                // Disable caching
                header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
                header("Pragma: no-cache"); // HTTP 1.0
                header("Expires: 0"); // Proxies

                $txtfeed = "ProdId \t ProdNum \t ProdBrandLangName \t  ProdCatgName \t   ProdLineLangName  \t  ProdLangName  \t  ProdLangSize  \t  InvQty \t SellingPrice  \t  RefPrice \t   Currency \t  ImageURL  \t  PhotoDescription \t ProdBarCode \n";

                foreach ($products as $product){
                    if(input::get('imageurl') == 'yes'){
                        $product->ImageURL = 'http://54.169.174.109/image/catalog/products/'.$product->ProdId.'.jpg';
                    }
                    else{
                        $product->ImageURL = '';
                    }

                    if(input::get('description') !== 'yes'){
                        $product->PhotoDescription = '';
                    }

                    if(input::get('barcode') !== 'yes'){
                        $product->ProdBarCode = '';
                    }
                    //prepare txtfeed
                    $txtfeed .= (string)$product->ProdId."\t".
                            (string)$product->ProdNum."\t".
                            (string)$product->ProdBrandLangName."\t".
                            (string)$product->ProdCatgName."\t".
                            (string)$product->ProdLineLangName."\t".
                            (string)$product->ProdLangName."\t".
                            (string)$product->ProdLangSize."\t".
                            (string)$product->InvQty."\t".
                            (string)$product->SellingPrice."\t".
                            (string)$product->RefPrice."\t".
                            (string)$product->Currency."\t".
                            (string)$product->ImageURL."\t".
                            (string)$product->PhotoDescription."\t".
                            (string)$product->ProdBarCode."\n";
                }

                fwrite($handle, $txtfeed);
                break;
            case 'xml':
                header('Content-Type: text/xml; charset=utf-8');        
                header("Content-Disposition: attachment; filename=$filename.xml");
                // Disable caching
                header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
                header("Pragma: no-cache"); // HTTP 1.0
                header("Expires: 0"); // Proxies

                //prepare xmlfeed
                $xmlfeed = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
                $xmlfeed .= "\n <ProductFile>";

                foreach ($products as $product){
                    if(input::get('imageurl') == 'yes'){
                        $product->ImageURL = 'http://54.169.174.109/image/catalog/products/'.$product->ProdId.'.jpg';
                    }
                    else{
                        $product->ImageURL = '';
                    }

                    if(input::get('description') !== 'yes'){
                        $product->PhotoDescription = '';
                    }

                    if(input::get('barcode') !== 'yes'){
                        $product->ProdBarCode = '';
                    }

                    $xmlfeed .=  "<Item><ProdId>".(string)$product->ProdId."</ProdId><ProdNum>".(string)$product->ProdNum."</ProdNum><ProdBrandLangName>".(string)$product->ProdBrandLangName."</ProdBrandLangName><ProdLineLangName>".(string)$product->ProdCatgName."</ProdLineLangName><ProdLangName>".(string)$product->ProdLineLangName."</ProdLangName><ProdCatgName>".(string)$product->ProdLangName."</ProdCatgName><ProdLangSize>".(string)$product->ProdLangSize."</ProdLangSize><InvQty>".(string)$product->InvQty."</InvQty><SellingPrice>".(string)$product->SellingPrice."</SellingPrice><RefPrice>".(string)$product->RefPrice."</RefPrice><Currency>".(string)$product->Currency."</Currency><ImageURL>".(string)$product->ImageURL."</ImageURL><PhotoDescription>".str_replace('&', '&amp;', (string)$product->PhotoDescription)."</PhotoDescription><ProdBarCode>".(string)$product->ProdBarCode."</ProdBarCode></Item>";
                }

                $xmlfeed .= "\n </ProductFile>";
                fwrite($handle, $xmlfeed);
                break;
            case 'csv':
                header('Content-Encoding: UTF-8');
                header("Content-Type: text/csv; charset=UTF-8");
                header("Content-Disposition: attachment; filename=$filename.csv");
                // Disable caching
                header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
                header("Pragma: no-cache"); // HTTP 1.0
                header("Expires: 0"); // Proxies
                echo "\xEF\xBB\xBF";

                //prepare csvfeed
                $csvfeed = "ProdId, ProdNum, ProdBrandLangName, ProdCatgName, ProdLineLangName, ProdLangName, ProdLangSize, InvQty,SellingPrice, RefPrice, Currency, ImageURL, PhotoDescription, ProdBarCode\n";
                foreach ($products as $product){
                    if(input::get('imageurl') == 'yes'){
                        $product->ImageURL = 'http://54.169.174.109/image/catalog/products/'.$product->ProdId.'.jpg';
                    }
                    else{
                        $product->ImageURL = '';
                    }

                    if(input::get('description') !== 'yes'){
                        $product->PhotoDescription = '';
                    }

                    if(input::get('barcode') !== 'yes'){
                        $product->ProdBarCode = '';
                    }
                    //prepare csvfeed
                    $csvfeed .= (string)$product->ProdId.",".
                            (string)$product->ProdNum.",".
                            str_replace(',', ';', (string)$product->ProdBrandLangName).",".
                            str_replace(',', ';', (string)$product->ProdCatgName).",".
                            str_replace(',', ';', (string)$product->ProdLineLangName).",".
                            str_replace(',', ';', (string)$product->ProdLangName).",".
                            (string)$product->ProdLangSize.",".
                            (string)$product->InvQty.",".
                            (string)$product->SellingPrice.",".
                            (string)$product->RefPrice.",".
                            (string)$product->Currency.",".
                            (string)$product->ImageURL.",".
                            str_replace(',', ';', (string)$product->PhotoDescription).",".
                            (string)$product->ProdBarCode."\n";
                }

                fwrite($handle, $csvfeed);
                break;
            default:
                header('Content-Type: text/plain');      
                header('Content-Disposition: attachment; filename=example.txt');
                break;
        }

        readfile($tmpfname);
        fclose($handle); // this removes the file
    }

    public function productInformationPostRequest(){
        $formData = Input::all();
        $formData['siteID'] = 'shopbxb';

        //post form data to wh
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, getenv('WH_INVENTORY_DOWNLOAD_URL'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, urldecode(http_build_query($formData)));
        curl_setopt($ch, CURLOPT_HEADER, FALSE); 
        $xml = curl_exec($ch);


        $products = simplexml_load_string($xml,
            'SimpleXMLElement',
            LIBXML_NOERROR | LIBXML_ERR_NONE
        );

        //print_r($products);
    }

    public function shipmentInformationPostRequest(){
        $formData = Input::all();
        print_r($formData);

        //post form data to wh
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, getenv('WH_SHIPMENT_URL'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, urldecode(http_build_query($formData)));
        curl_setopt($ch, CURLOPT_HEADER, FALSE); 
        $xml = curl_exec($ch);

        $orders = simplexml_load_string($xml,
            'SimpleXMLElement',
            LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_NOCDATA
        );

        foreach ($orders as $order) {
            # code...
            echo '<tr>
                    <td>'.$order->OrderDate.'</td>
                    <td>'.$order->CustomerName.'</td>
                    <td>'.$order->ShipmentStatus.'</td>
                    <td>'.$order->ShipmentDate1.'</td>
                    <td>'.$order->ShipmentRefNo1.'</td>
                    <td>'.$order->Courier1.'</td>
                    <td>'.$order->affiliateRefNo.'</td>                   
                  </tr>';
        }
    }

}
