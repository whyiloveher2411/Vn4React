 <style type="text/css">
    button {
      background-color: #eee;
      border: 0;
      border-radius: 0.125em;
      box-shadow:
        -0.2em -0.125em 0.125em rgba(0, 0, 0, 0.25), 
        0 0 0 0.04em rgba(0, 0, 0, 0.3), 
        0.02em 0.02em 0.02em rgba(0, 0, 0, 0.4) inset, 
        -0.05em -0.05em 0.02em rgba(255, 255, 255, 0.8) inset;
      color: #777;
      font-size: 1em;
      outline: 0;
      position: relative;
      vertical-align: top;
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      -webkit-tap-highlight-color: transparent;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }
    button:not(:last-of-type) {
      margin-right: 0.35em;
    }
    button:active {
      box-shadow:
        0.1em 0.1em 0.1em rgba(0, 0, 0, 0.2),
        0 0 0 0.05em rgba(0, 0, 0, 0.4), 
        -0.025em -0.05em 0.025em rgba(255, 255, 255, 0.8) inset;
    }
    button span {
      display: inline-block;
    }
    button > span {
      margin: auto;
      padding: 0.2em 0.375em;
      position: absolute;
      top: 50%;
      left: 0;
      font-size: 0.5em;
      line-height: 2;
      transform: translateY(-50%) scaleX(0.875);
      width: 100%;
    }

    /* Keyboard */
    .keyboard {
      border-radius: 0.5em;
      box-shadow: -1px -1px 1.5px rgba(0, 0, 0, 0.6), 0 0 0 1px #aaa inset;
      display: grid;
      grid-template-columns: 21.25em 4.125em 5.65em;
      grid-template-rows: 0.75em 1.125em 1.125em 1.125em 1.125em 1.375em;
      grid-gap: 0.375em 0.875em;
      font-size: 36px;
      margin: 10px auto 10px auto;
      padding: 0.25em;
      width: 33.25em;
      height: 9em;
    }
    .row:nth-of-type(14) {
      text-align: center;
    }
    .row:nth-of-type(n + 14):nth-of-type(-3n + 17) {
      transform: translateY(0.25em);
    }
    .bump {
      border-radius: 0.1em;
      box-shadow: -0.05em -0.02em 0 0.05em rgba(0, 0, 0, 0.3);
      padding: 0;
      top: 85%;
      left: calc(50% - 0.4em);
      width: 0.8em;
      height: 0.15em;
    }

    button.disable{
      pointer-events: none;
      opacity: .5;
      background: gray;
      color: black;
      box-shadow: -0.2em -0.125em 0.125em rgba(0, 0, 0, 0.25), 0 0 0 0.04em rgba(0, 0, 0, 0.3), 0.02em 0.02em 0.02em rgba(0, 0, 0, 0.4) inset, 0em 0em 0em rgba(255, 255, 255, 0.8) inset;
    }
    /* Button size */
    .btn0 {
      width: 1.19em;
      height: 0.75em;
    }
    .btn1 {
      width: 1.125em;
      height: 0.75em;
    }
    .btn2 {
      width: 1.125em;
      height: 1.125em;
    }
    .btn3 {
      width: 2em;
      height: 1.125em;
    }
    .btn4 {
      width: 2.3em;
      height: 1.125em;
    }
    .btn5 {
      width: 3.05em;
      height: 1.125em;
    }
    .btn6 {
      width: 1.5625em;
      height: 1.375em;
    }
    .btn7 {
      width: 1.8375em;
      height: 1.375em;
    }
    .btn8 {
      width: 1.125em;
      height: 1.375em;
    }
    .btn9 {
      width: 2.6875em;
      height: 1.375em;
    }
    .btn10 {
      width: 1.125em;
      height: 2.875em;
    }
    .btn-longest {
      width: 8.625em;
      height: 1.375em;
    }

    /* Button text alignment */
    .ul, .ll, .ur, .lr {
      top: 0;
      transform: scaleX(0.875);
    }
    .ul, .ll {
      text-align: left;
      transform-origin: 0 50%;
    }
    .ur, .lr {
      text-align: right;
      transform-origin: 100% 50%;
    }
    .ll, .lr {
      top: auto;
      bottom: 0;
    }
    .noxscale {
      transform: translateY(-50%) scaleX(1);
    }
    .ll.noxscale, .lr.noxscale {
      transform: scaleX(1);
    }

    /* Button font size */
    .xxxs {
      font-size: 0.2em;
      line-height: 1.5;
    }
    .xxs {
      font-size: 0.25em;
      line-height: 1.5;
    }
    .xs {
      font-size: 0.3em;
      line-height: 1.125;
    }
    .sm {
      font-size: 0.4em;
      line-height: 1.25;
    }

    /* Icons */
    .up, .right, .down, .left {
      width: 0;
      height: 0;
      vertical-align: 0.1em;
    }
    .up {
      border-left: 0.25em solid transparent;
      border-right: 0.25em solid transparent;
      border-bottom: 0.5em solid currentColor;
    }
    .right {
      border-left: 0.5em solid currentColor;
      border-top: 0.25em solid transparent;
      border-bottom: 0.25em solid transparent;
    }
    .down {
      border-left: 0.25em solid transparent;
      border-right: 0.25em solid transparent;
      border-top: 0.5em solid currentColor;
    }
    .left {
      border-right: 0.5em solid currentColor;
      border-top: 0.25em solid transparent;
      border-bottom: 0.25em solid transparent;
    }
    .pause {
      border-left: 0.2em solid;
      border-right: 0.2em solid;
      vertical-align: 0.1em;
      width: 0.475em;
      height: 0.5em;
    }
    .emoji {
      filter: saturate(0);
      -webkit-filter: saturate(0);
    }
    .cascade:before, .cascade:after, .block {
      border: 1px solid;
    }
    .cascade {
      position: relative;
      height: 1em;
      width: 1.2em;
    }
    .cascade:before, .cascade:after {
      content: "";
      position: absolute;
      height: 0.45em;
      width: 0.8em;
    }
    .cascade:before {
      top: 0;
      left: 0;
    }
    .cascade:after {
      right: 0;
      bottom: 0;
    }
    .block {
      margin-left: 0.1em;
      height: 0.8em;
      width: 0.6em;
      vertical-align: 0.1em;
    }
    .apps:before, .apps:after {
      font-weight: bold;
      display: block;
      content: "\25A1\25A1\25A1";
      line-height: 0.875;
    }

    /* Miscellaneous */
    .on {
      color: #8dff00;
      text-shadow: 0 0 2px #478800;
    }
    .noxpad {
      padding: 0.2em 0;
    }

    /* IE 11 fix */
    @media all and (-ms-high-contrast: none), (-ms-high-contrast: active) {
      .keyboard {
        display: -ms-grid;
        -ms-grid-columns: 22.125em 5em 5.75em;
        -ms-grid-rows: 1.125em 1.5em 1.5em 1.5em 1.5em 1.375em;
      }
      .row:nth-child(3n + 2) {
        -ms-grid-column: 2;
      }
      .row:nth-child(3n + 3) {
        -ms-grid-column: 3;
      }
      .row:nth-child(n + 4):nth-child(-n + 6) {
        -ms-grid-row: 2;
      }
      .row:nth-child(n + 7):nth-child(-n + 9) {
        -ms-grid-row: 3;
      }
      .row:nth-child(n + 10):nth-child(-n + 12) {
        -ms-grid-row: 4;
      }
      .row:nth-child(n + 13):nth-child(-n + 15) {
        -ms-grid-row: 5;
      }
      .row:nth-child(n + 16) {
        -ms-grid-row: 6;
      }
      .row:nth-of-type(14) button {
        transform: translateX(-0.5em);
      }
    }
