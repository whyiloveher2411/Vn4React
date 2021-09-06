<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="{!!asset('')!!}public/admin/css/custom.min.css" rel="stylesheet">
<link href="{!!asset('public/vendors/font-awesome/css/font-awesome.min.css')!!}" rel="stylesheet">
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

 a img {
  border: 0;
}

 abbr[title],  acronym[title],  span[title],  strong[title] {
  border-bottom: thin dotted;
  cursor: help;
}

 acronym:hover,  abbr:hover {
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

 fieldset {
  background-color: #eaebee;
}

 legend {
  font-size: 1.1em;
  padding: 1em 0 0.23em;
  margin-bottom: 0;
}

 legend a:link,  legend a:visited,  legend a:hover,  legend a:active {
  text-decoration: none;
}

 div,  p,  li,  h2 {
  font-family: sans-serif;
}

 h2 {
  font-size: 16px;
}

#top {
  margin-left: 3%
}

 th,  td {
  padding-top: 1px;
  padding-bottom: 1px;
  margin: 0;
}

 hr {
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

 body {
  font-family: sans-serif;
  font-size: inherit;
  margin: 0;
}


 legend {
  font: inherit;
  vertical-align: inherit;
  padding: 0;
}

 fieldset {
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

 label {
  font: caption;
  vertical-align: baseline;
  padding: 0;
}

 select {
  vertical-align: baseline;
}

 textarea {
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

 table {
  width: 100%;
  table-layout: fixed;
}

 fieldset td,  fieldset th {
  padding-top: 0.4em;
  padding-bottom: 0.4em;
}

tr:first-child td, tr:first-child th {
  vertical-align: top;
}

 fieldset th {
  padding-left: 0;
  padding-right: 0.4em;
  text-align: right;
  width: 8em;
  font-weight: inherit;
}

 fieldset td {
  padding-left: 0;
  padding-right: 0;
}

 textarea, #doc[type="url"] {
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

 ol {
  margin: 1.5em 0;
  padding: 0 2.5em;
}

 li {
  margin: 0;
}

 li ol {
  padding-right: 0;
  margin-top: 0.5em;
  margin-bottom: 0;
}

 li li {
  padding-right: 0;
  padding-bottom: 0.2em;
  padding-top: 0.2em;
}

#results > ol:first-child {
  background-color: #efefef;
  border-radius: 4px;
}

 ol{padding: 0 !important;    list-style-type: decimal !important;   
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

 hr {
  border-top: 1px dotted #666666;
  border-bottom: none;
  border-left: none;
  border-right: none;
  height: 0;
}

 p {
  margin: 0.5em 0 0.5em 0;
}

 li p {
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

 code {
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
.location a{
    background: #de0000;
    color: white;
    padding: 3px 15px;
    border-radius: 3px;}
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

 dl {
  margin-top: 0.5em;
  margin-bottom: 0;
}

 dd {
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

 img {
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
 dd code ~ span {
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
  min-height: 20px;
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
.disclaimer,#banner,   #top, #about,form, .vn4-nav-top-login,.conduct,.title.title-master,footer{display: none;}
.nav-md .container.body ,.nav-md {margin:0;}
body{padding-top: 0 !important;background: none;}
code {
    padding: 2px 4px;
    font-size: 90%;
    color: #c7254e;
    background-color: #f9f2f4;
    border-radius: 4px;
}
.pacman {
    position: relative;
    top: 50%;
    left: 50%;
    width: auto;
    display: inline-block;
    -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
     }
.pacman > div:nth-child(2) {
    -webkit-animation: pacman-balls 1s 0s infinite linear;
    animation: pacman-balls 1s 0s infinite linear; }
.pacman > div:nth-child(3) {
    -webkit-animation: pacman-balls 1s 0.33s infinite linear;
    animation: pacman-balls 1s 0.33s infinite linear; }
.pacman > div:nth-child(4) {
    -webkit-animation: pacman-balls 1s 0.66s infinite linear;
    animation: pacman-balls 1s 0.66s infinite linear; }
.pacman > div:nth-child(5) {
    -webkit-animation: pacman-balls 1s 0.99s infinite linear;
    animation: pacman-balls 1s 0.99s infinite linear; }
.pacman > div:first-of-type {
    width: 0px;
    height: 0px;
    border-right: 25px solid transparent;
    border-top: 25px solid #fff;
    border-left: 25px solid #fff;
    border-bottom: 25px solid #fff;
    border-radius: 25px;
    -webkit-animation: rotate_pacman_half_up 0.5s 0s infinite;
    animation: rotate_pacman_half_up 0.5s 0s infinite; }
.pacman > div:nth-child(2) {
    width: 0px;
    height: 0px;
    border-right: 25px solid transparent;
    border-top: 25px solid #fff;
    border-left: 25px solid #fff;
    border-bottom: 25px solid #fff;
    border-radius: 25px;
    -webkit-animation: rotate_pacman_half_down 0.5s 0s infinite;
    animation: rotate_pacman_half_down 0.5s 0s infinite;
    margin-top: -50px; }
.pacman > div:nth-child(3), .pacman > div:nth-child(4), .pacman > div:nth-child(5), .pacman > div:nth-child(6) {
    background-color: #fff;
    width: 15px;
    height: 15px;
    border-radius: 100%;
    margin: 2px;
    width: 10px;
    height: 10px;
    position: absolute;
    -webkit-transform: translate(0, -6.25px);
    -ms-transform: translate(0, -6.25px);
    transform: translate(0, -6.25px);
    top: 25px;
    left: 100px; }
    .popup-loadding{
  display: none;
    color: white;
    position: fixed;
    z-index: 99999;
    background: rgba(0, 0, 0, 0.5);
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
}
html.show-popup .popup-loadding{
  display: block;
}

@-webkit-keyframes fade {
  50%{opacity:0.1}
  100%{opacity:1}
  ;}
@-moz-keyframes fade {
 50%{opacity:0.1}
  100%{opacity:1}
}
@-o-keyframes fade {
   50%{opacity:0.1}
  100%{opacity:1}
@keyframes fade {
   50%{opacity:0.1}
  100%{opacity:1}
}


.popup-loadding .content{
  position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    font-size: 28px;
    margin-top: 50px;
    animation: fade 1.5s infinite;
    -webkit-animation: fade 1.5s infinite;
    -o-animation: fade 1.5s infinite;
    -moz-animation: fade 1.5s infinite;

}

.popup-loadding .content i{
  color: white;
}

    </style>


<?php 

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
  <input type="hidden" name="is_editor" value="true">
  <input type="hidden" name="key" value="{!!$key!!}">
  <textarea hidden id="source_code" name="code">{!!$code!!}</textarea>
  </form>
  {!!$response!!}
  

<div class="popup-loadding">
    <div class="pacman"><div><div><div><div><div></div></div><div></div></div><div><div></div></div><div></div></div><div><div><div></div></div><div></div></div><div><div></div></div><div></div></div><div><div><div><div></div></div><div></div></div><div><div></div></div><div></div></div><div><div><div></div></div><div></div></div><div><div></div></div><div></div></div>
    <p class="content">... @__('Loading') ...</p>
</div>

<script src="{!!asset('')!!}public/vendors/jquery/jquery.min.js?v=1"></script>
<script type="text/javascript" src="{!!asset('public/admin/js/validate-html.js')!!}"></script>


<script type="text/javascript">

  $(window).load(function(){

    $('.source code').on('focus', function() {
      before = $(this).html();
    }).on('blur keyup paste', function() { 
      if (before != $(this).html()) { $(this).trigger('change'); }
    });

    $('.source code').on('change', function() {
      $('#source_code').val($('.source code').text());
    });

    $('body').on('click','.save_changes',function(){
        parent.document.getElementById('{!!$key!!}').value = $('#source_code').val();

        if( parent.tinymce ){
          if( parent.tinymce.get("{!!$key!!}").setContent($('#source_code').val()) );
        }
        $('#f_{!!$key!!}', window.parent.document).html($('#source_code').val());
        $('#popupValidateHtmlW3C button.close', window.parent.document).trigger('click');
    });

    $('.source code').attr('contenteditable','true').attr('name','code');
    $('.source').append('<br><span id="formReValidate" class="vn4-btn vn4-btn-blue">Revalidate</span> ');
    $('.source').append('<span style="float:right;" class="vn4-btn vn4-btn-blue save_changes" >Save changes</span>');

    $(document).on('click','#formReValidate',function(){
      $('html').addClass('show-popup');
      $('#formValidate').attr('method','POST');
      $('#formValidate').submit();
    });

  });
</script>
