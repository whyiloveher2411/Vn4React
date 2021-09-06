@extends(backend_theme('master'))



@section('content')



<?php 

  title_head( 'Setting' );
  if( !isset($accounts) ) $accounts =[];
?>
<style type="text/css">
  .webpropertie_id .selected{
    background: #dedede;
  }
</style>
  <form class="form-setting form-horizontal form-label-left input_mask" id="form_create" method="POST">

    <input type="text" name="_token" value="{!!csrf_token()!!}" hidden>

    <div class="row seo_vn4">

      <div class="col-xs-12 col-md-9">
        
        <?php 
            vn4_tabs_top([
                'embed'=>[
                  'title'=>'Embed Code',
                  'content'=>function() use ($plugin, $__env) {
                    ?>
                    <div class="row">
                        <div class="col-md-3 col-xs-12">
                          <h3>Embel Code</h3>
                          <p class="note">Activate google analytics on website.</p>
                        </div>
                        <div class="col-md-9 col-xs-12" >
                            <textarea rows="12" class="form-control" name="code-analytics">{!!$plugin->getMeta('code-analytics')!!}</textarea>
                        </div>
                    </div>
                    <br>
                    

                    <?php
                  }
                ],
                'analytics'=>[
                  'title'=>'Analytics',
                  'content'=>function() use ($plugin,$auth_url,$accounts,$__env ) {

                      $access_code = $plugin->getMeta('access_token_first');
                      $webpropertie_id = false;

                      $file_app_json = $plugin->getMeta('file_app_json');

                      if( $file_app_json && $file_app_json !== '""' ){
                          if( isset($access_code['webpropertie_id']) ){
                            $webpropertie_id = $access_code['webpropertie_id'];

                          }
                      }else{
                        $access_code = [];
                      }


                    ?>
                      <div class="vn4_google_analytics" >
                        <h2>Step 1: get file conffig app <a href="https://console.developers.google.com/apis/dashboard" target="_blank">here</a></h2>
                        <div class="form-group">
                          <div class="row">
                            <label class="col-md-2 col-xs-12" style="line-height:28px;" ></label>
                            <div class="col-md-8 col-sm-8 col-xs-12 ">
                              <?php 
                                echo get_field('asset-file',['key'=>'file_app_json','value'=>$file_app_json]);
                               ?>
                            </div>
                          </div>
                        </div>
                      </div>

                      @if( isset($access_code['access_code'] ) )
                      <div class="vn4_google_analytics  " >
                        <hr>
                        <h2 class="disable_event">Step 2: Use this link to get your one-time-use access code: <a href="{!!$auth_url!!}" onclick="return !window.open(this.href, 'Google Auth', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=640, height=580, top='+(window.screen.height/2-290)+', left='+(window.screen.width/2-320))"  style="color:red;text-decoration:underline;">Get Access Code.</a></h2><br>

                        <div class="form-group">
                          <div class="row">
                            <label class="col-md-2 col-xs-12 disable_even" style="line-height:28px;" >Access Code:</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                              <input value="{!!$access_code['access_code']!!}" type="text" class="form-control col-md-7 col-xs-12 disable_event">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <label class="col-md-2 col-xs-12 disable_even" style="line-height:28px;" >Access Token:</label>
                          <div class="col-md-8 col-sm-8 col-xs-12 ">
                            <input value="{!!$access_code['access_token']!!}" type="text" class="form-control col-md-7 col-xs-12 disable_event">
                            <button name="clear_authorization" style="margin-top: 15px;" value="1" class="vn4-btn" >Clear Authorization</button>
                          </div>
                        </div>
                        <br>
                         <div class="row">
                          <label class="col-md-2 col-xs-12 disable_even" style="line-height:28px;" >Select View:</label>
                          <div class="col-md-8 col-sm-8 col-xs-12 ">

                            <?php 
                                $listAnalyticsWebsite = $plugin->getMeta('listAnalyticsWebsite');
                             ?>
                            <select class="form-control select2 col-md-7 col-xs-12 webpropertie_id" name="webpropertie_id[]" multiple="multiple">

                                @foreach($accounts['items'] as $ac)
                                <optgroup label="{!!$ac['name']!!}">
                                   @foreach($ac['webproperties']['items'] as $web)
                                   @if( isset($web['defaultProfileId']) )
                                    <option @if( isset($listAnalyticsWebsite[$web['defaultProfileId']])) selected="selected" class="selected" @endif value='["{!!$web['defaultProfileId']!!}","{!!$web['name']!!}","{!!$web['websiteUrl']!!}"]'>{!!$web['name']!!}</option>
                                   @endif
                                   @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                              
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <label class="col-md-2 col-xs-12 disable_even" style="line-height:28px;" >Country</label>
                          <div class="col-md-8 col-xs-12" >
                              <select class="form-control" name="country">
                                  <?php 
                                      $countryList = array(
                                        'afghanistan'=>'AF',
                                        'aland-islands'=>'AX',
                                        'albania'=>'AL',
                                        'algeria'=>'DZ',
                                        'american-samoa'=>'AS',
                                        'andorra'=>'AD',
                                        'angola'=>'AO',
                                        'anguilla'=>'AI',
                                        'antarctica'=>'AQ',
                                        'antigua-and-barbuda'=>'AG',
                                        'argentina'=>'AR',
                                        'armenia'=>'AM',
                                        'aruba'=>'AW',
                                        'australia'=>'AU',
                                        'austria'=>'AT',
                                        'azerbaijan'=>'AZ',
                                        'bahamas-the'=>'BS',
                                        'bahrain'=>'BH',
                                        'bangladesh'=>'BD',
                                        'barbados'=>'BB',
                                        'belarus'=>'BY',
                                        'belgium'=>'BE',
                                        'belize'=>'BZ',
                                        'benin'=>'BJ',
                                        'bermuda'=>'BM',
                                        'bhutan'=>'BT',
                                        'bolivia'=>'BO',
                                        'bosnia-and-herzegovina'=>'BA',
                                        'botswana'=>'BW',
                                        'bouvet-island-bouvetoya'=>'BV',
                                        'brazil'=>'BR',
                                        'british-indian-ocean-territory-chagos-archipelago'=>'IO',
                                        'british-virgin-islands'=>'VG',
                                        'brunei-darussalam'=>'BN',
                                        'bulgaria'=>'BG',
                                        'burkina-faso'=>'BF',
                                        'burundi'=>'BI',
                                        'cambodia'=>'KH',
                                        'cameroon'=>'CM',
                                        'canada'=>'CA',
                                        'cape-verde'=>'CV',
                                        'cayman-islands'=>'KY',
                                        'central-african-republic'=>'CF',
                                        'chad'=>'TD',
                                        'chile'=>'CL',
                                        'china'=>'CN',
                                        'christmas-island'=>'CX',
                                        'cocos-keeling-islands'=>'CC',
                                        'colombia'=>'CO',
                                        'comoros-the'=>'KM',
                                        'congo'=>'CD',
                                        'congo-the'=>'CG',
                                        'cook-islands'=>'CK',
                                        'costa-rica'=>'CR',
                                        'cote-divoire'=>'CI',
                                        'croatia'=>'HR',
                                        'cuba'=>'CU',
                                        'cyprus'=>'CY',
                                        'czech-republic'=>'CZ',
                                        'denmark'=>'DK',
                                        'djibouti'=>'DJ',
                                        'dominica'=>'DM',
                                        'dominican-republic'=>'DO',
                                        'ecuador'=>'EC',
                                        'egypt'=>'EG',
                                        'el-salvador'=>'SV',
                                        'equatorial-guinea'=>'GQ',
                                        'eritrea'=>'ER',
                                        'estonia'=>'EE',
                                        'ethiopia'=>'ET',
                                        'faroe-islands'=>'FO',
                                        'falkland-islands-malvinas'=>'FK',
                                        'fiji-the-fiji-islands'=>'FJ',
                                        'finland'=>'FI',
                                        'france-french-republic'=>'FR',
                                        'french-guiana'=>'GF',
                                        'french-polynesia'=>'PF',
                                        'french-southern-territories'=>'TF',
                                        'gabon'=>'GA',
                                        'gambia-the'=>'GM',
                                        'georgia'=>'GE',
                                        'germany'=>'DE',
                                        'ghana'=>'GH',
                                        'gibraltar'=>'GI',
                                        'greece'=>'GR',
                                        'greenland'=>'GL',
                                        'grenada'=>'GD',
                                        'guadeloupe'=>'GP',
                                        'guam'=>'GU',
                                        'guatemala'=>'GT',
                                        'guernsey'=>'GG',
                                        'guinea'=>'GN',
                                        'guinea-bissau'=>'GW',
                                        'guyana'=>'GY',
                                        'haiti'=>'HT',
                                        'heard-island-and-mcdonald-islands'=>'HM',
                                        'holy-see-vatican-city-state'=>'VA',
                                        'honduras'=>'HN',
                                        'hong-kong'=>'HK',
                                        'hungary'=>'HU',
                                        'iceland'=>'IS',
                                        'india'=>'IN',
                                        'indonesia'=>'ID',
                                        'iran'=>'IR',
                                        'iraq'=>'IQ',
                                        'ireland'=>'IE',
                                        'isle-of-man'=>'IM',
                                        'israel'=>'IL',
                                        'italy'=>'IT',
                                        'jamaica'=>'JM',
                                        'japan'=>'JP',
                                        'jersey'=>'JE',
                                        'jordan'=>'JO',
                                        'kazakhstan'=>'KZ',
                                        'kenya'=>'KE',
                                        'kiribati'=>'KI',
                                        'korea'=>'KP',
                                        'south-korea'=>'KR',
                                        'kuwait'=>'KW',
                                        'kyrgyz-republic'=>'KG',
                                        'lao'=>'LA',
                                        'latvia'=>'LV',
                                        'lebanon'=>'LB',
                                        'lesotho'=>'LS',
                                        'liberia'=>'LR',
                                        'libyan-arab-jamahiriya'=>'LY',
                                        'liechtenstein'=>'LI',
                                        'lithuania'=>'LT',
                                        'luxembourg'=>'LU',
                                        'macao'=>'MO',
                                        'macedonia'=>'MK',
                                        'madagascar'=>'MG',
                                        'malawi'=>'MW',
                                        'malaysia'=>'MY',
                                        'maldives'=>'MV',
                                        'mali'=>'ML',
                                        'malta'=>'MT',
                                        'marshall-islands'=>'MH',
                                        'martinique'=>'MQ',
                                        'mauritania'=>'MR',
                                        'mauritius'=>'MU',
                                        'mayotte'=>'YT',
                                        'mexico'=>'MX',
                                        'micronesia'=>'FM',
                                        'moldova'=>'MD',
                                        'monaco'=>'MC',
                                        'mongolia'=>'MN',
                                        'montenegro'=>'ME',
                                        'montserrat'=>'MS',
                                        'morocco'=>'MA',
                                        'mozambique'=>'MZ',
                                        'myanmar'=>'MM',
                                        'namibia'=>'NA',
                                        'nauru'=>'NR',
                                        'nepal'=>'NP',
                                        'netherlands-antilles'=>'AN',
                                        'netherlands-the'=>'NL',
                                        'new-caledonia'=>'NC',
                                        'new-zealand'=>'NZ',
                                        'nicaragua'=>'NI',
                                        'niger'=>'NE',
                                        'nigeria'=>'NG',
                                        'niue'=>'NU',
                                        'norfolk-island'=>'NF',
                                        'northern-mariana-islands'=>'MP',
                                        'norway'=>'NO',
                                        'oman'=>'OM',
                                        'pakistan'=>'PK',
                                        'palau'=>'PW',
                                        'palestinian-territory'=>'PS',
                                        'panama'=>'PA',
                                        'papua-new-guinea'=>'PG',
                                        'paraguay'=>'PY',
                                        'peru'=>'PE',
                                        'philippines'=>'PH',
                                        'pitcairn-islands'=>'PN',
                                        'poland'=>'PL',
                                        'portugal-portuguese-republic'=>'PT',
                                        'puerto-rico'=>'PR',
                                        'qatar'=>'QA',
                                        'reunion'=>'RE',
                                        'romania'=>'RO',
                                        'russian-federation'=>'RU',
                                        'rwanda'=>'RW',
                                        'saint-barthelemy'=>'BL',
                                        'saint-helena'=>'SH',
                                        'saint-kitts-and-nevis'=>'KN',
                                        'saint-lucia'=>'LC',
                                        'saint-martin'=>'MF',
                                        'saint-pierre-and-miquelon'=>'PM',
                                        'saint-vincent-and-the-grenadines'=>'VC',
                                        'samoa'=>'WS',
                                        'san-marino'=>'SM',
                                        'sao-tome-and-principe'=>'ST',
                                        'saudi-arabia'=>'SA',
                                        'senegal'=>'SN',
                                        'serbia'=>'RS',
                                        'seychelles'=>'SC',
                                        'sierra-leone'=>'SL',
                                        'singapore'=>'SG',
                                        'slovakia-slovak-republic'=>'SK',
                                        'slovenia'=>'SI',
                                        'solomon-islands'=>'SB',
                                        'somalia-somali-republic'=>'SO',
                                        'south-africa'=>'ZA',
                                        'south-georgia-and-the-south-sandwich-islands'=>'GS',
                                        'spain'=>'ES',
                                        'sri-lanka'=>'LK',
                                        'sudan'=>'SD',
                                        'suriname'=>'SR',
                                        'svalbard-jan-mayen-islands'=>'SJ',
                                        'swaziland'=>'SZ',
                                        'sweden'=>'SE',
                                        'switzerland-swiss-confederation'=>'CH',
                                        'syrian-arab-republic'=>'SY',
                                        'taiwan'=>'TW',
                                        'tajikistan'=>'TJ',
                                        'tanzania'=>'TZ',
                                        'thailand'=>'TH',
                                        'timor-leste'=>'TL',
                                        'togo'=>'TG',
                                        'tokelau'=>'TK',
                                        'tonga'=>'TO',
                                        'trinidad-and-tobago'=>'TT',
                                        'tunisia'=>'TN',
                                        'turkey'=>'TR',
                                        'turkmenistan'=>'TM',
                                        'turks-and-caicos-islands'=>'TC',
                                        'tuvalu'=>'TV',
                                        'uganda'=>'UG',
                                        'ukraine'=>'UA',
                                        'united-arab-emirates'=>'AE',
                                        'united-kingdom'=>'GB',
                                        'united-states'=>'US',
                                        'united-states-of-america'=>'US',
                                        'united-states-minor-outlying-islands'=>'UM',
                                        'united-states-virgin-islands'=>'VI',
                                        'uruguay-eastern-republic-of'=>'UY',
                                        'uzbekistan'=>'UZ',
                                        'vanuatu'=>'VU',
                                        'venezuela'=>'VE',
                                        'vietnam'=>'VN',
                                        'wallis-and-futuna'=>'WF',
                                        'western-sahara'=>'EH',
                                        'yemen'=>'YE',
                                        'zambia'=>'ZM',
                                        'zimbabwe'=>'ZW',
                                    );

                                      $country = $plugin->getMeta('country');
                                   ?>
                                    <option value="">@__('--Select--')</option>
                                   @foreach($countryList as $k => $v)
                                    <option @if( $country === $k ) selected="selected" @endif value="{!!$k!!}">{!!capital_letters($k)!!}</option>
                                   @endforeach
                              </select>
                          </div>
                      </div>

                      </div>
                      @elseif( $file_app_json && $file_app_json !== '""' )
                      <hr>
                      <div class="vn4_google_analytics" >
                        <h2>Step 2: Use this link to get your one-time-use access code: <a href="{!!$auth_url!!}" onclick="return !window.open(this.href, 'Google Auth', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=640, height=580, top='+(window.screen.height/2-290)+', left='+(window.screen.width/2-320))"  style="color:red;text-decoration:underline;">Get Access Code.</a></h2><br>
                        <div class="form-group">
                          <div class="row">
                            <label class="col-md-2 col-xs-12" style="line-height:28px;" >Access Code:</label>
                            <div class="col-md-8 col-sm-8 col-xs-12 vn4-pd0">
                              <input name="access_code" value="" type="text" id="access_code" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                        </div>
                      </div>
                      @endif
                    <?php
                  }
                ]
            ],true,'screen');
         ?>
        


      </div>

      <div class="col-xs-12 col-md-3">

        <?php 

          vn4_panel('Action',function(){

            echo '<button class="vn4-btn vn4-btn-blue" data-message="The process is running, please wait a moment">Save changes</button>';

          });

         ?>

        

      </div>

    </div>

  </form>

@stop

@section('js')

  <link href="{!!asset('')!!}/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
  <script src="{!!asset('')!!}/vendors/select2/dist/js/select2.full.min.js"></script>
  <script>
      $("select").select2({
        placeholder: "Nhấp để chọn",
        allowClear: true
      });
  </script>

@stop