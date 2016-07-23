# pgn4web

pgn4web (a DokuWiki plugin) displays the nice interactive pgnviewer from http://pgn4web.casaschi.net

Demo of the plugin: http://sk-schwanstetten.de/dw/doku.php?id=schachpartien:perlen_der_schachwelt_mit_kommentaren

## DESCRIPTION

I embedded only pgn4web in a plugin (which was difficult enough for me).

All foreign code is placed in the subfolder `pgn4web`.

## KNOWN ISSUES

You can only display one instance of pgn4web in a page.
This is a limitation if you use it together with the blog or include plugin.
As a solution, provide a link to the page alone, which is automatically done
with the blog plugin. In this case the board is not drawn - instead a hint
is created which instructs the reader to open solely the article.

Tested only with

* Windows 7: IE 11, Firefox 45, Chrome 51
* Windows 10: Edge, Firefox 47
* Linux: Firefox 47, Chromium 51
* Android 5.1.1: Firefox and Chrome

I am not sure if the 32x32 editor icon is a problem, but it is really nicer compared to 16x16.

## DEVELOPER

To create a working version you must download pgn4web from http://pgn4web.casaschi.net...

```
cd lib/plugins/pgn4web
unzip ~/Downloads/pgn4web-<version>.zip
mv pgn4web-<version> pgn4web
# diff -u pgn4web/pgn4web.js /tmp/pgn4web.js >pgn4web.patch # created the patch
patch pgn4web/pgn4web.js <pgn4web.patch # apply patch (optional: change +/= to utf-arrow/||)
find pgn4web/ -type f -name "*.png" | xargs pngquant --ext .png --force --skip-if-larger # (optional: reduce png size)
```

## CREDITS AND LICENSE

The embedded items remain subject to their original licenses (if any).
Details are documented in pgn4web/README.txt

The used [[http://ixian.com/chess/jin-piece-sets/|jin piece sets]] has a
changed license these days:
[[http://creativecommons.org/licenses/by/4.0/|Creative Commons Attribution 4.0 International License]] (in pgn4web is still version 3.0 mentioned).

Remaining pgn4web (plugin) code is copyright (C) 2014-2016 Michael Arlt

GNU General Public License the Free Software Foundation, version 3 of the License.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.

See LICENSE or http://www.gnu.org/licenses/gpl.html

## PERMISSION

Here is the permission, Paolo gave me on 2014-12-11 - Thanks!

> i would like to release my dokuwiki plugin. I have several questions and
> ask for your permission:
>
>   - I would like to use the name "pgn4web" as plugin name


That's fine for me.

...

--
Paolo

