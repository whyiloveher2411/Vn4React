                
@extends(backend_theme('master'))
@section('css')
    <style type="text/css">
#banner, #banner a {
  margin: 0;
  padding: 0;
  border: 0;
  font-weight: normal;
  font-style: normal;
  font-size: 100%;
  font-family: sans-serif;
  vertical-align: baseline;
  background-color: white;
  color: #1f2126;
  line-height: 1;
  text-align: left;
}

.right_col a img {
  border: 0;
}

.right_col abbr[title], .right_col acronym[title], .right_col span[title], .right_col strong[title] {
  border-bottom: thin dotted;
  cursor: help;
}

.right_col acronym:hover, .right_col abbr:hover {
  cursor: help;
}

#csslabel {
  font-size: 11px;
  margin-left: 4px;
}

#title {
  font-family: "Myriad Web", "Myriad Pro", "Gill Sans", Helvetica, Arial, Sans-Serif;
  background-color: #365d95;
  color: #fdfdfd;
  font-size: 1.6em;
  padding: 0.43em;
  border-radius: 6px;
}
#title a, #title a img {
  background-color: #365d95;
}

#title a:link, #title a:hover, #title a:visited, #title a:active {
  color: #fdfdfd !important;
  text-decoration: none;
}

#title img {
  vertical-align: middle;
  margin-right: 0.7em;
}

#banner {
  margin: 1.5em 2em;
}

.right_col fieldset {
  background-color: #eaebee;
}

.right_col legend {
  font-size: 1.1em;
  padding: 1em 0 0.23em;
  margin-bottom: 0;
}

.right_col legend a:link, .right_col legend a:visited, .right_col legend a:hover, .right_col legend a:active {
  text-decoration: none;
}

.right_col div,.right_col  p,.right_col  li, .right_col h2 {
  font-family: sans-serif;
}

.right_col h2 {
  font-size: 16px;
}

#top {
  margin-left: 3%
}

.right_col th,.right_col  td {
  padding-top: 1px;
  padding-bottom: 1px;
  margin: 0;
}

.right_col hr {
  margin-left: 3%;
  margin-right: 3%;
}

#banner {
  margin-left: 3%;
  margin-right: 3%;
  margin-bottom: 18px
}

#results,
#about {
  font-size: 14px;
  margin-top: 50px;
  padding-left: 3%;
  margin-right: 3%;
}

#about {
  margin-bottom: 12px;
}

p.disclaimer {
  font: caption;
  margin-left: 3%;
  margin-right: 3%;
  color: #747474;
}

.alert {
  color: black;
  background-color: yellow
}

.right_col body {
  font-family: sans-serif;
  font-size: inherit;
  margin: 0;
}


.right_col legend {
  font: inherit;
  vertical-align: inherit;
  padding: 0;
}

.right_col fieldset {
  font: caption;
  font-family: inherit;
  font-size: inherit;
  padding: 0.5% 1.5% 0.5% 1.5%;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin: 0;
  background-color: white;
  vertical-align: inherit;
}

.right_col label {
  font: caption;
  vertical-align: baseline;
  padding: 0;
}

.right_col select {
  vertical-align: baseline;
}

.right_col textarea {
  font: caption;
  font-size: 0.85em;
  border: 1px solid;
  margin: 2px;
  padding: 2px;
}

#inputregion {
  margin-top: 12px;
}

#inputlabel {
  margin-left: 2px;
}

#doc {
  width: 95.5%;
  margin-left: 2px;
  margin-top: 2px;
  padding: 3px 5px 2px 5px;
  border-radius: 6px;
  border: solid #ccc 1px;
}

#doc[type="file"] {
  margin-top: -3px;
  width: initial;
  border: 0;
}

#docselect {
  margin-left: 3px;
}

#submit {
  margin-left: 2px;
}

.right_col table {
  width: 100%;
  table-layout: fixed;
}

.right_col fieldset td, .right_col fieldset th {
  padding-top: 0.4em;
  padding-bottom: 0.4em;
}

tr:first-child td, tr:first-child th {
  vertical-align: top;
}

.right_col fieldset th {
  padding-left: 0;
  padding-right: 0.4em;
  text-align: right;
  width: 8em;
  font-weight: inherit;
}

.right_col fieldset td {
  padding-left: 0;
  padding-right: 0;
}

.right_col textarea, #doc[type="url"] {
  font-family: Monaco, Consolas, Andale Mono, monospace;
}

