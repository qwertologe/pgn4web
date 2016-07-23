/* Add pgp4web button to the toolbar */

if(toolbar){
    toolbar[toolbar.length] = {
        "type":"format",
        "title":LANG.plugins.pgn4web.title,
        "key":"",
        "icon":"../../plugins/pgn4web/pgn4web.png",
        "open":"<pgn>\n",
        "sample":'[Event "IBM Kasparov vs. Deep Blue Rematch"]\n[Site "New York, NY USA"]\n[Date "1997.05.11"]\n[Round "6"]\n[White "Deep Blue"]\n[Black "Kasparov, Garry"]\n[Opening "Caro-Kann: 4...Nd7"]\n[ECO "B17"]\n[Result "1-0"]\n \n 1.e4 c6 2.d4 d5 3.Nc3 dxe4 4.Nxe4 Nd7 5.Ng5 Ngf6 6.Bd3 e6 7.N1f3 h6\n8.Nxe6 Qe7 9.O-O fxe6 10.Bg6+ Kd8 {Kasparov schüttelt kurz den Kopf} \n11.Bf4 b5 12.a4 Bb7 13.Re1 Nd5 14.Bg3 Kc8 15.axb5 cxb5 16.Qd3 Bc6 \n17.Bf5 exf5 18.Rxe7 Bxe7 19.c4 1-0',
        "close":"\n</pgn>"
    };
}
