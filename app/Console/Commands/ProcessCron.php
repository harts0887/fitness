<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\Machine;

class ProcessCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:getlog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Log Attendance';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bermulai = now();

        $machine = Machine::All();
        // var_dump($machine);

        $date=date("Y-m-d H:i:s");
        $startTime=date("Y-m-d H:i:s");
        $return='';

        DB::beginTransaction();
        foreach ($machine as $val){
            try {
                $initial_store = $val->initial_store;
                $machine_number = $val->machine_number;
                $machine_type = $val->machine_type;
                $ip_address = $val->ip_address;
                $id = $val->id;

                $IP = $ip_address;
                $Key = '0';
                $port = '80';

                echo $initial_store.PHP_EOL;
                echo $ip_address.PHP_EOL;
                echo $machine_number.PHP_EOL;

                $Connect = fsockopen($IP, $port, $errno, $errstr, 1);
                echo $Connect.PHP_EOL;
                if($Connect) {
                    $soapRequest = "<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">" . $Key . "</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
                    $newLine = "\r\n";

                    fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
                    fputs($Connect, "Content-Type: text/xml" . $newLine);
                    fputs($Connect, "Content-Length: " . strlen($soapRequest) . $newLine . $newLine);
                    fputs($Connect, $soapRequest . $newLine);
                    
                    $buffer = "";
                    while($Response = fgets($Connect, 1024)) {
                        $buffer = $buffer . $Response;
                    }
                    $buffer = parse_data($buffer, "<GetAttLogResponse>","</GetAttLogResponse>");

                    $buffer = explode("\r\n", $buffer);

                    $search  = ['-', ':', ' '];
                    $temp_code= $initial_store.str_replace($search, '', $date).'CRON'; //14 Update Absen Code Absen Code
                    echo $temp_code.PHP_EOL;

                    for($i = 0; $i < count($buffer); $i++){
                        $data = parse_data($buffer[$i], "<Row>", "</Row>");
                        $PIN = parse_data($data, "<PIN>", "</PIN>");
                        $DateTime = parse_data($data, "<DateTime>", "</DateTime>");
                        $Verified = parse_data($data, "<Verified>", "</Verified>");
                        $Status = parse_data($data, "<Status>", "</Status>");
                        $code= $initial_store.$PIN.str_replace($search, '', $DateTime); //14 Update Absen Code Absen Code

                        if ($PIN != ''){

                            DB::table('absen_log_temp')->insert(
                                [
                                'text_1' => $data,
                                'text_2' => $PIN,
                                'text_3' => $DateTime,
                                'text_4' => $Verified,
                                'text_5' => $Status,
                                'text_6' => $code,
                                'text_7' => $initial_store,
                                'text_8' => $machine_number,
                                // 'text_9' => ,
                                'temp_code' => $temp_code
                                ]
                            );
                        }
                    }

                    $saveLog = DB::select("INSERT into absen_log(site_code,absen_code,mesin_number,pin,date_time,ver,status_absen_id,get_nik,tanggal, created_at)
                    select aa.text_7, aa.text_6, $machine_number, aa.text_2, aa.text_3::timestamp, aa.text_4::integer, aa.text_5::integer, b.nik, text_3::date, now() from
                    (select * from absen_log_temp where temp_code = '$temp_code' and concat(text_2,text_7) in 
                    (select concat(fingerprint_id, initial_store) from karyawan )) aa
                    left join karyawan b on aa.text_2 = b.fingerprint_id and aa.text_7 = b.initial_store
                    on conflict(absen_code) do nothing
                    ");

                    DB::table("absen_log_temp")->where('temp_code',$temp_code)->delete();

                }else{
                    $return = FALSE;
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                $error = 'Ada Error : Cabang '.$initial_store.' No Mesin '.$machine_number.PHP_EOL;
                echo $error.PHP_EOL;
            }
        }

        $berakhir = now();
        $text = '#EndProcess Ambil Log Absen, Mulai : '.$bermulai.' Berakhir : '.$berakhir;

        echo $text.PHP_EOL;
    }
}