.stats, .details {
  font-size: 0.85em;
}

.details .msgschema {
  display: none;
}

.details p {
  margin: 0;
}

.success, .failure, .fatalfailure {
  border-radius: 4px;
  padding: 0.5em;
  font-weight: bold;
  font-family: Arial, sans-serif;
}

.success {
  color: black;
  background-color: #ccffcc;
  border: 1px solid #ccc;
}

.failure {
  color: white;
  background-color: #365d95;
}

.fatalfailure {
  color: white;
  background-color: red;
}

.right_col ol {
  margin: 1.5em 0;
  padding: 0 2.5em;
}

.right_col li {
  margin: 0;
}

.right_col li ol {
  padding-right: 0;
  margin-top: 0.5em;
  margin-bottom: 0;
}

.right_col li li {
  padding-right: 0;
  padding-bottom: 0.2em;
  padding-top: 0.2em;
}

#results > ol:first-child {
  background-color: #efefef;
  border-radius: 4px;
}

.right_col ol{padding: 0 !important;    list-style-type: decimal !important;   
    -webkit-margin-after: 1em !important;
    -webkit-margin-start: 0px !important;
    -webkit-margin-end: 0px !important;
    -webkit-padding-start: 40px !important;}
#results > ol:first-child > li {
  list-style-type: decimal !important;   
  border: 1px solid #ccc;
  margin-bottom: 8px;
  padding-left: 12px;
  border-radius: 4px;
  background-color: white;
}

#results > ol:first-child > li > p:first-child,
#results > ol:first-child > li > p:first-child code {
  font-size: 16px;
  font-weight: bold;
}

#results > ol:first-child > li > p:first-child code {
  font-weight: normal;
}

#results > ol:first-child > li > p:first-child {
  color: transparent;
}

#results > ol:first-child > li > p:first-child > strong,
#results > ol:first-child > li > p:first-child > span {
  color: black;
}

#results > ol:first-child > li > p:first-child > strong:first-child {
  padding: 1px 6px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font: caption;
  font-weight: bold;
}

.info, .warning, .error, .io, .fatal, .schema, .internal {
  color: black;
}

.info > p:first-child > strong:first-child {
  background-color: #ccffcc;
}

.warning > p:first-child > strong:first-child {
  background-color: #ffffcc;
}

.error > p:first-child > strong:first-child,
.io > p:first-child > strong:first-child,
.fatal > p:first-child > strong:first-child,
.schema > p:first-child > strong:first-child,
.internal > p:first-child > strong:first-child {
  background-color: #ffcccc;
}

.right_col hr {
  border-top: 1px dotted #666666;
  border-bottom: none;
  border-left: none;
  border-right: none;
  height: 0;
}

.right_col p {
  margin: 0.5em 0 0.5em 0;
}

.right_col li p {
  margin: 0;
}

.stats, .details {
  margin-top: 0.75em;
}

.lf {
  color: #222222;
}

.extract {
  overflow: hidden;
  max-height: 5.5em;
}

.extract b, .source b {
  color: black;
  background-color: #ffff80;
}

.extract b {
  font-weight: normal;
}

ol.source li {
  padding-top: 0;
  padding-bottom: 0;
}

ol.source b, ol.source .b {
  color: black;
  background-color: #ffff80;
  font-weight: bold;
}

.right_col code {
  white-space: pre;
  white-space: -pre-wrap;
  white-space: -o-pre-wrap;
  white-space: -moz-pre-wrap;
  white-space: -hp-pre-wrap;
  white-space: pre-wrap;
  word-wrap: break-word;
}

.error p,
.info p,
.warning p,
.error dd,
.info dd,
.warning dd {
  line-height: 1.8;
}

.error p code {
  border: 1px dashed #999;
  padding: 2px;
  padding-left: 4px;
  padding-right: 4px;
}

.warning code {
  border: 1px dashed #999;
  padding: 2px;
  padding-left: 4px;
  padding-right: 4px;
}

.extract code {
  background-color: inherit;
  border: none;
  padding: 0;
}

.right_col dl {
  margin-top: 0.5em;
  margin-bottom: 0;
}

.right_col dd {
  margin-left: 1.5em;
  padding-left: 0;
  margin-top: 2px;
}

table.imagereview {
  width: 100%;
  table-layout: auto;
  border-collapse: collapse;
  border-spacing: 0;
}

col.img {
  width: 180px;
}

col.alt {
  color: black;
  background-color: #ffffcc;
}