</style>
<form method="POST">
  <input type="hidden" name="_token" value="{!!csrf_token()!!}">
  <div @if( Request::has('iframe') ) style="position: absolute;z-index: -1;opacity: 0;pointer-events: none;" @endif>
  <div class="keyboard" ontouchstart="">
    <div class="row-keyboard"><button type="button" class="btn0 disable"><span class="xs">esc</span>
      </button><button type="button" class="btn0 disable"><span class="xs noxscale"><span class="emoji">&#128261;</span></span><span class="lr xxxs">F1</span>
      </button><button type="button" class="btn0 disable"><span class="xs noxscale"><span class="emoji">&#128262;</span></span><span class="lr xxxs">F2</span>
      </button><button type="button" class="btn0 disable"><span class="xs noxscale"><span class="cascade"></span><span class="block"></span></span><span class="lr xxxs">F3</span>
      </button><button type="button" class="btn0 disable"><span class="xxxs noxscale"><span class="apps"></span></span><span class="lr xxxs">F4</span>
      </button><button type="button" class="btn0 disable"><span class="lr xxxs">F5</span>
      </button><button type="button" class="btn0 disable"><span class="lr xxxs">F6</span>
      </button><button type="button" class="btn0 disable"><span class="sm"><span class="left"></span><span class="left"></span></span><span class="lr xxxs">F7</span>
      </button><button type="button" class="btn0 disable"><span class="sm"><span class="right"></span><span class="pause"></span></span><span class="lr xxxs">F8</span>
      </button><button type="button" class="btn0 disable"><span class="sm"><span class="right"></span><span class="right"></span></span><span class="lr xxxs">F9</span>
      </button><button type="button" class="btn0 disable"><span class="xs noxscale"><span class="emoji">&#128264;</span></span><span class="lr xxxs">F10</span>
      </button><button type="button" class="btn0 disable"><span class="xs noxscale"><span class="emoji">&#128265;</span></span><span class="lr xxxs">F11</span>
      </button><button type="button" class="btn0 disable"><span class="xs noxscale"><span class="emoji">&#128266;</span></span><span class="lr xxxs">F12</span>
      </button><button type="button" class="btn0 disable"><span class="xs noxscale">⏏</span>
      </button>
    </div>
    <div class="row-keyboard"><button type="button" class="btn1 disable"><span class="xs">Print Screen</span>
      </button><button type="button" class="btn1 disable"><span class="xs">Scroll Lock</span>
      </button><button type="button" class="btn1 disable"><span class="xs">Pause Break</span>
      </button>
    </div>
    <div class="row-keyboard" style="opacity: 0;"><button type="button" class="btn1"><span class="lr xxxs">F16</span>
      </button><button type="button" class="btn1"><span class="lr xxxs">F17</span>
      </button><button type="button" class="btn1"><span class="lr xxxs">F18</span>
      </button><button type="button" class="btn1"><span class="lr xxxs">F19</span>
      </button>
    </div>
    <div class="row-keyboard"><button type="button" data-title="`" data-code="192" class="btn2"><span class="sm">~<br/>`</span>
      </button><button type="button" data-code="49" data-title="1" class="btn2"><span class="sm">!<br/>1</span>
      </button><button type="button" data-code="50" data-title="2" class="btn2"><span class="sm">@<br/>2</span>
      </button><button type="button" data-code="51" data-title="3" class="btn2"><span class="sm">#<br/>3</span>
      </button><button type="button" data-code="52" data-title="4" class="btn2"><span class="sm">$<br/>4</span>
      </button><button type="button" data-code="53" data-title="5" class="btn2"><span class="sm">%<br/>5</span>
      </button><button type="button" data-code="54" data-title="6" class="btn2"><span class="sm">^<br/>6</span>
      </button><button type="button" data-code="55" data-title="7" class="btn2"><span class="sm">&amp;<br/>7</span>
      </button><button type="button" data-code="56" data-title="8" class="btn2"><span class="sm">*<br/>8</span>
      </button><button type="button" data-code="57" data-title="9" class="btn2"><span class="sm">(<br/>9</span>
      </button><button type="button" data-code="48" data-title="0" class="btn2"><span class="sm">)<br/>0</span>
      </button><button type="button" data-code="189" data-title="-" class="btn2"><span class="sm">_<br/>-</span>
      </button><button type="button" data-code="187" data-title="=" class="btn2"><span class="sm">+<br/>=</span>
      </button><button type="button" data-code="8" class="btn3"><span class="lr xs">Backspace</span>
      </button>
    </div>
    <div class="row-keyboard"><button type="button" class="btn2 disable"><span class="xs">insert</span>
      </button><button type="button" class="btn2 disable"><span class="xs">home</span>
      </button><button type="button" class="btn2 disable"><span class="xs">page up</span>
      </button>
    </div>
    <div class="row-keyboard"><button type="button" class="btn2 disable"><span class="xs">Num Lock</span>
      </button><button type="button" data-code="111" class="btn2"><span>/</span>
      </button><button type="button" data-code="106" class="btn2"><span>*</span>
      </button><button type="button" data-code="109" class="btn2"><span>-</span>
      </button>
    </div>
    <div class="row-keyboard"><button type="button" class="btn3 disable"><span class="ll xs">tab</span>
      </button><button type="button" data-code="81" class="btn2"><span>Q</span>
      </button><button type="button" data-code="87" class="btn2"><span>W</span>
      </button><button type="button" data-code="69" class="btn2"><span>E</span>
      </button><button type="button" data-code="82" class="btn2"><span>R</span>
      </button><button type="button" data-code="84" class="btn2"><span>T</span>
      </button><button type="button" data-code="89" class="btn2"><span>Y</span>
      </button><button type="button" data-code="85" class="btn2"><span>U</span>
      </button><button type="button" data-code="73" class="btn2"><span>I</span>
      </button><button type="button" data-code="79" class="btn2"><span>O</span>
      </button><button type="button" data-code="80" class="btn2"><span>P</span>
      </button><button type="button" data-title="[" data-code="219" class="btn2"><span class="sm">{<br/>[</span>
      </button><button type="button" data-title="]" data-code="221" class="btn2"><span class="sm">}<br/>]</span>
      </button><button type="button" data-title="\" data-code="220" class="btn2"><span class="sm">|<br/>\</span>
      </button>
    </div>
    <div class="row-keyboard"><button type="button" class="btn2 disable"><span class="xs noxpad">delete</span>
      </button><button type="button" class="btn2 disable"><span class="xs">end</span>
      </button><button type="button" class="btn2 disable"><span class="xs">page down</span>
      </button>
    </div>
    <div class="row-keyboard"><button type="button" data-title="Number 7" data-code="103" class="btn2"><span>7</span>
      </button><button type="button" data-title="Number 8" data-code="104" class="btn2"><span>8</span>
      </button><button type="button" data-title="Number 9" data-code="105" class="btn2"><span>9</span>
      </button><button type="button" data-code="107" class="btn10" style="height: 2.625em;"><span>+</span>
      </button>
    </div>
    <div class="row-keyboard"><button type="button" id="caps-lock" class="btn4 disable"><span class="ul xs">•</span><span class="ll xs">caps lock</span>
      </button><button type="button" data-code="65" class="btn2"><span>A</span>
      </button><button type="button" data-code="83" class="btn2"><span>S</span>
      </button><button type="button" data-code="68" class="btn2"><span>D</span>
      </button><button type="button" data-code="70" class="btn2"><span>F</span><span class="bump"></span>
      </button><button type="button" data-code="71" class="btn2"><span>G</span>
      </button><button type="button" data-code="72" class="btn2"><span>H</span>
      </button><button type="button" data-code="74" class="btn2"><span>J</span><span class="bump"></span>
      </button><button type="button" data-code="75" class="btn2"><span>K</span>
      </button><button type="button" data-code="76" class="btn2"><span>L</span>
      </button><button type="button" data-title=";" data-code="186" class="btn2"><span class="sm">:<br/>;</span>
      </button><button type="button" data-title="'" data-code="222" class="btn2"><span class="sm">&quot;<br/>'</span>
      </button><button type="button" class="btn4 disable"><span class="lr xs">enter</span>
      </button>
    </div>
    <div class="row-keyboard"></div>
    <div class="row-keyboard"><button type="button" data-title="Number 4" data-code="100" class="btn2"><span>4</span>
      </button><button type="button" data-title="Number 5" data-code="101" class="btn2"><span>5</span><span class="bump"></span>
      </button><button type="button" data-title="Number 6" data-code="102" class="btn2"><span>6</span>
      </button>
    </div>
    <div class="row-keyboard"><button type="button" data-code="16" class="btn5"><span class="ll xs">shift</span>
      </button><button type="button" data-code="90" class="btn2"><span>Z</span>
      </button><button type="button" data-code="88" class="btn2"><span>X</span>
      </button><button type="button" data-code="67" class="btn2"><span>C</span>
      </button><button type="button" data-code="86" class="btn2"><span>V</span>
      </button><button type="button" data-code="66" class="btn2"><span>B</span>
      </button><button type="button" data-code="78" class="btn2"><span>N</span>
      </button><button type="button" data-code="77" class="btn2"><span>M</span>
      </button><button type="button" data-title="," data-code="188" class="btn2"><span class="sm">&lt;<br/>,</span>
      </button><button type="button" data-title="." data-code="190" class="btn2"><span class="sm">&gt;<br/>.</span>
      </button><button type="button" data-title="/" data-code="191" class="btn2"><span class="sm">?<br/>/</span>
      </button><button type="button" data-code="16" class="btn5"><span class="lr xs">shift</span>
      </button>
    </div>
    <div class="row-keyboard" style="text-align: center;"><button type="button" data-code="38" class="btn2"><span><span class="up"></span></span></button></div>
    <div class="row-keyboard"><button type="button" data-title="Number 1" data-code="97" class="btn2"><span>1</span>
      </button><button type="button" data-code="98" data-title="Number 2" class="btn2"><span>2</span>
      </button><button type="button" data-code="99" data-title="Number 3" class="btn2"><span>3</span>
      </button><button type="button" class="btn10 disable"><span class="lr xs">enter</span>
      </button>
    </div>
    <div class="row-keyboard"><button type="button" data-code="17" class="btn7"><span class="ll xs">Ctrl</span>
      </button><button type="button" class="btn6 disable"><span class="ll xs">window</span>
      </button><button type="button" data-code="18" class="btn7"><span class="ll xs">Alt</span>
      </button><button type="button" data-code="32" class="btn-longest"><span></span>
      </button><button type="button" data-code="18" class="btn7"><span class="lr xs">Alt</span>
      </button><button type="button" class="btn6 disable"><span class="lr xs">window</span>
      </button><button type="button" data-code="17" class="btn7"><span class="lr xs">Ctrl</span>
      </button>
    </div>
    <div class="row-keyboard"><button type="button" data-code="37" class="btn2"><span><span class="left"></span></span></button><button type="button" data-code="40" class="btn2"><span><span class="down"></span></span></button><button type="button" data-code="39" class="btn2"><span><span class="right"></span></span></button>
    </div>
    <div class="row-keyboard"><button type="button" data-code="96" class="btn9"><span>0</span>
      </button><button type="button" data-code="110" class="btn8"><span>.</span>
      </button>
    </div>
  </div>
</div>
<?php
echo get_field('repeater',[
'title'=>'Shortcut',
'value'=>setting('shortcuts'),
'key'=>'shortcuts',
'sub_fields'=>[
  'shortcut'=>['title'=>'Shortcut'],
  'keyCode'=>['title'=>'keyCode'],
  'title'=>['title'=>'Action','view'=>'textarea'],
  'link'=>['title'=>'Link','view'=>'textarea'],
  'link_route'=>[
    'title'=>'Route',
    'view'=>'group',
    'width_column'=>'30%',
    'sub_fields'=>[
        'route_name'=>['title'=>'Route Name', 'width_column'=>'150px'],
        'route_parameter'=>[
          'title'=>'Paramater',
          'view'=>'repeater',
          'sub_fields'=>[
              'key'=>['title'=>'Key'],
              'value'=>['title'=>'Value'],
          ]
        ],
    ]
  ],
  'target'=>['title'=>'Target','view'=>'select','list_option'=>['_self'=>'Self','_blank'=>'Blank','popup'=>'Popup']],
  'message'=>['title'=>'Message','view'=>'textarea','width-column'=>'200px',],
]
]);
?>
<input type="submit" name="save_shortcuts" class="vn4-btn vn4-btn-blue" value="@__('Save Changes')">
</form>