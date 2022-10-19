<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Events\AfterSheet;
use App\User;

class CustomerExport implements FromView, WithEvents
{
  use Exportable, RegistersEventListeners;
  /**
   * @return \Illuminate\Support\Collection
   */
  public function view(): View
  {
    return view('admin.export.customer', [
      'customer' => User::where('is_admin', 0)->withCount('orders')->with('country')->get()
    ]);
  }

  public static function afterSheet(AfterSheet $event)
  {
    $sheet = $event->sheet;

    // $sheet->mergeCells('A1:u1');
    // $sheet->setCellValue('A1',  'Order GST Report');

    $cellRange = 'A1:F1'; // All headers

    $active_sheet = $event->sheet->getDelegate();

    $active_sheet->getStyle($cellRange)->getFont()->setSize(18);

    $centered_text = ['alignment' => [
      'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
      'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
    ]];
    $active_sheet->getParent()->getDefaultStyle()->applyFromArray($centered_text);
  }
}