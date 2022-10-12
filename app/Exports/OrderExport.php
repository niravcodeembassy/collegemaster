<?php

namespace App\Exports;

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

class OrderExport implements WithEvents, WithHeadings, FromView
{

  use Exportable, RegistersEventListeners;

  public function headings(): array
  {
    return [
      "FIRST NAME",
      "LAST NAME",
      "MOBILE NO",
      "SHIPPING ADDRESS",
      "COUNTRY",
      "DATE",
      "ORDER NO",
      "ITEM NAME",
      "SIZE",
      "MATERIAL",
      "QUANTITY",
      "GST %",
      "RATE",
      "DISCOUNT",
      "NET AMOUNT",
      "CGST AMOUNT",
      "SGST AMOUNT",
      "IGST AMOUNT",
      "SUB TOTAL",
      "SHIPPING AMOUNT",
      "TOTAL AMOUNT",
    ];
  }

  public function view(): View
  {
    $setting = Setting::generalSettings()->first()->response;
    return view('admin.export.order', [
      'items' => OrderItem::whereNotNull('order_id')->with('order', 'order.user')->get(),
      'setting' => $setting
    ]);
  }

  public static function afterSheet(AfterSheet $event)
  {
    $sheet = $event->sheet;

    // $sheet->mergeCells('A1:u1');
    // $sheet->setCellValue('A1',  'Order GST Report');

    $cellRange = 'A1:u1'; // All headers

    $active_sheet = $event->sheet->getDelegate();

    $active_sheet->getStyle($cellRange)->getFont()->setSize(18);

    $centered_text = ['alignment' => [
      'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
      'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
    ]];

    $active_sheet->getParent()->getDefaultStyle()->applyFromArray($centered_text);

    $active_sheet->getPageSetup()
      ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
      ->setPaperSize(PageSetup::PAPERSIZE_A3);
  }
}