td.alt span {
  color: black;
  background-color: #ffffaa;
}

.imagereview th {
  font-weight: bold;
  text-align: left;
  vertical-align: bottom;
}

.imagereview td {
  vertical-align: middle;
}

td.img {
  padding: 0 0.5em 0.5em 0;
  text-align: right;
}

.right_col img {
  max-height: 180px;
  max-width: 180px;
  -ms-interpolation-mode: bicubic;
}

th.img {
  padding: 0 0.5em 0.5em 0;
  vertical-align: bottom;
  text-align: right;
}

td.alt, td.location {
  text-align: left;
  padding: 0 0.5em 0.5em 0.5em;
}

th.alt, th.location {
  padding: 0 0.5em 0.5em 0.5em;
  vertical-align: bottom;
}


*[irrelevent], .irrelevant {
  display: none;
}

/* "(required)" text in spec advice */
.right_col dd code ~ span {
  color: #666;
}

dl.inputattrs {
  display: table;
}

dl.inputattrs dt {
  display: table-caption;
}

dl.inputattrs dd {
  display: table-row;
}

dl.inputattrs .inputattrname,
dl.inputattrs .inputattrtypes,
dl.inputattrs > dd > a {
  display: table-cell;
  padding-top: 2px;
  padding-left: 1.5em;
  padding-right: 1.5em;
}

dl.inputattrs .inputattrtypes {
  padding-left: 4px;
  padding-right: 4px;
}

.inputattrtypes > a {
  color: #666;
}

dl.inputattrs .highlight {
  background-color: #ffc;
  padding-bottom: 2px;
  font-weight: normal;
  color: #666;
}

@media all and (max-width: 24em) {
  table, thead, tfoot, tbody, tr, th, td {
    display: block;
    width: 100%;
  }
  th {
    text-align: left;
    padding-bottom: 0;

  }
}

.checkboxes label {
  margin-right: 20px;
}

#xnote {
  color: #747474;
  margin-left: 2px;
  margin-top: 6px;
}

#outline h2 {
  margin-top: 24px;
  margin-bottom: 0;
}

#outline .heading {
  color: #bf4f00;
  font-weight: bold;
}

#outline ol {
  margin-top: 0;
  padding-top: 1px;
}

#outline > h2 + ol {
  margin-top: 0;
}

#outline li {
  padding: 0 0 9px 0;
  margin: 0;
  list-style-type: none;
  position: relative;
}

#outline li:first-child {
  padding-top: 7px;
}

#outline li li {
  list-style-type: none;
}

#outline li:first-child::before {
  position: absolute;
  top: 1px;
  height: 13px;
  left: -0.75em;
  width: 0.5em;
  border-color: #bbb;
  border-style: none none solid solid;
  content: '';
  border-width: 0.1em;
}

#outline li:not(:last-child)::after {
  position: absolute;
  top: 1px;
  bottom: -0.6em;
  left: -0.75em;
  width: 0.5em;
  border-color: #bbb;
  border-style: none none solid solid;
  content: '';
  border-width: 0.1em;
}

#results .hidden {
  display: none;
}

#filters {
  margin-left: 3%;
  margin-right: 3%;
  margin-bottom: 1em;
  padding: 4px;
  padding-bottom: 0.5em;
}

#filters > div {
  font: caption;
  color: #747474;
  background-color: #ffffcc;
  padding: 4px;
}

#filters button {
  min-height: 18px;
  border-radius: 6px;
  border: solid #ccc 1px;
  background-color: #ffffcc;
}
button.message_filtering{padding: 5px;position: relative;
    margin: 0 2px;
    white-space: nowrap;
    display: inline-block;
    position: relative;
    border-radius: 3px;
    line-height: 28px;
    height: 28px;
    padding: 0 10px;
    cursor: pointer;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    color: #333;
    font-weight: normal;
    font-size: 13px;
    line-height: 26px;
    text-align: center;
    text-decoration: none;
    background: #f7f7f7;
    border: #BBBBBB solid 1px;
    -webkit-box-shadow: 0 1px 0 #ccc;
    box-shadow: 0 1px 0 #ccc;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;}
.message_filtering {
  background-color: white !important;
  -o-transition: all 1.5s ease-out;
  -moz-transition: all 1.5s ease-out;
  -ms-transition: all 1.5s ease-out;
  -webkit-transition: all 1.5s ease-out;
  transition: all 1.5s ease-out;
}

#filters .filtercount {
  font: caption;
  font-style: italic;
  padding-left: 4px;
  padding-top: 6px;
}

