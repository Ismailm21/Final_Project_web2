<!--
Author: W3layouts
Author URL: http://w3layouts.com
-->
<!DOCTYPE html>
<html lang="en">
@extends('layouts.css')

<!-- Mirrored from p.w3layouts.com/demos_new/template_demo/06-11-2024/shipper-liberty-demo_Free/1152162366/web/email.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 01 May 2025 18:06:58 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
  <title>Shipper - Responsive Email Template </title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="keywords" content="" />

  <style>
    * {
      box-sizing: border-box;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
    }

    /* Responsive */
    @media only screen and (max-width: 700px) {

      /* Tables
    parameters: width, alignment */
      .w3l-scale {
        width: 100% !important;
      }

      .w3l-scale-90 {
        width: 95% !important;
      }

      .w3l-scale-strip {
        width: 95% !important;
        padding: 20px !important;
        padding-top: 0px !important;
      }

      .w3l-img-scale {
        width: 100% !important;
      }
      a.facebook,a.twitter{
        padding:0 10px!important;
        font-size:14px!important;;

      }
    }

    @media only screen and (max-width: 415px) {

      span.heading {
        font-size: 24px !important;
        line-height: 34px !important;
      }

      td.gap-responsive-top {
        height: 30px;
      }
    }
  </style>

</head>

<body style="margin: 0; padding: 0; background: #f2f2f2;">
<script src="../../../../../../../m.servedby-buysellads.com/monetization.js" type="text/javascript"></script>
<script>
(function(){
	if(typeof _bsa !== 'undefined' && _bsa) {
  		// format, zoneKey, segment:value, options
  		_bsa.init('flexbar', 'CKYI627U', 'placement:w3layoutscom');
  	}
})();
</script>
<script>
(function(){
if(typeof _bsa !== 'undefined' && _bsa) {
	// format, zoneKey, segment:value, options
	_bsa.init('fancybar', 'CKYDL2JN', 'placement:demo');
}
})();
</script>
<script>
(function(){
	if(typeof _bsa !== 'undefined' && _bsa) {
  		// format, zoneKey, segment:value, options
  		_bsa.init('stickybox', 'CKYI653J', 'placement:w3layoutscom');
  	}
})();
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src='https://www.googletagmanager.com/gtag/js?id=G-98H8KRKT85'></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-98H8KRKT85');
</script>

<meta name="robots" content="noindex">
<body><link rel="stylesheet" href="../../../../../../assests/css/font-awesome.min.css">
<!-- New toolbar-->
<style>
* {
  box-sizing: border-box;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
}


#w3lDemoBar.w3l-demo-bar {
  top: 0;
  right: 0;
  bottom: 0;
  z-index: 9999;
  padding: 40px 5px;
  padding-top:70px;
  margin-bottom: 70px;
  background: #0D1326;
  border-top-left-radius: 9px;
  border-bottom-left-radius: 9px;
}

#w3lDemoBar.w3l-demo-bar a {
  display: block;
  color: #e6ebff;
  text-decoration: none;
  line-height: 24px;
  opacity: .6;
  margin-bottom: 20px;
  text-align: center;
}

#w3lDemoBar.w3l-demo-bar span.w3l-icon {
  display: block;
}

#w3lDemoBar.w3l-demo-bar a:hover {
  opacity: 1;
}

#w3lDemoBar.w3l-demo-bar .w3l-icon svg {
  color: #e6ebff;
}
#w3lDemoBar.w3l-demo-bar .responsive-icons {
  margin-top: 30px;
  border-top: 1px solid #41414d;
  padding-top: 40px;
}
#w3lDemoBar.w3l-demo-bar .demo-btns {
  border-top: 1px solid #41414d;
  padding-top: 30px;
}
#w3lDemoBar.w3l-demo-bar .responsive-icons a span.fa {
  font-size: 26px;
}
#w3lDemoBar.w3l-demo-bar .no-margin-bottom{
  margin-bottom:0;
}
.toggle-right-sidebar span {
  background: #0D1326;
  width: 50px;
  height: 50px;
  line-height: 50px;
  text-align: center;
  color: #e6ebff;
  border-radius: 50px;
  font-size: 26px;
  cursor: pointer;
  opacity: .5;
}
.pull-right {
  float: right;
  position: fixed;
  right: 0px;
  top: 70px;
  width: 90px;
  z-index: 99999;
  text-align: center;
}
/* ============================================================
RIGHT SIDEBAR SECTION
============================================================ */

