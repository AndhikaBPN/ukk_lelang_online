<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controller\HistoryController;
use PDF;

class PdfController extends Controller
{
    public function getPDF()
    {
        $pdf=PDF::loadview('pdf.history');
        return $pdf->stream('history.pdf');
    }
}