#filters.expanded {
  background-color: #ffffcc;
  -o-transition: all 0.8s ease-out;
  -moz-transition: all 0.8s ease-out;
  -ms-transition: all 0.8s ease-out;
  -webkit-transition: all 0.8s ease-out;
  transition: all 0.8s ease-out;
  opacity: 1;
  visibility: visible;
}

#filters.unexpanded {
  -o-transition: all 0.8s ease-out;
  -moz-transition: all 0.8s ease-out;
  -ms-transition: all 0.8s ease-out;
  -webkit-transition: all 0.8s ease-out;
  transition: all 0.8s ease-out;
}

#filters h2 {
  margin-top: 4px;
  margin-bottom: 0;
}

#filters fieldset {
  margin: 1em;
  font: caption;
}

#filters fieldset.hidden,
.checkboxes input.hidden,
.checkboxes .extraoptions.hidden {
  -o-transition: all 0.8s ease-out;
  -moz-transition: all 0.8s ease-out;
  -ms-transition: all 0.8s ease-out;
  -webkit-transition: all 0.8s ease-out;
  transition: all 0.8s ease-out;
  opacity: 0;
  visibility: hidden;
  height: 0;
  margin: -45px;
}

#filters fieldset.unhidden,
.checkboxes input.unhidden,
.checkboxes .extraoptions.unhidden {
  -o-transition: all 0.8s ease-out;
  -moz-transition: all 0.8s ease-out;
  -ms-transition: all 0.8s ease-out;
  -webkit-transition: all 0.8s ease-out;
  transition: all 0.8s ease-out;
  opacity: 1;
  visibility: visible;
}

.checkboxes .extraoptions label {
  margin-right: 0;
}

#filters fieldset.unhidden,
.checkboxes input.unhidden {
  background-color: #ffffcc;
}

#filters fieldset legend {
  font-weight: bold;
  font-family: sans-serif;
  display: inline;
  width: auto;
  border: none;
  padding: 5px;
}

#filters fieldset legend a {
  font-weight: normal;
}
#filters input {
    margin-right: 10px;
}
#filters ol {
  counter-reset: item;
  margin: 0;
  padding: 0 0 0 40px;
}

#filters ol ol {
  margin-top: 6px;
}

#filters li {
  list-style-type: none;
  margin: 6px 0 0;
  position: relative;
  line-height: 1.8;
}

#filters li li {
  margin: 0;
}

#filters li:before {
  content: counters(item, ".") " ";
  counter-increment: item;
  width: 40px;
  position: absolute;
  top: 0;
  left: -50px;
  text-align: right;
  color: #777;
}

#filters fieldset label {
  font-family: sans-serif;
}

#filters code {
  white-space: pre;
  white-space: -pre-wrap;
  white-space: -o-pre-wrap;
  white-space: -moz-pre-wrap;
  white-space: -hp-pre-wrap;
  white-space: pre-wrap;
  word-wrap: break-word;
  border: 1px dashed #999;
  background-color: #ffd;
  padding: 2px 4px;
}

#filters .hide, #filters .show {
  color: blue;
  display: inline-block !important;
}

.checkboxes {
  margin-left: 2px;
}

.checkboxes label {
  margin-right: 16px;
}

.checkboxgroup {
  padding: 3px 6px 2px 2px;
  border-radius: 6px;
  border: solid #ccc 1px;
  font-size: 11px;
  margin-right: 10px;
}

.checkboxgroup label {
  font-size: 11px;
}

label[for=showimagereport] {
  margin-right: 0;
}

input[list=useragents], input#acceptlanguage {
  padding: 2px 4px 3px 4px;
  border-radius: 6px;
  border: solid #ccc 1px;
}

input[list=useragents] {
  width: 30.5%;
  margin-right: 10px;
}

input#acceptlanguage {
  width: 55px;
}

@media (max-width: 1234px) {
  #accept-language-label {
    display: block;
    margin-top: 8px;
  }
}

@media (min-width: 954px) {
  .checkboxes .extraoptions {
    padding-left: 8px;
  }
}

@media (max-width: 953px) {
  .extraoptions {
    display: block;
    margin-top: 8px;
    padding-left: 0;
  }
  .checkboxes {
    margin-bottom: -43px;
  }
  #inputregion {
    margin-top: 76px;
  }
  .extraoptions.unhidden {
    margin-bottom: -68px;
  }
  input[list=useragents] {
    width: 350px;
  }
  #accept-language-label {
    display: inline;
  }
}

