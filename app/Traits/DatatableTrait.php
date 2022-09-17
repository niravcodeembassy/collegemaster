<?php

namespace App\Traits;

use Storage;

trait DatatableTrait
{

  public function checkBox($id)
  {
    return '<div class="checkbox-zoom zoom-primary m-0">
            <label class="m-0">
                <input type="checkbox" value="' . $id . '" class="custome-checkbox is_check" name="ids[]" id="variants_id_' . $id . '" >
                <span class="cr m-0">
                    <i class="cr-icon ik ik-check txt-primary"></i>
                </span>
            </label>
        </div>';
  }

  public function image($dir, $image, $width = '20%')
  {
    if ($dir == 'product_image') {
      $exist =  $image;
    } else {
      $exist = $dir . '/' . $image;
    }

    if (is_null($image) || !Storage::disk('public')->exists($exist)) {
      $img_url =  asset('storage/default/default.png');
    }

    if (!is_null($image) && Storage::disk('public')->exists($exist)) {
      $img_url =  asset('storage/' . $exist);
    }

    return '
            <div class="text-center">
                <img src="' . $img_url . '" style="width:' . $width . '" alt="">
            </div>
        ';
  }

  public function action($data)
  {

    return view('component.action')->with('list_item', array_filter($data))->render();
  }

  public function permition($id)
  {
    return '<a href="' . route('admin.role.show', ['role' => $id]) . '"
            class="btn btn-sm shadow btn-primary text-center mx-2"><i class="fa fa-key"></i></a>';
  }

  public function status($isYes, $id, $url, $item = NULL)
  {


    if ($isYes !== NULL) {

      $isYes = '<div class="material-switch pull-right">
                <input id="status_' . $id . '" name="status_' . $id . '" data-url="' . $url . '" class="change-status" type="checkbox"  value="' . $id . '" />
                <label for="status_' . $id . '" class="label-success"></label>
            </div>';
    } else {

      $isYes = '<div class="material-switch pull-right">
                <input id="status_' . $id . '" name="status_' . $id . '" data-url="' . $url . '" class="change-status" type="checkbox" value="' . $id . '"  checked />
                <label for="status_' . $id . '" class="label-success"></label>
            </div>';
    }

    return $isYes;
  }



  public function text($item, $class = NULL)
  {
    return  '<p class="' . $class . '">' . $item . '</p>';
  }
}
