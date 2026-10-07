<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KalenderController extends Controller
{
    public function getKegiatan(Request $request)
    {
        $dataKegiatan = DB::table('vw_kalender_landing_page')->get();

        $events = $dataKegiatan->map(function ($item) {
            return [
                'id'    => $item->{'ID Kegiatan'},
                'title' => $item->{'Nama Kegiatan'},
                'start' => $item->{'Tanggal Mulai'},
                'end'   => $item->{'Tanggal Selesai'}, 
                
                'extendedProps' => [
                    'jenis_kegiatan' => $item->{'Jenis Kegiatan'},
                    'lokasi'         => $item->{'Titik Lokasi'},
                    'koordinator'    => $item->{'Nama Karyawan Koordinator'},
                    'jumlah_peserta' => $item->{'Jumlah Peserta'},
                    'instansi'       => $item->{'Instansi'}
                ]
            ];
        });

        return response()->json($events);
    }
}