#right-sidebar {
  width: 90px;
  position: fixed;
  height: 100%;
  z-index: 1000;
  right: 0px;
  top: 0;
  margin-top: 60px;
  -webkit-transition: all .5s ease-in-out;
  -moz-transition: all .5s ease-in-out;
  -o-transition: all .5s ease-in-out;
  transition: all .5s ease-in-out;
  overflow-y: auto;
}


/* ============================================================
RIGHT SIDEBAR TOGGLE SECTION
============================================================ */

.hide-right-bar-notifications {
  margin-right: -300px !important;
  -webkit-transition: all .3s ease-in-out;
  -moz-transition: all .3s ease-in-out;
  -o-transition: all .3s ease-in-out;
  transition: all .3s ease-in-out;
}



@media (max-width: 992px) {
  #w3lDemoBar.w3l-demo-bar a.desktop-mode{
      display: none;

  }
}
@media (max-width: 767px) {
  #w3lDemoBar.w3l-demo-bar a.tablet-mode{
      display: none;

  }
}
@media (max-width: 568px) {
  #w3lDemoBar.w3l-demo-bar a.mobile-mode{
      display: none;
  }
  #w3lDemoBar.w3l-demo-bar .responsive-icons {
      margin-top: 0px;
      border-top: none;
      padding-top: 0px;
  }
  #right-sidebar,.pull-right {
      width: 90px;
  }
  #w3lDemoBar.w3l-demo-bar .no-margin-bottom-mobile{
      margin-bottom: 0;
  }
}
</style>
<div class="pull-right toggle-right-sidebar">
<span class="fa title-open-right-sidebar tooltipstered fa-angle-double-right"></span>
</div>

<div id="right-sidebar" class="right-sidebar-notifcations nav-collapse">
<div class="bs-example bs-example-tabs right-sidebar-tab-notification" data-example-id="togglable-tabs">

    <div id="w3lDemoBar" class="w3l-demo-bar">
        <div class="demo-btns">
        <a href="https://w3layouts.com/?p=0">
            <span class="w3l-icon -back">
                <span class="fa fa-arrow-left"></span>
            </span>
            <span class="w3l-text">Back</span>
        </a>
        <a href="https://w3layouts.com/?p=0">
            <span class="w3l-icon -download">
                <span class="fa fa-download"></span>
            </span>
            <span class="w3l-text">Download</span>
        </a>
        <a href="https://w3layouts.com/checkout/?add-to-cart=0" class="no-margin-bottom-mobile">
            <span class="w3l-icon -buy">
                <span class="fa fa-shopping-cart"></span>
            </span>
            <span class="w3l-text">Buy</span>
        </a>
    </div>
        <!---<div class="responsive-icons">
            <a href="#url" class="desktop-mode">
                <span class="w3l-icon -desktop">
                    <span class="fa fa-desktop"></span>
                </span>
            </a>
            <a href="#url" class="tablet-mode">
                <span class="w3l-icon -tablet">
                    <span class="fa fa-tablet"></span>
                </span>
            </a>
            <a href="#url" class="mobile-mode no-margin-bottom">
                <span class="w3l-icon -mobile">
                    <span class="fa fa-mobile"></span>
                </span>
            </a>
        </div>-->
    </div>
    <div class="right-sidebar-panel-content animated fadeInRight" tabindex="5003"
        style="overflow: hidden; outline: none;">
    </div>
