@extends('frontend.layouts.app')
@section('content')


	<!--=============================================
	=            slider area         =
	=============================================-->
@if ($banner->count())
	<div class="slider-area mb-50">
		<div id="rev_slider_17_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="homepage-7"
			data-source="gallery"
			style="margin:0px auto;background:transparent;padding:0px;margin-top:0px;margin-bottom:0px;">
			<!-- START REVOLUTION SLIDER 5.4.7 fullwidth mode -->
			<div id="rev_slider_17_1" class="rev_slider fullwidthabanner" style="display:none;" data-version="5.4.7">
				<ul>
                       @foreach ($banner as $item)
					<!-- SLIDE  -->
					<li data-index="rs-{{$loop->iteration}}"
						data-transition="parallaxtoright,parallaxtoleft,parallaxtotop,parallaxtobottom,parallaxhorizontal,parallaxvertical,fadefromright,fadefromleft,fadefromtop,fadefrombottom"
						data-slotamount="default,default,default,default,default,default,default,default,default,default"
						data-hideafterloop="0" data-hideslideonmobile="off"
						data-easein="default,default,default,default,default,default,default,default,default,default"
						data-easeout="default,default,default,default,default,default,default,default,default,default"
						data-masterspeed="700,default,default,default,default,default,default,default,default,default"
						data-rotate="0,0,0,0,0,0,0,0,0,0" data-saveperformance="off" data-title="Slide" data-param1=""
						data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8=""
						data-param9="" data-param10="" data-description="">
						<!-- MAIN IMAGE -->
                        @if((new \Jenssegers\Agent\Agent())->isDesktop())


						<img 
                            
                        src="{{ $item->slider_image }}" alt=""     
							data-bgposition="center center" data-kenburns="on" data-duration="10000" data-ease="Linear.easeNone"
							data-scalestart="100" data-scaleend="110" data-rotatestart="0" data-rotateend="0" data-blurstart="0"
							data-blurend="0" data-offsetstart="0 0" data-offsetend="0 0" data-bgparallax="off" class="rev-slidebg"
							data-no-retina>
						<!-- LAYERS -->
                        @endif

                        @if((new \Jenssegers\Agent\Agent())->isMobile())
                        <img 
                            
                        src="{{env('APP_URL')}}/storage/{{ $item->mobile_slider_image }}" alt=""     
							data-bgposition="center center" data-kenburns="on" data-duration="10000" data-ease="Linear.easeNone"
							data-scalestart="100" data-scaleend="110" data-rotatestart="0" data-rotateend="0" data-blurstart="0"
							data-blurend="0" data-offsetstart="0 0" data-offsetend="0 0" data-bgparallax="off" class="rev-slidebg"
							data-no-retina>
                        @endif


						<!-- LAYER NR. 1 -->
						<div class="tp-caption   tp-resizeme" id="slide-45-layer-13" data-x="['left','center','left','left']"
							data-hoffset="['375','-342','65','38']" data-y="['middle','top','top','top']"
							data-voffset="['-79','194','612','460']" data-fontsize="['24','24','24','20']"
							data-color="['rgb(51,51,51)','rgb(105,105,105)','rgb(105,105,105)','rgb(105,105,105)']" data-width="none"
							data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on"
							data-frames='[{"delay":1100,"speed":1790,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power4.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
							data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
							data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
							style="z-index: 5; white-space: nowrap; font-size: 24px; line-height: 36px; font-weight: 600; color: #333333; letter-spacing: 5px;font-family:Work Sans;">
                            </div>

						<!-- LAYER NR. 2 -->
						<div class="tp-caption   tp-resizeme" id="slide-45-layer-3" data-x="['left','center','center','left']"
							data-hoffset="['372','-224','-111','36']" data-y="['top','middle','middle','top']"
							data-voffset="['314','-103','215','508']" data-fontsize="['56','56','56','40']"
							data-lineheight="['56','60','60','60']" data-width="none" data-height="none" data-whitespace="nowrap"
							data-type="text" data-responsive_offset="on"
							data-frames='[{"delay":680,"speed":1750,"frame":"0","from":"z:0;rX:0;rY:0;rZ:0;sX:0.9;sY:0.9;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power2.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
							data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
							data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
							style="z-index: 6; white-space: nowrap; font-size: 56px; line-height: 56px; font-weight: 300; color: #333333; letter-spacing: 0px;font-family:Work Sans;">
							 {!! $item->title !!} </div>
                        @if($item->btn_name && $item->btn_url)
                            <div class="tp-caption button-under-line  rev-btn  tp-resizeme" id="slide-45-layer-20"
                                data-x="['left','center','center','left']" data-hoffset="['372','-369','-246','39']"
                                data-y="['top','top','top','top']" data-voffset="['416','362','781','607']" data-width="none"
                                data-height="none" data-whitespace="nowrap" data-type="button" data-actions='' data-responsive_offset="on"
                                data-frames='[{"delay":1100,"speed":1790,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"},{"frame":"hover","speed":"300","ease":"Linear.easeNone","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgb(211,18,42);bc:rgb(211,18,42);"}]'
                                data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                                data-paddingright="[0,0,0,0]" data-paddingbottom="[3,3,3,3]" data-paddingleft="[0,0,0,0]"
                                style="z-index: 7; white-space: nowrap; letter-spacing: 1px;border-color:rgb(51,51,51);outline:none;box-shadow:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer;">
                                <a class="revslider-button-red text-capitalize" href="{{$item->btn_url}}"> {{$item->btn_name}} </a>
                            </div>
                        @endif
                    </li>
                    @endforeach
				</ul>
				<div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>
			</div>
		</div><!-- END REVOLUTION SLIDER -->
	</div>

	<!--=====  End of slider area  ======-->
