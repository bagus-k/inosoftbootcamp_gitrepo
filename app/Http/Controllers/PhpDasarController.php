<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhpDasarController extends Controller
{
    public function index(){
        $this->cetak();
    }

    public function cetak(){
        for($i=1; $i<=100; $i++){
            if($i % 3 == 0 && $i%5 == 0){
                $this->luasPersegi($i);
            }
            else if($i % 3 == 0){
                $this->luasLingkaran($i);
            }
            else if($i % 5 == 0){
                $this->kelilingLingkaran($i);
            }
        }
    }
    
    public function luasLingkaran(int $angka){
        $angka = $angka/3;
        $hasil = 3.14*$angka*$angka;
        echo number_format((float)$hasil, 2, '.', '')."<br>";
    }
    
    public function kelilingLingkaran(int $angka){
        $angka = $angka/5;
        $hasil =  3.14*(2*$angka);
        echo number_format((float)$hasil, 2, '.', '')."<br>";
    }
    
    public function luasPersegi(int $angka){
        $panjang = $angka/3;
        $lebar = $angka/5;
        $hasil =  $panjang*$lebar;
        echo number_format((float)$hasil, 2, '.', '')."<br>";

    }
}
