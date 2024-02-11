<?php
use Illuminate\Support\Facades\Log;

/*function SendRequest($action,$data)
{  
        $host = '10.248.84.9';
        $port = '9010';
        $fp=fsockopen($host, $port,$errno,$errstr);
        if(!$fp)
        {
        echo "ERROR: $errno - $errstr<br />\n";
        }
    else
    {
        fputs($fp, $data);
       $buf = fgets($fp, 128);

        // while (!feof($fp)) {
         // $buf .= fgets($fp,128);
        //  } 
      
        fclose($fp);
   
    }
      $buf=substr($buf, 69,100);
    return $message= 'Request Received Successfully';

}*/

function SendRequestBlacklist($action,$data)
{  

    $host = env('PROVGW_IP', '127.0.0.1');
    $port = env('PROVGW_PORT', '80');
    $path = "/";

    if ($action=="ADD_BL") {
        $path = env('PROVGW_ADD_BL_PATH', '/blacklist/add');    
    } elseif ($action=="REMOVE_BL") {
        $path = env('PROVGW_REMOVE_BL_PATH', '/blacklist/remove');    
    } elseif ($action=="ADD_WL") {
        $path = env('PROVGW_ADD_WL_PATH', '/whitelist/add');  
    } elseif ($action=="REMOVE_WL") {
        $path = env('PROVGW_REMOVE_WL_PATH', '/whitelist/remove');  
    } elseif ($action=="CHANGE_FLOW") {
        $path = env('PROVGW_CHANGE_FLOW_PATH', '/updateEnabledFlow');  
    } elseif ($action=="SUB") {
        $path = env('PROVGW_SUB_PATH', '/subscribe');  
    } elseif ($action=="UNSUB") {
        $path = env('PROVGW_UNSUB_PATH', '/unsubscribe'); 
    }

    try {
        
        $fp=fsockopen($host, $port,$errno,$errstr);
        if(!$fp)
        {
        echo "ERROR: $errno - $errstr<br />\n";
        }
        
        else
        {
           $contentLength = strlen($data);
           fwrite($fp, "POST ".$path." HTTP/1.0\r\n");
           fwrite($fp, "Accept-Encoding: gzip,deflate\r\n");
           fwrite($fp, "Content-Type: application/json\r\n");
           fwrite($fp, "User-Agent: ICSPortal\r\n");
           fwrite($fp, "Content-Length: ".$contentLength."\r\n");
           fwrite($fp, "Connection: Close\r\n\r\n");
           fwrite($fp, $data);
           
           /*while (!feof($fp)) {
                echo fgets($fp, 128);
           }*/
           $buf = fgets($fp, 128);
           fclose($fp);
          
           
        }
        Log::info('['.auth()->user()->username.'] '.$action.' Response:'.$buf);
        return $message= 'Request Received Successfully. Response:'.$buf;
   }  catch (\Exception $e) {
        Log::info('['.auth()->user()->username.'] '.$action.' Error sending request to '.$host.' port '.$port);
        return "Error sending request to ".$host." port ".$port;
   }

}
function createRefID() {
        //$pattern = '%04x%04x-%04x-%04x-%04x-%04x%04x%04x';
        $pattern = 'WEB%04x%04x%04x';
        return sprintf($pattern,
                        // 32 bits for "time_low"
                        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                        // 16 bits for "time_mid"
                        mt_rand(0, 0xffff),
                        // 16 bits for "time_hi_and_version",
                        // four most significant bits holds version number 4
                        mt_rand(0, 0x0fff) | 0x4000,
                        // 16 bits, 8 bits for "clk_seq_hi_res",
                        // 8 bits for "clk_seq_low",
                        // two most significant bits holds zero and one for variant DCE1.1
                        mt_rand(0, 0x3fff) | 0x8000,
                        // 48 bits for "node"
                        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

//     function ttaRevenue()
//     {
// for($i=10; $i>=1;$i--)
//      {
//          $temp = strtotime("-$i day");
//          $dates=date("Y-m-d", $temp );
//           $month=date('m',strtotime($dates));
//          $rs=DB::connection('mysql3')->select(DB::raw("SELECT COUNT( * ) AS numberOfItems
// FROM core_cdr_$month WHERE opcode='CHARGE_RES' AND param2='NM'
//  AND LENGTH(param1)=20 AND DATE(created)='".$dates."'"));
// $NMchargedSuccess=$rs[0]->numberOfItems;
// $rs=DB::connection('mysql3')->select(DB::raw("SELECT COUNT( * ) AS numberOfItems
// FROM core_cdr_$month WHERE opcode='CHARGE_RES' AND param2='ACB'
//  AND LENGTH(param1)=20 AND DATE(created)='".$dates."'"));
// $ACBchargedSuccess=$rs[0]->numberOfItems;
//          $NmRevenue[$dates]=$NMchargedSuccess*0.20;
//          $AcbRevenue[$dates]=$ACBchargedSuccess*0.30;

//      }
//      $ttaRev = array('NmRevenue' =>$NmRevenue,'AcbRevenue'=>$AcbRevenue);
//     return $ttaRev;    

//    }

function TotalNmSuccessCharge()
{
     $rs=DB::connection('mysql3')->select(DB::raw("SELECT SUM(totalNmChargedSuccess) AS numberOfItems
FROM service_report_daily"));
$NMtotalRevenue=$rs[0]->numberOfItems;
$NMtotalRevenue=($NMtotalRevenue*0.18);
return $NMtotalRevenue;
}
function TotalAcbSuccessCharge()
{
     $rs=DB::connection('mysql3')->select(DB::raw("SELECT SUM(totalAcbChargedSuccess) AS numberOfItems
FROM service_report_daily"));
$AcbtotalRevenue=$rs[0]->numberOfItems;
$AcbtotalRevenue=($AcbtotalRevenue*0.18);
return $AcbtotalRevenue;
}
//date difference

function getMonthDiffFromDBFormattedDate($dateFrom, $dateTo) {
        
        if (strlen($dateFrom) >= 10 && strlen($dateTo) >= 10) {
            $mth1 = substr($dateFrom, 5, 2);
            $mth2 = substr($dateTo, 5, 2);
            $yr1 = substr($dateFrom, 0, 4);
            $yr2 = substr($dateTo, 0, 4);
            if ($yr2 > $yr1) {
                $xmth2 = $mth2 + (12 * ($yr2 - $yr1));
            } else if ($yr1 > $yr2) {
                return -1;
            } else {
                $xmth2 = $mth2;
            }
            $beza = $xmth2 - $mth1;
            return $beza;
        }
        return -1;
    }