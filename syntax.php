<?php
/*
 * Plugin pgn4web: PGN Viewer pgn4web for dokuwiki
 *
 * @name       pgn4web Plugin
 * @license    GPL 3 (http://www.gnu.org/licenses/gpl.html)
 * @author     Michael Arlt <michael.arlt@sk-schwanstetten.de>
 * @version    2016-06-28
 *
 * pgn4web.js changes: "=" -> "||" ; "+" -> "\u2192"
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
*/

if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_pgn4web extends DokuWiki_Syntax_Plugin {

    /**
     * function constructor
     */
    function syntax_plugin_pgn4web(){
      // enable direct access to language strings
      $this->setupLocale();
    }

    /**
     * return some info
     */
    function getInfo(){
        return array(
            'author' => 'Michael Arlt',
            'email'  => 'michael.arlt@sk-schwanstetten.de',
            'date'   => '2014-11-25',
            'name'   => 'pgn4web Plugin',
            'desc'   => $this->getLang('desc') ,
            'license'=> 'GPL v3 (http://www.gnu.org/licenses/gpl.html)',
            'url'    => 'http://wiki.splitbrain.org/plugin:pgn4web'
        );
    }

    /**
     * What kind of syntax are we?
     */
    function getType(){
        return 'substition';
    }

    /**
     * Where to sort in?
     */
    function getSort(){
        return 38;
    }

    /**
     * Connect pattern to lexer
     */
    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('<pgn>.+?</pgn>',$mode,'plugin_pgn4web');
    }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, Doku_Handler $handler) {
        $match=substr($match,6,-7);
        return $match;
    }

    /**
     * Create output
     */
    function render($mode, Doku_Renderer $renderer,$data)
    {
        if($mode == 'xhtml')
        {
            $shadow_size=20;

            // defaults
            $set = $this->getConf('set');
            $setsizeportrait = $this->getConf('setsizeportrait');
            $setsizelandscape = $this->getConf('setsizelandscape');
            $pluginwidthportrait = $this->getConf('pluginwidthportrait');
            $pluginwidthlandscape = $this->getConf('pluginwidthlandscape');
            $font = $this->getConf('font');
            $infowidth = $this->getConf('infowidth');
            $textheight = $this->getConf('textheight');
            $layout = $this->getConf('layout');
            //error_log("set:$set setsizeportrait:$setsizeportrait font:$font");
            $squaresizeportrait=intval($setsizeportrait/2);
            $squaresizelandscape=intval($setsizelandscape/2);
            $boardsizeportrait=8*($squaresizeportrait+12)+16;
            $boardsizelandscape=8*($squaresizelandscape+12)+16;
            if ($layout == "portrait") {
              $boardsizelandscape = $boardsizeportrait;
              $setsizelandscape = $setsizeportrait;
              $pluginwidthlandscape = $pluginwidthportrait;
            }
            if ($layout == "landscape") {
              $boardsizeportrait = $boardsizelandscape;
              $setsizeportrait = $setsizelandscape;
              $pluginwidthportrait = $pluginwidthlandscape;
            }

            $renderer->doc .= '
<div id=\'pgn4web_fontcontainer\'>
<style type="text/css">
.move, .variation, .commentMove { font-family: "pgn4web ' . $font . '", "pgn4web Liberation Sans", sans-serif; }
</style>
</div>';

            $renderer->doc .= '
<style type="text/css">
label.pgn4web { width:' . $infowidth . '; }

@media all and (orientation:portrait) {
  <!--  .pieceImage { width: ' . $setsizeportrait . 'px; height: ' . $setsizeportrait . 'px; } -->
  .pieceImage { width: auto; height: auto; }
  .whiteSquare, .blackSquare, .highlightWhiteSquare, .highlightBlackSquare {
    width: ' . $squaresizeportrait . 'px !important;
    height: ' . $squaresizeportrait . 'px !important;
    border-style: solid; border-width: 2px;
  }
  #GameBoard, #boardTable { width: ' . $boardsizeportrait . 'px !important; height: ' . $boardsizeportrait . 'px !important; }
  #boardTable { table-layout: fixed !important; }
  #boardTable td { border: 0px; height: 12.5% !important; width: 12.5% !important; }
  #GameButtons table {
    width:100% !important;
  }
  #GameButtons td {
    padding:0px !important;
    width: 12.5% !important;
  }
  #GameButtons td input {
    width:100% !important;
  }
  td.buttonControlSpace {
    display: none;
  }
}
@media not all and (orientation:portrait) {
  <!-- .pieceImage { width: ' . $setsizelandscape . 'px; height: ' . $setsizelandscape . 'px; } -->
  .pieceImage { width: auto; height: auto; }
  .whiteSquare, .blackSquare, .highlightWhiteSquare, .highlightBlackSquare {
    width: ' . $squaresizelandscape . 'px !important;
    height: ' . $squaresizelandscape . 'px !important;
    border-style: solid; border-width: 2px;
  }
  #GameBoard, #boardTable { width: ' . $boardsizelandscape . 'px !important; height: ' . $boardsizelandscape . 'px !important; }
  #boardTable { table-layout: fixed !important; }
  #boardTable td { border: 0px; height: 12.5% !important; width: 12.5% !important; }
  #GameButtons table {
    width:100% !important;
  }
  #GameButtons td {
     padding:0px !important;
     width: 12.5% !important;
  }
  #GameButtons td input {
    width:100% !important;
  }
  td.buttonControlSpace {
    display: none;
  }
}