</div>
</div>
</div>

  <!-- gap -->
  <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale" width="640px">
    <tbody>
      <tr>
        <td class="gap-responsive-top" height="60">&nbsp;</td>
      </tr>
    </tbody>
  </table>
  <!-- /gap -->
  <!-- /logoinfo -->
  <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale-90"
    style="background-color: #ffffff; padding:0px 30px 20px 30px;" width="640px">
    <tbody>
      <tr>
        <td>
          <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale" width="610px">
            <tbody>
              <tr>
                <td>
                  <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale"
                    style=" font-size: 14px; color: #9b9b9b;" width="290px">
                    <tbody>
                      <tr>
                        <td class="w3l-scale">
                          <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale"
                            width="560">
                            <tbody>

                              <tr>
                                <td>
                                  <div style="text-align: center;">
                                    <br>
                                    <span style="color: #111;font-size:30px;">
                                      <a href="index.blade.php" style="color: #111;text-decoration:none;"><strong>Sh<span
                                            style="color:#ff5e14;">i</span>pper</strong>
                                            <span class="logo-capt" style="color: #666;font-size:14px;display:block;text-decoration:none;">Transportation & cargo</span>
                                          </a>

                                    </span>

                                  </div>
                                </td>
                              </tr>

                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  <!-- //logoinfo -->
  <!-- email info -->
  <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale-90 w3l-banner-top" width="640px">
    <tbody>
      <tr>
        <td>
          <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale" width="640px">
            <tbody>
              <tr>
                <td
                  style="background-image: url(assets/images/banner.jpg); background-size:cover;position:relative;min-height:400px;">
                  <div class="overlay-banner" style="background: rgb(18 18 19 / 65%);
                                    padding: 15px;height:380px;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale" width="640px">
                      <tbody>
                        <tr>
                          <td>

                            <table align="left" border="0" cellpadding="0" cellspacing="0" class="w3l-scale"
                              style=" font-size: 14px; color: #9b9b9b;" width="290px">
                              <tbody>
                                <tr>
                                  <td class="w3l-scale-left-both">
                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="w3l-scale"
                                      width="610">
                                      <tbody>
                                        <tr>
                                          <td>
                                            <div style="text-align:left; padding:0 30px;margin:20px 0; ">
                                              <h2 class="template_title"
                                                style="color: #ff5e14;font-size:16px;text-transform:uppercase;line-height:42px;font-weight:600;margin-bottom:0;margin-top:30px;">
                                                DELIVERED ON TIME.
                                              </h2>
                                              <h2 class="template_title"
                                                style="color: #fff; font-size:34px; line-height: 42px; margin-top: 0;margin-bottom: 0px;">
                                                Your Gateway To Any Destination In The World.
                                              </h2>
                                              <br>
                                              <span style="font-size: 16px; line-height: 26px;margin-top: 20px;">
                                                <span style="color:#fff;">lorem ipsum
                                                  dolor sit amet ullamco sed amet
                                                  incididunt ut tation ullamco.Pellen tesque libero ut justo, ultrices
                                                  in ligula
                                                </span>
                                                <br>
                                                <br>
                                                <a href="#url" class="btn-style"
                                                  style="background: #ff5e14;
                                                                  text-decoration: none; border-radius: 6px; padding: 12px 28px;
                                                                  color: #fff; display: inline-block; font-size: 14px;
                                                                  transition: 0.3s ease; font-weight: bold; position: relative;">Read More

                                                </a>
                                            </div>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  <!-- /one-columns -->
  <!-- /email info -->
  <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale-90"
    style="background-color: #ffffff; padding: 50px 30px;" width="640px">
    <tbody>
      <tr>
        <td>
          <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale" width="610px">
            <tbody>
              <tr>
                <td>
                  <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale"
                    style=" font-size: 14px; color: #9b9b9b;" width="290px">
                    <tbody>
                      <tr>
                        <td class="w3l-scale-left-both">
                          <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale"
                            width="560">
                            <tbody>

                              <tr>
                                <td>
                                  <div style="text-align: center;">
                                    <span class="heading"
                                      style="display:block; color: #333; font-weight: 300;font-size:28px; line-height: 40px;margin-bottom:20px;">
                                      <strong>We provide full assistance in
                                        freight and warehousing</strong>
                                    </span>
                                    <span style="font-size: 14px; line-height: 26px;">
                                      <span style="color:#666;">Pellen tesque libero ut justo, ultrices in
                                        ligula.Integer pulvinar leo id viverra feugiat. Semper at tempufddfel, ultrices
                                        in ligula.Excepteur sint occaecat cupidatat non proident Consectetur suscipit.
                                      </span>
                                      <br><br>
                                    </span>
                                  </div>
                                </td>
                              </tr>

                              <tr>
                                <td style="text-align: center;">
                                  <a href="#url" class="btn-style"
                                    style="background: #ff5e14;
                                                             text-decoration: none; border-radius: 6px; padding: 12px 28px;
                                                             color: #fff; display: inline-block; font-size: 14px;
                                                             transition: 0.3s ease; font-weight: bold; position: relative;">Read More

                                  </a>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  <!-- //email info -->
  <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale-90"
    style="background-color: #fff; border-top: 1px solid #e1e1e1; padding: 50px 30px 30px 30px;" width="640px">
    <tbody>
      <tr>
        <td>
          <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale" width="610px">
            <tbody>
              <tr>
                <td>
                  <table align="right" border="0" cellpadding="0" cellspacing="0" class="w3l-scale"
                    style=" font-size: 14px; color: #9b9b9b;" width="290px">
                    <tbody>
                      <tr>
                        <td class="w3l-scale-left-both">
                          <table align="right" border="0" cellpadding="0" cellspacing="0" class="w3l-scale" width="610">
                            <tbody>

                              <tr>
                                <td>
                                  <div style="text-align: left; margin-bottom:30px;">
                                    <span class="heading"
                                      style="display:block; color: #333;font-size:28px; line-height: 40px;">
                                      <strong>What We Offer To Highest
                                        <br>Quality Services</strong>
                                    </span>

                                  </div>
                                </td>
                              </tr>

                              <tr>
                                <td>
                                  <table align="left" border="0" cellpadding="0" cellspacing="0" class="w3l-img-scale"
                                    style="background: #f8f9fa; border-radius: 9px; margin-bottom: 20px;" width="290px">
                                    <tbody>
                                      <tr>
                                        <td align="left">
                                          <a href="#url" class="image-border"><img src="assets/images/g1.jpg"
                                              class="img-responsive" title="Excellence image grid"
                                              style="border-radius: 8px;max-width: 100%; display: block;"></a>
                                        </td>
                                      </tr>

                                    </tbody>
                                  </table>
                                  <table align="right" border="0" cellpadding="0" cellspacing="0" class="w3l-img-scale"
                                    style="background: transparent; border-radius:0px; margin-bottom: 20px;"
                                    width="290px">
                                    <tbody>
                                      <tr>
                                        <td align="left">
                                          <span style="font-size: 15px; line-height: 26px;">
                                            <span style="color:#666;">lorem ipsum
                                              dolor sit amet ullamco sed amet
                                              incididunt ut tation ullamco... Morbi
                                              auctor ultricies accumsan. Vestibulum
                                              ante ipsum primis faucibus.
                                            </span>
                                            <br><br>
                                          </span>

                                          <a href="#url" class="btn-style"
                                            style="background: #ff5e14;
                                                                  text-decoration: none; border-radius: 6px; padding: 12px 28px;
                                                                  color: #fff; display: inline-block; font-size: 14px;
                                                                  transition: 0.3s ease; font-weight: bold; position: relative;">Read More

                                          </a>
                                        </td>
                                      </tr>

                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  <!-- //one-columns -->
  <!-- two-two columns -->
  <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale-strip" width="670px"
    style="background-color: #f7f7f7; padding: 30px; padding-top:5px;">
    <tbody>
      <tr>
        <td class="" height="40">&nbsp;</td>
      </tr>
      <tr>
        <td>
          <table align="left" border="0" cellpadding="0" cellspacing="0" class="w3l-img-scale" style="background: #fff;
                  border-radius: 9px; margin-bottom: 30px;" width="290px">
            <tbody>
              <tr>
                <td align="left">
                  <a href="#url" class="image-border"><img src="assets/images/g8.jpg" class="img-responsive" title=""
                      style="border-radius: 8px; border-bottom-left-radius: 0 !important;
                                border-bottom-right-radius: 0 !important; max-width: 100%; display: block;"></a>
                </td>
              </tr>
              <tr>
                <td style="text-align: left;">
                  <div style="text-align: center;">
                    <h3 style="font-size: 16px;margin-bottom: 10px;">
                      <a href="#url" style="text-decoration: none; line-height: 25px; color: #444;">
                        Road Freight</a>
                    </h3>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <table align="right" border="0" cellpadding="0" cellspacing="0" class="w3l-img-scale" style="background: #fff;
                      border-radius: 9px; margin-bottom: 30px;" width="290px">
            <tbody>
              <tr>
                <td align="left">
                  <a href="#url" class="image-border"><img src="assets/images/g4.jpg" class="img-responsive" title=""
                      style="border-radius: 8px; border-bottom-left-radius: 0 !important;
                              border-bottom-right-radius: 0 !important;  max-width: 100%; display: block;"></a>
                </td>
              </tr>
              <tr>
                <td style="text-align: left;">
                  <div style="text-align: center;">
                    <h3 style="font-size: 16px;margin-bottom: 10px;">
                      <a href="#url" style="text-decoration: none; line-height: 25px; color: #444;">
                        Sea Freight</a>
                    </h3>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
      <tr>
        <td>
          <table align="left" border="0" cellpadding="0" cellspacing="0" class="w3l-img-scale" style="background: #fff;
                  border-radius: 9px; margin-bottom: 30px;" width="290px">
            <tbody>
              <tr>
                <td align="left">
                  <a href="#url" class="image-border"><img src="assets/images/g5.jpg" class="img-responsive" title=""
                      style="border-radius: 8px; border-bottom-left-radius: 0 !important;
                              border-bottom-right-radius: 0 !important;  max-width: 100%; display: block;"></a>
                </td>
              </tr>
              <tr>
                <td style="text-align: left;">
                  <div style="text-align: center;">
                    <h3 style="font-size: 16px;margin-bottom: 10px;">
                      <a href="#url" style="text-decoration: none; line-height: 25px; color: #444;">
                        Local Delivery</a>
                    </h3>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <table align="right" border="0" cellpadding="0" cellspacing="0" class="w3l-img-scale" style="background: #fff;
                  border-radius: 9px; margin-bottom: 30px;" width="290px">
            <tbody>
              <tr>
                <td align="left">
                  <a href="#url" class="image-border"><img src="assets/images/g2.jpg" class="img-responsive" title=""
                      style="border-radius: 8px;border-bottom-left-radius: 0 !important;
                                            border-bottom-right-radius: 0 !important;  max-width: 100%; display: block;"></a>
                </td>
              </tr>
              <tr>
                <td style="text-align: left;">
                  <div style="text-align: center;">
                    <h3 style="font-size: 16px;margin-bottom: 10px;">
                      <a href="#url" style="text-decoration: none; line-height: 25px; color: #444;">
                        Air Freight</a>
                    </h3>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  <!-- /two-two columns -->
  <!--/middle-->
  <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale-90 w3l-banner-top" width="640px">
    <tbody>
      <tr>
        <td>
          <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale" width="640px">
            <tbody>
              <tr>
                <td
                  style="background-image: url(assets/images/banner1.jpg); background-size:cover;position:relative;min-height:400px;">
                  <div class="overlay-banner" style="background: rgb(18 18 19 / 65%);
                                 padding:0 14px;height:300px;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale" width="640px">
                      <tbody>
                        <tr>
                          <td>

                            <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale"
                              style=" font-size: 14px; color: #9b9b9b;" width="290px">
                              <tbody>
                                <tr>
                                  <td class="w3l-scale">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale"
                                      width="460">
                                      <tbody>

                                        <tr>
                                          <td>
                                            <div style="text-align: center;margin:0 auto; padding-top:40px;">
                                              <span
                                                style="display:block; color: #ffffff; font-weight: 600; font-size: 24px; line-height: 28px;">
                                                Our Working Process To Help
                                                Your Boost <br>Your Business
                                              </span>
                                              <br>
                                              <span style="font-size: 15px; line-height: 26px;">
                                                <span style="color:#fff;">lorem ipsum
                                                  dolor sit amet ullamco sed amet
                                                  incididunt ut tation ullamco... Morbi
                                                  auctor ultricies accumsan. Vestibulum
                                                  ante ipsum primis faucibus.
                                                </span>

                                              </span>
                                              <br>
                                              <br>
                                              <a href="#url" class="btn-style"
                                                style="background: #ff5e14;
                                                                         text-decoration: none; border-radius: 6px; padding: 12px 26px;
                                                                         color: #fff; display: inline-block; font-size: 14px;
                                                                         transition: 0.3s ease; font-weight: bold; position: relative;">Get started
                                                now

                                              </a>
                                            </div>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  <!--//middle-->
  <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale-90"
    style="background-color: #fff; padding: 50px 30px 30px 30px;" width="640px">
    <tbody>
      <tr>
        <td>
          <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale" width="610px">
            <tbody>
              <tr>
                <td>
                  <table align="right" border="0" cellpadding="0" cellspacing="0" class="w3l-scale"
                    style=" font-size: 14px; color: #9b9b9b;" width="290px">
                    <tbody>
                      <tr>
                        <td class="w3l-scale-left-both">
                          <table align="right" border="0" cellpadding="0" cellspacing="0" class="w3l-scale" width="610">
                            <tbody>

                              <tr>
                                <td>
                                  <table align="left" border="0" cellpadding="0" cellspacing="0" class="w3l-img-scale"
                                    style="margin-bottom: 20px;" width="290px">
                                    <tbody>
                                      <tr>
                                        <td align="left">
                                          <a href="#url" class="image-border"><img src="assets/images/g4.jpg"
                                              class="img-responsive" title="Excellence image grid"
                                              style="border-radius: 8px; max-width: 100%; display: block;"></a>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="text-align: left;">
                                          <div style="text-align:left;">
                                            <h3 style="font-size: 18px; margin-bottom: 10px;">
                                              <a href="#url"
                                                style="text-decoration: none; line-height: 26px; color: #444;">
                                                Fluid Responsive Typography With CSS Poly Fluid Sizing.</a>
                                            </h3>
                                            <span style="font-size: 14px; line-height: 26px;">
                                              <span style="color:#666;">lorem ipsum
                                                dolor sit amet ullamco sed amet
                                                incididunt ut tation ullamco...
                                              </span>
                                              <br><br>
                                            </span>
                                          </div>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <table align="right" border="0" cellpadding="0" cellspacing="0" class="w3l-img-scale"
                                    style="margin-bottom: 20px;" width="290px">
                                    <tbody>
                                      <tr>
                                        <td align="left">
                                          <a href="#url" class="image-border"><img src="assets/images/g3.jpg"
                                              class="img-responsive" title="image grid"
                                              style="border-radius: 8px;  max-width: 100%; display: block;"></a>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="text-align:left;">
                                          <div style="text-align:left;">
                                            <h3 style="font-size: 18px;margin-bottom: 10px;">
                                              <a href="#url"
                                                style="text-decoration: none; line-height: 26px; color: #444;">
                                                Fluid Responsive Typography With CSS Poly Fluid Sizing.</a>
                                            </h3>
                                            <span style="font-size: 14px; line-height: 26px;">
                                              <span style="color:#666;">lorem ipsum
                                                dolor sit amet ullamco sed amet
                                                incididunt ut tation ullamco...
                                              </span>
                                              <br><br>
                                            </span>
                                          </div>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  <!-- email info -->
  <!--/address-->
  <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale-90"
  style="background-color: #f7f7f7; padding: 20px 30px 20px 30px;" width="640px">
  <tbody>
    <tr>
      <td>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale" width="610px">
          <tbody>
            <tr>
              <td>
                <table align="right" border="0" cellpadding="0" cellspacing="0" class="w3l-scale"
                  style=" font-size: 14px; color: #9b9b9b;" width="290px">
                  <tbody>
                    <tr>
                      <td class="w3l-scale-left-both">
                        <table align="right" border="0" cellpadding="0" cellspacing="0" class="w3l-scale" width="610">
                          <tbody>

                            <tr>
                              <td>
                                <table align="left" border="0" cellpadding="0" cellspacing="0" class="w3l-img-scale"
                                  style="margin-bottom: 20px;" width="290px">
                                  <tbody>

                                    <tr>
                                      <td style="text-align: left;">
                                        <div style="text-align:left;">
                                          <h3 style="font-size: 18px; margin-bottom: 10px;text-decoration: none; line-height: 26px; color: #333;">

                                              Call Our Support
                                          </h3>
                                          <span style="font-size: 14px; line-height: 26px;">
                                            <span style="color:#666;">24 / 7 Support Line :+1(21) 234 557 4567
                                            </span>

                                          </span>
                                        </div>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                                <table align="right" border="0" cellpadding="0" cellspacing="0" class="w3l-img-scale"
                                  style="margin-bottom: 20px;" width="290px">
                                  <tbody>

                                    <tr>
                                      <td style="text-align:left;">
                                        <div style="text-align:left;">
                                          <h3 style="font-size: 18px;margin-bottom: 10px;text-decoration: none; line-height: 26px; color: #333;">

                                              Our Location
                                          </h3>
                                          <span style="font-size: 14px; line-height: 26px;">
                                            <span style="color:#666;">lorem ipsum
                                              Shipper,Honey street, NY - 62617.
                                            </span>

                                          </span>
                                        </div>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