@media (max-width: 836px) {
  #accept-language-label {
    display: block;
    margin-top: 8px;
  }
}

@media (max-width: 640px) {
  #show_options {
    display: block;
    margin-top: 8px;
    padding-left: 0;
  }
  #inputregion {
    margin-top: 100px;
  }
  .extraoptions.unhidden {
    margin-bottom: -90px;
  }
  #user-agent-label {
    display: block;
    margin-top: 8px;
  }
  input[list=useragents] {
    width: 96.9%
  }
  #about {
    font-size: 11px;
  }
  .checkboxes {
    font-size: 12px;
  }
}

#headingoutline p {
  margin: 10px;
  font-weight: bold;
  color: #bf4f00;
}

.h2 {
  padding-left: 24px;
}

.h3 {
  padding-left: 48px;
}

.h4 {
  padding-left: 72px;
}

.h5 {
  padding-left: 96px;
}

.h6 {
  padding-left: 120px;
}

.headinglevel, .missingheadinglevel {
  border-radius: 4px;
  padding: 1px 3px 1px 4px;
  font-size: 80%;
  font-weight: normal;
  color: white;
}

.headinglevel {
  background-color: green;
}

.missingheadinglevel {
  background-color: #800000;
}

.missingheading {
  color: #747474;
}
.source code b[id]{}
.disclaimer,#banner, .right_col form, #top, #about{display: none;}
    </style>
@stop

@section('content')

<?php 
  title_head(__('Validate HTML - Tool')); 

  add_action('vn4_heading',function(){
    echo '<a href="'.route('admin.page','tool-genaral').'" class="vn4-btn">Quay lại</a>';
  });

  $pattern = '/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\')\/\/.*))/';


  // $view = trim(preg_replace('/\s\s+/', '', $view));

  $arg1 = array(
      '/ {2,}/',
      '/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'
      );

  $arg2 = array(
      ' ',
      ''
      );

  $code = preg_replace($pattern, '', $code);
  $code = preg_replace($arg1, $arg2 , $code );
  
  $data = array('fragment' => '<!DOCTYPE html><html lang="en"><head><title>Title of the document</title></head><body>'.$code.'</body></html>','doctype'=>'HTML5');

  $data['output'] = 'soap12';

  $resource = curl_init('http://validator.w3.org/check');
  curl_setopt($resource, CURLOPT_USERAGENT, 'curl');
  curl_setopt($resource, CURLOPT_POST, true);
  curl_setopt($resource, CURLOPT_POSTFIELDS, $data);
  curl_setopt($resource, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);

  $response = curl_exec($resource);

  $response = str_replace(['<script src="script.js"></script>','<link href="style.css" rel="stylesheet">','&lt;!DOCTYPE html&gt;&lt;html lang="en"&gt;&lt;head&gt;&lt;title&gt;Title of the document&lt;/title&gt;&lt;/head&gt;&lt;body&gt;','&lt;/body&gt;&lt;/html&gt;'],'',$response);
  ?>

  <form method="POST" id="formValidate">
  <input type="hidden" name="_token" value="{!!csrf_token()!!}">
  <textarea hidden id="source_code" name="code">{!!$code!!}</textarea>
  </form>
  
  {!!$response!!}
@stop

@section('js')
    <script type="text/javascript" src="{!!asset('public/admin/js/validate-html.js')!!}"></script>
    <script type="text/javascript">
      $(window).load(function(){

        var form = document.createElement( "form" );
        form.setAttribute('method', 'POST');
        form.setAttribute('style', 'display:block;');

        $('.source code').on('focus', function() {
          before = $(this).html();
        }).on('blur keyup paste', function() { 
          if (before != $(this).html()) { $(this).trigger('change'); }
        });

        $('.source code').on('change', function() {
          $('#source_code').val($('.source code').text());
        });

        $('.source').wrap(form);
        $('.source code').attr('contenteditable','true').attr('name','code');
        $('.source').append('<br><span id="formReValidate" class="vn4-btn vn4-btn-blue">Revalidate</span> ');
       

        $(document).on('click','#formReValidate',function(){
          $('html').addClass('show-popup');
          $('#formValidate').attr('method','POST');
          $('#formValidate').submit();
        });

      });
    </script>
@stop