</style>';
            // check set folder
            // TODO!
            if (! is_dir( DOKU_PLUGIN . "pgn4web/pgn4web/images/$relative_pieces_path")) {
                $problem = true;
                if (preg_match("/svg/",$set)) {
                    $renderer->doc .= pgn4web_error(sprintf($this->getLang('err_font_dir'),$pieces_fs_path));
                } else {
                  if ($set >=0 && $set <= 6) { # set is valid -> err_size if folder not found
                    $renderer->doc .= pgn4web_error(sprintf($this->getLang('err_size'),$setsizeportrait,$set+1));
                  }
                }
            }
            // check single pgn4web instance
            if (defined('PGN4WEB')) {
                $problem = true;
                $renderer->doc .= pgn4web_info($this->getConf('err_instance'));
                if (auth_quickaclcheck($ID) >= AUTH_EDIT) {
                    $renderer->doc .= pgn4web_info($this->getConf('err_instance_author'));
                }
            } else {
                define('PGN4WEB',true);
            }
            if ($problem) {
              return true;
            }

            // ausgabe
            $renderer->doc .= '<script src="' . DOKU_BASE . 'lib/plugins/pgn4web/pgn4web/pgn4web.js" type="text/javascript"></script>';
            $renderer->doc .= '<form style="display: none;"><textarea style="display: none;" id="pgnText">';
            $renderer->doc .= $data;
            $renderer->doc .= '</textarea></form>';
            $renderer->doc .= '
