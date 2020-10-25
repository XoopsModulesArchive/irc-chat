#
# Table structure for table 'iradio'
#
CREATE TABLE iradio (
    radio_id       INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    radio_name     VARCHAR(20)      NOT NULL DEFAULT '',
    radio_stream   VARCHAR(75)      NOT NULL DEFAULT '',
    radio_url      VARCHAR(50)      NOT NULL DEFAULT '',
    radio_picture  VARCHAR(50)      NOT NULL DEFAULT '',
    radio_language VARCHAR(30)      NOT NULL DEFAULT '',
    PRIMARY KEY (radio_id)
)
    ENGINE = ISAM;
#
# Table structure for table 'internet_tv'
#
CREATE TABLE internet_tv (
    tv_id       INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    tv_name     VARCHAR(20)      NOT NULL DEFAULT '',
    tv_stream   VARCHAR(255)     NOT NULL DEFAULT '',
    tv_url      VARCHAR(255)     NOT NULL DEFAULT '',
    tv_picture  VARCHAR(50)      NOT NULL DEFAULT '',
    tv_language VARCHAR(30)      NOT NULL DEFAULT '',
    PRIMARY KEY (tv_id)
)
    ENGINE = ISAM;
#
# Default values for table `iradio`
#
INSERT INTO iradio
VALUES ('', 'Yorin FM', 'http://media.rtl.nl/yorinfm/on_air/yorin.asx', 'http://www.yorin.nl', 'yorin.gif', 'dutch');
INSERT INTO iradio
VALUES ('', 'Radio 3FM', 'http://www.omroep.nl/radio3/live20.asx', 'http://www.omroep.nl/radio3/', '', 'dutch');
INSERT INTO iradio
VALUES ('', 'Sky radio', 'http://www.skyradio.nl/player/skyradio.asx', 'http://www.skyradio.nl', '', 'dutch');
INSERT INTO iradio
VALUES ('', 'Hotradio', 'http://www.hotradio.nl/sound/stream/livestream.asx', 'http://www.hotradio.nl', '', 'dutch');
INSERT INTO iradio
VALUES ('', 'Noordzee FM', 'mms://hollywood.win2k.vuurwerk.nl/noordzee', 'http://www.noordzeefm.nl', '', 'dutch');
INSERT INTO iradio
VALUES ('', 'Radio NRG', 'http://www.radionrg.com/listenlive.asx', 'http://www.radionrg.com', '', '');
INSERT INTO iradio
VALUES ('', 'Baja radio', 'http://www.bajaradio.com/vuurwerk.asx', 'http://www.bajaradio.com', '', 'dutch');
INSERT INTO iradio
VALUES ('', 'Capital FM', 'http://www.radio-now.co.uk/l/capitalfmlo.asx', 'http://www.capitalfm.com', 'capital.gif', 'english');
INSERT INTO iradio
VALUES ('', 'Virgin Radio', 'http://www.smgradio.com/core/audio/wmp/live.asx?service=vr', 'http://www.virginradio.co.uk', '', 'english');
INSERT INTO iradio
VALUES ('', 'Flash FM', 'http://www.flashfm.com/live/buildasx.asp?service=flashfmuk22', 'http://www.flashfm.com/', '', 'english');
INSERT INTO iradio
VALUES ('', 'BBC Radio 1', 'http://www.bbc.co.uk/radio1/realaudio/media/r1live.rpm', 'http://www.bbc.co.uk/radio1/', '', 'english');
#
# Default values for table `internet_tv`
#
INSERT INTO internet_tv
VALUES ('', 'LaatsteJeugdl', 'http://cgi.omroep.nl/cgi-bin/streams?/tv/nos/jeugdjournaal/bb.laatste.rm', 'http://www.omroep.nl/nos/jeugdjournaal/', '', 'dutch');
INSERT INTO internet_tv
VALUES ('', 'Laatste NOS', 'http://cgi.omroep.nl/cgi-bin/streams?/tv/nos/journaal/sb.laatste.rm', 'http://www.omroep.nl', 'journaal.gif', 'dutch');
INSERT INTO internet_tv
VALUES ('', 'BBC News 24', 'http://www.bbc.co.uk/newsa/n5ctrl/tvseq/n24.ram', 'http://www.bbc.co.uk', 'bbcnews.gif', '');
INSERT INTO internet_tv
VALUES ('', 'Bloomberg', 'http://www.bloomberg.com/streams/video/LiveUK_nb.asx', 'http://www.bloomberg.com', 'bloomberg.gif', 'english');
