<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Model\Order;
use App\Model\OrderItem;
use App\Setting;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class RefundReportExport implements WithEvents, FromView
{

  use Exportable, RegistersEventListeners;

  public function view(): View
  {
    $setting = Setting::generalSettings()->first()->response;
    return view('admin.export.refund', [
      'items' => Order::Where('order_status', 'refund')->with('itemslists', 'user')->get(),
      'setting' => $setting
    ]);
  }

  public static function afterSheet(AfterSheet $event)
  {
    $sheet = $event->sheet;

    // $sheet->mergeCells('A1:u1');
    // $sheet->setCellValue('A1',  'Order GST Report');

    $cellRange = 'A1:l1'; // All headers

    $active_sheet = $event->sheet->getDelegate();

    $active_sheet->getStyle($cellRange)->getFont()->setSize(18);

    $centered_text = ['alignment' => [
      'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
      'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
    ]];

    $active_sheet->getParent()->getDefaultStyle()->applyFromArray($centered_text);

    $active_sheet->getPageSetup()
      ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
      ->setPaperSize(PageSetup::PAPERSIZE_A4);
  }
}