@endif
    <div class="icon-box-area icon-box-area--feature-icon pt-20 pb-20 mb-50">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-md-30 mb-sm-30">
                    <!--=======  single icon box  =======-->

                    <div class="single-icon-box single-icon-box--feature-icon">
                        <div class="icon-box-icon">
                            <i class="fa fa-money"></i>
                        </div>
                        <div class="icon-box-content">
                            <h3 class="title ">MONEY BACK</h3>
                            <p class="content mt-0">100% money back guarantee</p>
                        </div>
                    </div>

                    <!--=======  End of single icon box  =======-->
                </div>
                <div class="col-md-4 mb-md-30 mb-sm-30">
                    <!--=======  single icon box  =======-->

                    <div class="single-icon-box single-icon-box--feature-icon">
                        <div class="icon-box-icon">
                            <i class="fa fa-shopping-basket"></i>
                        </div>
                        <div class="icon-box-content">
                            <h3 class="title">FREE SHIPPING &amp; RETURN</h3>
                            <p class="content  mt-0">Free shipping on all orders over $99</p>
                        </div>
                    </div>


                    <!--=======  End of single icon box  =======-->
                </div>
                <div class="col-md-4 mb-md-30 mb-sm-30">
                    <!--=======  single icon box  =======-->

                    <div class="single-icon-box single-icon-box--feature-icon">
                        <div class="icon-box-icon">
                            <i class="fa fa-life-ring"></i>
                        </div>
                        <div class="icon-box-content">
                            <h3 class="title">24/7 SUPPORT</h3>
                            <p class="content  mt-0">Live fast and good support 24/7.</p>
                        </div>
                    </div>
                    <!--=======  End of single icon box  =======-->
                </div>
            </div>
        </div>
    </div>

    @if ($commonBanner->count() > 0)
        <div class="section-title-container mb-30 mb-md-30 mb-sm-30">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!--=======  section title  =======-->
                        <div class="section-title section-title--one text-center">
                            <h1>Clever & unique ideas</h1>
                        </div>
                        <!--=======  End of section title  =======-->
                    </div>
                </div>
            </div>
        </div>

        <div class="hover-banner-area mb-65 mb-md-45 mb-sm-45">
            <div class="container wide">
                <div class="row">
                    @foreach ($commonBanner as $item)
                        <div class="col-md-4 mb-30">
                            <!--=======  single category  =======-->
                            <div class="single-category single-category--three">
                                <!--=======  single category image  =======-->
                                <div class="single-category__image single-category__image--three single-category__image--three--creativehome single-category__image--three--banner">
                                    <img src="{{ $item->banner_image }}" class="img-fluid" alt="">
                                </div>
                                <!--=======  single category content  =======-->
                                <div class="single-category__content single-category__content--three single-category__content--three--creativehome  single-category__content--three--banner mt-25 mb-25">
                                    <div class="title">
                                        <p><a href="{{$item->url}}">{{ $item->caption1 ?? '' }} <span>{{ $item->caption2 ?? '' }}</span></a></p>
                                        @if ($item->url)
                                            <a href="{{$item->url}}">{{ $item->caption3 ?? '' }}</a>
                                        @endif
                                    </div>
                                </div>
                                <!--=======  banner-link  =======-->
                                @if ($item->url)
                                    <a href="{{$item->url}}" class="banner-link"></a>
                                @endif
                                <!--=======  End of banner-link  =======-->
                            </div>
                            <!--=======  End of single category  =======-->
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <!--=====  End of banner category area  ======-->

    {{-- <!--=============================================
         =            section title  container      =
         =============================================-->
    <div class="section-title-container mb-70 mb-md-50 mb-sm-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!--=======  section title  =======-->
                    <div class="section-title section-title--one text-center">
                        <h1>Popular this week</h1>
                        <p class="subtitle subtitle--deep mb-0">GIFT MASTER STORE - SIMPLY AND BASIC</p>
                    </div>
                    <!--=======  End of section title  =======-->
                </div>
            </div>
        </div>
    </div>
    <!--=====  End of section title container ======-->
    <!--=============================================
         =            product carousel container         =
         =============================================-->
    <div class="product-carousel-container product-carousel-container--smarthome mb-35 mb-md-0 mb-sm-0">
        <div class="row">
            <div class="col-lg-12">
                <!--=======  product carousel  =======-->
                <div class="lezada-slick-slider product-carousel product-carousel--smarthome" data-slick-setting='{
                  "slidesToShow": 5,
                  "slidesToScroll": 5,
                  "arrows": false,
                  "dots": true,
                  "autoplay": false,
                  "autoplaySpeed": 5000,
                  "speed": 1000,
                  "prevArrow": {"buttonClass": "slick-prev", "iconClass": "ti-angle-left" },
                  "nextArrow": {"buttonClass": "slick-next", "iconClass": "ti-angle-right" }
                  }' data-slick-responsive='[
                  {"breakpoint":1501, "settings": {"slidesToShow": 5, "arrows": false} },
                  {"breakpoint":1199, "settings": {"slidesToShow": 4, "arrows": false} },
                  {"breakpoint":991, "settings": {"slidesToShow": 3,"slidesToScroll": 3, "arrows": false} },
                  {"breakpoint":767, "settings": {"slidesToShow": 2, "slidesToScroll": 2, "arrows": false} },
                  {"breakpoint":575, "settings": {"slidesToShow": 2, "slidesToScroll": 2,  "arrows": false} },
                  {"breakpoint":479, "settings": {"slidesToShow": 1, "slidesToScroll": 1, "arrows": false} }
                  ]'>
                    @foreach ($product as $item)
                        <!--=======  single product  =======-->
                        <div class="col">
                            @include('frontend.product.partial.singleproduct' ,[
                                'product' => $item
                            ])
                        </div>
                        <!--=======  End of single product  =======-->
                   @endforeach
                </div>
                <!--=======  End of product carousel  =======-->
            </div>
        </div>
    </div> --}}
    <!--=====  End of product carousel container  ======-->
    {{-- <!--=============================================
         =            sofa banner rev         =
         =============================================-->
    @php
        $lastBanner = $commonBanner->last();
    @endphp
    <div class="sofa-banner-rev mb-100 mb-md-80 mb-sm-80">
        <div id="rev_slider_19_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="banner-sofa"
            data-source="gallery"
            style="margin:0px auto;background:transparent;padding:0px;margin-top:0px;margin-bottom:0px;">
            <!-- START REVOLUTION SLIDER 5.4.7 fullwidth mode -->

            <div id="rev_slider_19_1" class="rev_slider fullwidthabanner" style="display:none;" data-version="5.4.7">
                <ul>
                    <!-- SLIDE  -->
                    <li data-index="rs-49" data-transition="fade" data-slotamount="default" data-hideafterloop="0"
                        data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="470"
                        data-rotate="0" data-saveperformance="off" data-title="Slide" data-param1="" data-param2=""
                        data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8=""
                        data-param9="" data-param10="" data-description="">
                        <!-- MAIN IMAGE -->
                        <img src="assets/images/revimages/transparent.png" data-bgcolor='#ffffff'
                            style='background:#ffffff' alt="" data-bgposition="center center" data-bgfit="cover"
                            data-bgrepeat="no-repeat" data-bgparallax="off" class="rev-slidebg" data-no-retina>
                        <!-- LAYERS -->
                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption tp-shape tp-shapewrapper  tp-resizeme" id="slide-49-layer-1"
                            data-x="['right','right','right','right']" data-hoffset="['0','0','0','0']"
                            data-y="['top','top','top','top']" data-voffset="['49','70','70','70']"
                            data-width="['1250','708','708','379']" data-height="['540','541','541','290']"
                            data-whitespace="nowrap" data-type="shape" data-responsive_offset="on"
                            data-frames='[{"delay":410,"speed":1000,"frame":"0","from":"x:50px;opacity:0;","to":"o:1;","ease":"Power2.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                            data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                            data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                            style="z-index: 5;background-color:rgb(236,244,246);"> </div>
                        <!-- LAYER NR. 2 -->
                        <div class="tp-caption   tp-resizeme rs-parallaxlevel-1" id="slide-49-layer-4"
                            data-x="['left','left','left','left']" data-hoffset="['756','190','49','33']"
                            data-y="['top','top','top','top']" data-voffset="['346','458','463','469']"
                            data-width="none" data-height="none" data-whitespace="nowrap" data-type="image"
                            data-responsive_offset="on"
                            data-frames='[{"delay":610,"speed":2170,"frame":"0","from":"z:0;rX:0;rY:0;rZ:0;sX:0.9;sY:0.9;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power2.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                            data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                            data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                            style="z-index: 6;"><img src="{{ $lastBanner->banner_image }}" alt=""
                                data-ww="['1006px','762px','762px','422px']" data-hh="['429px','325px','325px','180px']"
                                data-no-retina>
                        </div>
                        <!-- LAYER NR. 3 -->
                        <div class="tp-caption   tp-resizeme" id="slide-49-layer-5"
                            data-x="['right','right','right','right']" data-hoffset="['0','-12','0','613']"
                            data-y="['top','top','top','top']" data-voffset="['150','316','331','297']"
                            data-fontsize="['200','150','130','130']" data-lineheight="['200','150','130','130']"
                            data-width="none" data-height="none" data-whitespace="nowrap" data-type="text"
                            data-responsive_offset="on"
                            data-frames='[{"delay":410,"speed":2020,"frame":"0","from":"x:50px;opacity:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                            data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                            data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                            style="z-index: 7; white-space: nowrap; font-size: 200px; line-height: 200px; font-weight: 600; color: #ffffff; letter-spacing: 0px;font-family:Work Sans;">
                            minimal
                        </div>
                        <!-- LAYER NR. 4 -->
                        <div class="tp-caption tp-shape tp-shapewrapper  tp-resizeme rs-parallaxlevel-1"
                            id="slide-49-layer-6" data-x="['left','left','left','left']"
                            data-hoffset="['1583','794','549','330']" data-y="['top','top','top','top']"
                            data-voffset="['315','406','407','394']" data-width="100" data-height="100"
                            data-whitespace="nowrap" data-type="shape" data-responsive_offset="on"
                            data-frames='[{"delay":800,"speed":1000,"frame":"0","from":"z:0;rX:0;rY:0;rZ:0;sX:0.9;sY:0.9;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power2.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                            data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                            data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                            style="z-index: 8;background-color:rgb(51,51,51);border-radius:50px 50px 50px 50px;"> </div>
                        <!-- LAYER NR. 5 -->
                        <div class="tp-caption   tp-resizeme rs-parallaxlevel-1" id="slide-49-layer-7"
                            data-x="['right','right','right','right']" data-hoffset="['263','156','156','76']"
                            data-y="['middle','middle','middle','middle']" data-voffset="['-49','41','41','29']"
                            data-width="none" data-height="none" data-whitespace="nowrap" data-type="text"
                            data-responsive_offset="on"
                            data-frames='[{"delay":970,"speed":1400,"frame":"0","from":"y:-50px;opacity:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                            data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                            data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                            style="z-index: 9; white-space: nowrap; font-size: 16px; line-height: 25px; font-weight: 400; color: #ffffff; letter-spacing: 1px;font-family:Work Sans;">
                            ONLY
                        </div>
                        <div class="tp-caption   tp-resizeme rs-parallaxlevel-1" id="slide-49-layer-8"
                            data-x="['right','right','right','right']" data-hoffset="['265','158','158','80']"
                            data-y="['middle','middle','middle','middle']" data-voffset="['-22','72','72','60']" data-width="none"
                            data-height="none" data-whitespace="nowrap" data-type="text" data-responsive_offset="on"
                            data-frames='[{"delay":970,"speed":1410,"frame":"0","from":"y:50px;opacity:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                            data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]"
                            data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                            style="z-index: 10; white-space: nowrap; font-size: 20px; line-height: 25px; font-weight: 700; color: #ffffff; letter-spacing: 1px;font-family:Work Sans;">
                            {{ $lastBanner->caption3 ?? '' }}
                        </div>

                        <!-- LAYER NR. 7 -->
                        <div class="tp-caption   tp-resizeme" id="slide-49-layer-9"
                            data-x="['left','left','left','left']" data-hoffset="['287','287','103','24']"
                            data-y="['top','top','top','top']" data-voffset="['170','170','124','126']"
                            data-width="none" data-height="none" data-whitespace="nowrap" data-type="text"
                            data-responsive_offset="on"
                            data-frames='[{"delay":660,"speed":1280,"frame":"0","from":"y:50px;opacity:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                            data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                            data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                            style="z-index: 11; white-space: nowrap; font-size: 16px; line-height: 22px; font-weight: 500; color: #333333; letter-spacing: 2px;font-family:Work Sans;">
                            FEATURED PRODUCT
                        </div>
                        <!-- LAYER NR. 8 -->
                        <div class="tp-caption   tp-resizeme" id="slide-49-layer-10"
                            data-x="['left','left','left','left']" data-hoffset="['281','281','98','22']"
                            data-y="['top','top','top','top']" data-voffset="['208','208','162','166']"
                            data-width="none" data-height="none" data-whitespace="nowrap" data-type="text"
                            data-responsive_offset="on"
                            data-frames='[{"delay":1050,"speed":1230,"frame":"0","from":"y:50px;opacity:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                            data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                            data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                            style="z-index: 12; white-space: nowrap; font-size: 48px; line-height: 64px; font-weight: 400; color: #333333; letter-spacing: 0px;font-family:Work Sans;">
                           {{ $lastBanner->caption1 ?? '' }}
                        </div>
                        <!-- LAYER NR. 9 -->
                        <div class="tp-caption   tp-resizeme" id="slide-49-layer-11"
                            data-x="['left','left','left','left']" data-hoffset="['282','282','99','23']"
                            data-y="['top','top','top','top']" data-voffset="['296','296','250','250']"
                            data-fontsize="['15','15','15','14']" data-width="none" data-height="none"
                            data-whitespace="nowrap" data-type="text" data-responsive_offset="on"
                            data-frames='[{"delay":1300,"speed":1180,"frame":"0","from":"y:50px;opacity:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"}]'
                            data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                            data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                            style="z-index: 13; white-space: nowrap; font-size: 15px; line-height: 26px; font-weight: 400; color: #7e7e7e; letter-spacing: 0.5px;font-family:Work Sans;">
                            {{ $lastBanner->caption2 ?? '' }}
                        </div>
                        <!-- LAYER NR. 10 -->
                        <div class="tp-caption Slider-button-alt rev-btn " id="slide-49-layer-12"
                            data-x="['left','left','left','left']" data-hoffset="['284','284','100','29']"
                            data-y="['top','top','top','top']" data-voffset="['401','401','370','349']"
                            data-width="none" data-height="none" data-whitespace="nowrap" data-type="button"
                            data-responsive_offset="on" data-responsive="off"
                            data-frames='[{"delay":1580,"speed":1270,"frame":"0","from":"y:50px;opacity:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;","ease":"Power3.easeInOut"},{"frame":"hover","speed":"300","ease":"Linear.easeNone","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:rgb(51,51,51);bg:transparent;"}]'
                            data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[12,12,12,12]"
                            data-paddingright="[35,35,35,35]" data-paddingbottom="[12,12,12,12]"
                            data-paddingleft="[35,35,35,35]"
                            style="z-index: 14; white-space: nowrap; letter-spacing: 1px;border-color:rgba(0,0,0,1);outline:none;box-shadow:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer;">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            <a class="revslider-button" href="{{$item->url}}"> ONLY {{ $lastBanner->caption3 ?? '' }}</a>
                        </div>
                    </li>
                </ul>
                <div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>
            </div>
        </div>
        <!-- END REVOLUTION SLIDER -->
    </div>
    {{-- <!--=====  End of sofa banner rev  ======--> --}}

    <!--=============================================
         =            instagram slider area         =
         =============================================-->
    {{-- <div class="instagram-slider-area mb-100 mb-md-80 mb-sm-80">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 order-2 order-lg-1">
                    <!--=============================================
                     =            instagram image slider         =
                     =============================================-->
                    <div class="instagram-image-slider-area">
                        <!--=======  instagram image container  =======-->
                        <div class="instagram-image-slider-container">
                            <div class="instagram-feed-thumb">
                                <div id="instagramFeedThree" class="instagram-carousel">
                                </div>
                            </div>
                        </div>
                        <!--=======  End of instagram image container  =======-->
                    </div>
                    <!--=====  End of instagram image slider  ======-->
                </div>
                <div class="col-lg-4 order-1 order-lg-2">
                    <!--=======  instagram intro  =======-->
                    <div
                        class="instagram-section-intro pl-50 pl-lg-50 pl-md-0 pl-sm-0 pl-xs-0 pl-xxs-0 mb-0 mb-lg-0 mb-md-50 mb-sm-50 mb-xs-50 mb-xxs-50">
                        <p><a href="#">@lezada_shop</a></p>
                        <h3>Follow us on Instagram</h3>
                    </div>
                    <!--=======  End of instagram intro  =======-->
                </div>
            </div>
        </div>
    </div> --}}
    <!--=====  End of instagram slider area  ======-->
@endsection


@push('js')
    <!-- Revolution Slider JS -->
    <script src="{{ asset('front/assets/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
    <script src="{{ asset('front/assets/revolution/js/jquery.themepunch.tools.min.js') }}">
    </script>
    <script src="{{ asset('front/assets/revolution/revolution-active.js') }}"></script>
    <!-- SLIDER REVOLUTION 5.0 EXTENSIONS  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->
    <script type="text/javascript"
        src="{{ asset('front/assets/revolution/js/extensions/revolution.extension.kenburn.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('front/assets/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('front/assets/revolution/js/extensions/revolution.extension.actions.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('front/assets/revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('front/assets/revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('front/assets/revolution/js/extensions/revolution.extension.parallax.min.js') }}"></script>
@endpush
