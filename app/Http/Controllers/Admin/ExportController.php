<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Productvariant;
use App\Model\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Exports\OrderExport;
use App\Exports\CustomerExport;
use App\Exports\BestSellingExport;
use App\Exports\RefundReportExport;

class ExportController extends Controller
{
  public function exportExcel(Request $request)
  {
    $type = $request->export;
    if ($type == 'order') {
      try {
        return (new OrderExport)->download('order report.xlsx');
      } catch (\Exception $e) {
      }
    }

    if ($type == 'product') {
      try {
        return (new BestSellingExport())->download('selling product.xlsx');
      } catch (\Exception $e) {
      }
    }

    if ($type == 'refund') {
      try {
        return (new RefundReportExport())->download('refund report.xlsx');
      } catch (\Exception $e) {
      }
    }

    if ($type == 'customer') {
      try {
        return (new CustomerExport())->download('customer report.xlsx');
      } catch (\Exception $e) {
        dd($e);
      }
    }
  }

  public function exportPdf(Request $request)
  {
    $type = $request->export;
    if ($type == 'order') {
      try {
        return (new OrderExport)->download('order report.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
      } catch (\Exception $e) {
      }
    }

    if ($type == 'product') {
      try {
        return (new BestSellingExport())->download('selling product.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
      } catch (\Exception $e) {
      }
    }

    if ($type == 'refund') {
      try {
        return (new RefundReportExport())->download('refund report.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
      } catch (\Exception $e) {
      }
    }
  }

  public function exportPrint()
  {
  }
}