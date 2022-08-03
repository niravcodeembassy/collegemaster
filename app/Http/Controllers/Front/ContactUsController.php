<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Model\Contact;
use App\Model\Page;
use App\Model\Testimonial;
use App\Setting;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{

  public function index()
  {
    $this->data['title'] = 'Contact us';
    $this->data['contact'] = Setting::where('name', 'general_settings')->first()->response;
    return $this->view('frontend.contactus');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //

    $contact = new Contact();
    $contact->name = $request->name;
    $contact->email = $request->email;
    $contact->subject = $request->subject;
    $contact->comment = $request->message;
    $contact->phone = $request->mobile;
    $contact->save();

    return back()->with('success', 'Message sent successfully');
  }

  public function about(Request $request)
  {
    $page = Page::findOrFail(1);
    $d =  Page::whereIn('id', [1, 2, 3])->get();
    $this->data['page'] = $page;
    $this->data['title'] = 'About';
    $this->data['testimonial'] = Testimonial::whereNull('is_active')->get();
    return view('frontend.about', $this->data);
  }

  public function policy(Request $request)
  {
    $page = Page::findOrFail(2);
    $this->data['page'] = $page;
    $this->data['title'] = 'Policy';
    return view('frontend.policy', $this->data);
  }

  public function returnPolicy(Request $request)
  {
    $page = Page::findOrFail(3);
    $this->data['page'] = $page;
    $this->data['title'] = 'Shipping & Return Policy';
    return view('frontend.return', $this->data);
  }

  public function term(Request $request)
  {
    $page = Page::findOrFail(4);
    $this->data['page'] = $page;
    $this->data['title'] = 'Term and Conditions';
    return view('frontend.term', $this->data);
  }

  public function faq(Request $request)
  {
    $page = Page::findOrFail(5);
    $this->data['page'] = $page;
    $this->data['title'] = 'Frequent Ask Question';
    return view('frontend.faq', $this->data);
  }

  public function photoPolicy(Request $request)
  {
    $page = Page::findOrFail(6);
    $this->data['page'] = $page;
    $this->data['title'] = 'Photo Policy';
    return view('frontend.photo', $this->data);
  }
  public function cookiePolicy(Request $request)
  {
    $page = Page::findOrFail(7);
    $this->data['page'] = $page;
    $this->data['title'] = 'Cookie Policy';
    return view('frontend.cookie', $this->data);
  }

  public function placeOrder()
  {
    $page = Page::findOrFail(8);
    $this->data['page'] = $page;
    $this->data['title'] = 'Place Order';
    return view('frontend.place-order', $this->data);
  }
  public function sendPhoto()
  {
    $page = Page::findOrFail(9);
    $this->data['page'] = $page;
    $this->data['title'] = 'How To Send Us Photos';
    return view('frontend.send-photo', $this->data);
  }
  public function photoSend()
  {
    $page = Page::findOrFail(10);
    $this->data['page'] = $page;
    $this->data['title'] = 'How Many Photos To Send';
    return view('frontend.photo-send', $this->data);
  }
  public function saveChange()
  {
    $page = Page::findOrFail(11);
    $this->data['page'] = $page;
    $this->data['title'] = 'How To Send Us Changes';
    return view('frontend.save-change', $this->data);
  }
  public function deliveryTime()
  {
    $page = Page::findOrFail(12);
    $this->data['page'] = $page;
    $this->data['title'] = 'Estimated Delivery Time';
    return view('frontend.delivery-time', $this->data);
  }
}