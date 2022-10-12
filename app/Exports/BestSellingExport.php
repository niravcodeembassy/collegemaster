<?php

namespace App\Exports;

use App\Model\OrderItem;
use App\Setting;
use App\Model\Product;
use App\Model\Productvariant;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class BestSellingExport implements WithEvents, FromView
{

  use Exportable, RegistersEventListeners;

  public function view(): View
  {

    $item = Product::select(['products.id', 'products.name', 'products.sku', 'order_items.*'])
      ->rightJoin('order_items', DB::raw("json_extract(order_items.raw_data, '$[0].product_id')"), "=", "products.id")
      ->selectRaw('SUM(order_items.qty) AS quantity_sold')
      ->groupBy(['products.id']) // should group by primary key
      ->orderByDesc('quantity_sold')
      ->get();
    $title = 'BEST SELLING PRODUCT';

    return view('admin.export.selling', [
      'items' => $item,
      'title' => $title
    ]);
  }

  public static function afterSheet(AfterSheet $event)
  {
    // $sheet = $event->sheet;
    // $sheet->mergeCells('A1:u1');
    // $sheet->setCellValue('A1',  'Order GST Report');

    $cellRange = 'A1:e1'; // All headers

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