<!--//address-->
  <!-- footer -->
  <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale-90"
    style="background-color: #111; padding: 30px 30px 40px 29px;" width="640px">
    <tr>
      <td>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale"
          style="background-color: #111;" width="610px">
          <tr>
            <td height="30"></td>
          </tr>
          <tr>
            <td align="center">

              <table class="w3layouts_social_icons" border="0" align="center" cellpadding="0" cellspacing="0">

                <tr>
                  <td>
                    <table border="0" align="center" class="w3l-img-scale" cellpadding="0" cellspacing="0">
                      <tbody>
                        <tr>
                          <td >
                            <a href="#facebook" class="facebook" style="background: #3b5998;
                            color: #fff;
                            font-size: 16px;
                            border-radius: 4px;
                            display: inline-block;
                            border-radius: 6px;
                            width: auto;
                            height: 44px;
                            padding: 0 20px;
                            line-height: 40px;
                            text-align: center;
                            text-decoration:none;"><img src="assets/images/fb.png" class="img-responsive" style="    margin-right: 10px;
    vertical-align: middle;
    width: 16px;
    display: inline-block;">Like us on Facebook</a>
                          </td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>

                          <td>&nbsp;</td>
                          <td>&nbsp;</td>

                          <td>
                            <a href="#twitter" class="twitter" style="background:#1da1f2;
                            color: #fff;
                            font-size: 16px;
                            border-radius: 4px;
                            display: inline-block;
                            margin-right: 10px;

                            width: auto;
                            height: 44px;
                            padding: 0 20px;
                            line-height: 40px;
                            text-align: center;
                            text-decoration:none;"><img src="assets/images/tw.png" class="img-responsive" style="    margin-right: 10px;
    vertical-align: middle;
    width: 16px;
    display: inline-block;">Like us on Twitter</a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td height="10">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td align="center">
              <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale-90" width="560">
                <tr>
                  <td align="center" style="font-size: 15px; color:#666; line-height: 25px;">
                    The Honey Pilo
                    Adelaide,S2 8GY.
                    &nbsp; | &nbsp;
                    <a href="tel:+12 123 4567"
                      style=" font-size: 15px; color:#666; text-decoration: none; line-height: 24px;">+12 123 4567</a>
                    &nbsp; | &nbsp;
                    <a href="https://p.w3layouts.com/cdn-cgi/l/email-protection#a1c8cfc7cee1c4d9c0ccd1cdc48fc2cecc" style=" font-size: 15px; color:#666; text-decoration: none; line-height: 24px;"><span class="__cf_email__" data-cfemail="afc6c1c9c0efcad7cec2dfc3ca81ccc0c2">[email&#160;protected]</span></a>
                  </td>
                </tr>
                <tr>
                  <td
                  style="font-size: 15px; display: block; margin-top: 10px; color: #555; line-height: 24px; text-align: center">
                  &copy; 2021 Shipper. All rights reserved. Design by <a href="https://w3layouts.com/" style="color:#fff;text-decoration:none;" target="_blank">W3layouts</a>
                </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height="10"></td>
          </tr>
          <tr>
            <td style="text-align: center;">
              <span style="color:#666;">
                <a href="#view" style="font-size: 15px; color:#666; text-decoration: underline;">View in your
                  browser</a>
                &nbsp; | &nbsp;
                <a href="#friend"
                  style=" font-size: 15px; color:#666; text-decoration: underline; line-height: 24px;">Send to a
                  friend</a>
                &nbsp; | &nbsp;
                <a href="#unsubscribe"
                  style=" font-size: 15px; color:#666; text-decoration: underline; line-height: 24px;">Unsubscribe</a>
              </span>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <!-- //footer -->


  <!-- gap -->
  <table align="center" border="0" cellpadding="0" cellspacing="0" class="w3l-scale" width="640px">
    <tbody>
      <tr>
        <td class="gap-responsive-top" height="60">&nbsp;</td>
      </tr>
    </tbody>
  </table>
  <!-- /gap -->


<script data-cfasync="false" src="../../../../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'939135e6191e44c2',t:'MTc0NjEyMjc2My4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='../../../../../../cdn-cgi/challenge-platform/h/b/scripts/jsd/a51d7b3d53cb/maind41d.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>


<!-- Mirrored from p.w3layouts.com/demos_new/template_demo/06-11-2024/shipper-liberty-demo_Free/1152162366/web/email.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 01 May 2025 18:06:59 GMT -->
</html>
