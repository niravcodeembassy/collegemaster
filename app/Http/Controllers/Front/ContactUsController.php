<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Model\Contact;
use App\Model\Page;
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
    $page = Page::findOrfail(1);
    $this->data['page'] = $page;
    $this->data['title'] = 'About';
    return view('frontend.about', $this->data);
  }

  public function policy(Request $request)
  {
    $page = Page::findOrfail(2);
    $this->data['page'] = $page;
    $this->data['title'] = 'Policy';
    return view('frontend.policy', $this->data);
  }

  public function returnPolicy(Request $request)
  {
    $page = Page::findOrfail(3);
    $this->data['page'] = $page;
    $this->data['title'] = 'Shipping & Return Policy';
    return view('frontend.return', $this->data);
  }

  public function term(Request $request)
  {
    $page = Page::findOrfail(4);
    $this->data['page'] = $page;
    $this->data['title'] = 'Term and Conditions';
    return view('frontend.term', $this->data);
  }

  public function faq(Request $request)
  {
    $page = Page::findOrfail(5);
    $this->data['page'] = $page;
    $this->data['title'] = 'Frequent Ask Question';
    return view('frontend.faq', $this->data);
  }

  public function photoPolicy(Request $request)
  {
    $page = Page::findOrfail(6);
    $this->data['page'] = $page;
    $this->data['title'] = 'Photo Policy';
    return view('frontend.photo', $this->data);
  }
}