<script type="text/javascript">

  function autoScrollToCurrentMove(objId) {
    if (!objId) { return; }
    var theContainerObj = document.getElementById(objId);
    if (theContainerObj) {
      if (CurrentPly == StartPly) { theContainerObj.scrollTop = 0; }
      else {
        var theMoveObj = document.getElementById("Var" + CurrentVar + "Mv" + CurrentPly);
        if (theMoveObj) {
          var theContainerObjOffsetVeryTop = objOffsetVeryTop(theContainerObj);
          var theMoveObjOffsetVeryTop = objOffsetVeryTop(theMoveObj);
          theContainerObj.scrollTop = theMoveObjOffsetVeryTop - theContainerObjOffsetVeryTop;
        }
      }
    }
  }
  "use strict";

  var pgn4web_set = "' . $set . '".split(" ",1);
  var pgn4web_setsizeportrait = "' . $setsizeportrait . '";
  var pgn4web_setsizelandscape = "' . $setsizelandscape . '";
  var pgn4web_font = "' . $font . '";
  var pgn4web_infowidth = "' . $infowidth . '";
  var pgn4web_textheight = "' . $textheight . '";
  var pgn4web_layout = "' . $layout . '";
  var pgn4web_squaresizeportrait = ' . $squaresizeportrait . ';
  var pgn4web_squaresizelandscape = ' . $squaresizelandscape . ';
  var pgn4web_boardsizeportrait = ' . $boardsizeportrait . ';
  var pgn4web_boardsizelandscape = ' . $boardsizelandscape . ';
  var pgn4web_pluginwidthlandscape = "' . $pluginwidthlandscape . '";
  var pgn4web_pluginwidthportrait = "' . $pluginwidthportrait . '";

  var pgn4web_textheightlandscape = pgn4web_boardsizelandscape + 28 + "px";
  var pgn4web_textheightportrait = pgn4web_textheight;

  function pgn4web_orientationdata() {
    var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName("body")[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
    if (pgn4web_layout == "portrait" || (y > x && pgn4web_layout == "auto")) {
      return [pgn4web_boardsizeportrait + "px", pgn4web_pluginwidthportrait, pgn4web_setsizeportrait, pgn4web_textheightportrait];
    } else {
      return [pgn4web_boardsizelandscape + "px", pgn4web_pluginwidthlandscape, pgn4web_setsizelandscape, pgn4web_textheightlandscape];
    }
  }
  pgn4web_od = pgn4web_orientationdata();
  pgn4web_boardsize = pgn4web_od[0];
  pgn4web_pluginwidth = pgn4web_od[1];
  pgn4web_setsize = pgn4web_od[2];
  pgn4web_activetextheight = pgn4web_od[3];

  function pgn4web_getpiecepathandtype(set) {
    var path = "' . DOKU_BASE . 'lib/plugins/pgn4web/pgn4web/images/" + set;
    if (/svg/.test(set)) {
      var type = "svg";
    } else {
      path += "/" + pgn4web_setsize;
      var type = "png";
    }
    return [path,type];
  }

  function pgn4web_setchessset(index) {
    if (index >= 0 && index < pgn4web_sets.length) {
      var set = pgn4web_sets[index].split(" ",1);
      var images = document.images;
      var pgn4web_imagedata = pgn4web_getpiecepathandtype(set);
      var path = pgn4web_imagedata[0];
      var type = pgn4web_imagedata[1];
      SetImagePath(path);
      SetImageType(type);
      InitImages();
      for (var i=0; i<images.length; i++) {
        if (images[i].className == "pieceImage") {
          figure=images[i].src.match(/([^\/]+)(?=\.\w+$)/)[0];
          images[i].src=path+"/"+figure+"."+type;
        }
      }
    }
  }
  function pgn4web_setchessfont(index) {
    if (index >= 0 && index < pgn4web_fonts.length) {
      var showpgntextelement = document.getElementById("ShowPgnText").childNodes;
      for (var i=0; i<showpgntextelement.length; i++) {
        var classes = showpgntextelement[i].className.split(" ");
        for (var j=0; j<classes.length; j++) {
          if (classes[j] == "move" || classes[j] == "variation" || classes[j] == "commentMove") {
            showpgntextelement[i].style.fontFamily = "\'pgn4web " + pgn4web_fonts[index] + "\', \'pgn4web Liberation Sans\', sans-serif";
            break;
          }
        }
      }
    }
  }


  var board = "<div id=\'GameBoard\'></div><div id=\'GameButtons\'></div>";
  var game_text = "<div id=\'GameText\' style=\'height:" + pgn4web_activetextheight + "; overflow-y:auto; resize:vertical; padding-right:1ex;\'></div>";

  document.writeln("<div style=\'width:" + pgn4web_pluginwidth + ";\'>");
  document.writeln("<form><fieldset class=\'pgn4web\' style=\'width:100%;\'><ul class=\'pgn4web\'>");

  // select set
  var pgn4web_sets  = new Array ("alpha","merida","uscf","igorsvg","svgchess","tilesvg");';

if ($this->getConf('showsetselect')) {
$renderer->doc .= '
  document.writeln("<li class=\'pgn4web\'><label class=\'pgn4web\' for=\'pgn4web_set\'>' . $this->getLang('selectset') . '</label>");
  document.writeln("<select name=\'pgn4web_set\' size=\'1\' onchange=\'pgn4web_setchessset(this.form.pgn4web_set.selectedIndex)\'>");
  document.writeln("<optgroup label=\'png\'>");
  for (var i=0; i<3; i++) {
    if (pgn4web_sets[i] == pgn4web_set) {
      document.writeln("<option selected>" + pgn4web_sets[i] + "</option>");
    } else {
      document.writeln("<option>" + pgn4web_sets[i] + "</option>");
    }
  }
  document.writeln("</optgroup>");
  document.writeln("<optgroup label=\'svg\'>");
  for (var i=3; i<pgn4web_sets.length; i++) {
    if (pgn4web_sets[i] == pgn4web_set) {
      document.writeln("<option selected>" + pgn4web_sets[i] + "</option>");
    } else {
      document.writeln("<option>" + pgn4web_sets[i] + "</option>");
    }
  }
  document.writeln("</optgroup>");
  document.writeln("</select>");
  document.writeln("</li>");';
}

$renderer->doc .= '
  // select font
  var pgn4web_fonts = new Array ("ChessSansAlpha","ChessSansMerida","ChessSansPiratf","ChessSansUscf","ChessSansUsual");
';

if ($this->getConf('showfontselect')) {
$renderer->doc .= '
  document.writeln("<li class=\'pgn4web\'><label class=\'pgn4web\' for=\'pgn4web_set\'>' . $this->getLang('selectfont') . '</label>");
  document.writeln("<select name=\'pgn4web_font\' size=\'1\' onchange=\'pgn4web_setchessfont(this.form.pgn4web_font.selectedIndex)\'>");
  for (var i=0; i<pgn4web_fonts.length; i++) {
    if (pgn4web_fonts[i] == "' . $font . '") {
      document.writeln("<option selected>" + pgn4web_fonts[i] + "</option>");
    } else {
      document.writeln("<option>" + pgn4web_fonts[i] + "</option>");
    }
  }
  document.writeln("</select>");
  document.writeln("</li>");';
}

$renderer->doc .= '
  // game_info
  document.writeln("<li class=\'pgn4web\'> <label class=\'pgn4web\' for=\'GameSelector\'>' . $this->getLang('GameSelector') . '</label> <span id=\'GameSelector\'></span> </li> <li class=\'pgn4web\'> <label class=\'pgn4web\' for=\'GameDate\'>' . $this->getLang('GameDate') . '</label> <span id=\'GameDate\'></span> </li> <li class=\'pgn4web\'> <label class=\'pgn4web\' for=\'GameSite\'>' . $this->getLang('GameSite') . '</label> <span id=\'GameSite\'></span> </li> <li class=\'pgn4web\'> <label class=\'pgn4web\' for=\'GameEvent\'>' . $this->getLang('GameEvent') . '</label> <span id=\'GameEvent\'></span> </li> <li class=\'pgn4web\'> <label class=\'pgn4web\' for=\'GameWhite\'>' . $this->getLang('GameWhite') . '</label> <span id=\'GameWhite\'></span> </li> <li class=\'pgn4web\'> <label class=\'pgn4web\' for=\'GameBlack\'>' . $this->getLang('GameBlack') . '</label> <span id=\'GameBlack\'></span> </li> <li class=\'pgn4web\'> <label class=\'pgn4web\' for=\'GameResult\'>' . $this->getLang('GameResult') . '</label> <span id=\'GameResult\'></span> </li>");

  document.writeln("</ul></fieldset></form>");
  document.writeln("<div id=\'pgn4web_container\'>");
  document.writeln(" <div id=\'pgn4web_boarddiv\' style=\'float:left; padding-right:1ex;\'>" + board + "</div>");
  document.writeln(" <div id=\'pgn4web_textdiv\' style=\'float:left; width:100%; \'>" + game_text + "</div>");
  document.writeln(" <div style=\'clear:both\'></div>");
  document.writeln("</div>");
  document.writeln("</div>");

  var pgn4web_imagedata = pgn4web_getpiecepathandtype(pgn4web_set);
  SetImagePath(pgn4web_imagedata[0]);
  SetImageType(pgn4web_imagedata[1]);
  SetHighlightOption(true);
  SetCommentsIntoMoveText(true);
  SetCommentsOnSeparateLines(true);
  SetAutoplayDelay(1000); // milliseconds
  SetAutostartAutoplay(false);
  SetAutoplayNextGame(false); // if set, move to the next game at the end of the current game during autoplay
  SetInitialVariation(0); // number for the variation to be shown at load, 0 (default) for main variation
  SetInitialHalfmove(0,false); // halfmove number to be shown at load, 0 (default) for start position; values (keep the quotes) of "start", "end", "random", "comment" (go to first comment or variation), "variation" (go to the first variation) are also accepted. Second parameter if true applies the setting to every selected game instead of startup only
enableAutoScrollToCurrentMove("GameText");
  window.addEventListener("resize", autoScrollToCurrentMoveIfEnabled);

function orientationChange() {
  pgn4web_od = pgn4web_orientationdata();
  pgn4web_boardsize = pgn4web_od[0];
  pgn4web_pluginwidth = pgn4web_od[1];
  document.getElementById("pgn4web_textdiv").style.width="100%";
  document.getElementById("GameText").style.height = pgn4web_activetextheight;
  pgn4web_setsize = pgn4web_od[2];
  pgn4web_activetextheight = pgn4web_od[3];
  document.getElementById("pgn4web_boarddiv").style.width = pgn4web_boardsize;
  document.getElementById("GameText").style.height = pgn4web_activetextheight;
  remainingwidth=document.getElementById("pgn4web_container").clientWidth - document.getElementById("pgn4web_boarddiv").clientWidth;
  if (remainingwidth > 80) {
    document.getElementById("pgn4web_textdiv").style.width = remainingwidth - 4 + "px";
  } else {
    document.getElementById("pgn4web_textdiv").style.width = "100%";
  }
}

window.addEventListener("resize", orientationChange);
orientationChange();
  </script>';


            return true;
        }
        return false;
    }
}

function pgn4web_info($text) {
    return "<div class='info'>$text</div>";
}
function pgn4web_error($text) {
    $problem = true;
    return "<div class='error'>$text</div>";
}

//Setup VIM: ex: et ts=4 :
