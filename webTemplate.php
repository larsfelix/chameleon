<?php

    /**
     * @todo document
     * @addtogroup Skins
     */
class AifbPortal3Template extends QuickTemplate {
/**
 * Template filter callback for AifbPortal3 skin.
 * Takes an associative array of data set from a SkinTemplate-based
 * class, and a wrapper for MediaWiki's localization database, and
 * outputs a formatted page.
 *
 * @access private
 */

function execute() {
    global $wgUser, $wgScriptPath, $wgServer;
    //$skin = $wgUser->getOption('skin');
    $skin = $this->getSkin();
    $user = $this->getSkin()->getUser();
// Suppress warnings to prevent notices about missing indexes in $this->data
wfSuppressWarnings(false);
$this->html( 'headelement' );
?>
  <script src="<?php echo $wgScriptPath; ?>/skins/aifbportal3/jquery-1.4.2.min.js"></script>
<div id="wrapper"><?php
    #$wiki_uri = htmlspecialchars($_SERVER['REQUEST_URI'],ENT_COMPAT,'UTF-8'); causes problems when a uri contains ü,ö, ä
    $wiki_uri = urldecode($_SERVER['REQUEST_URI']); 
    $SkinAifbPortal3 = $this->data['skin'];
    $thisurl = $SkinAifbPortal3->thispage;
    $reg_thispage = '%(.*)(/en)$%';
    //Falls die MW-Seite über eine Weiterleitung kommt, muss manuell die zu untersuchende URL angepasst werden.
    $redirected = (htmlspecialchars($this->data['subtitle']));

    //Meata-Zeichen der URL escapen!!WichtiG!!
    $thisurl = preg_quote($thisurl);

    #echo "<br> URL(wikipage) nach preg_quote:".$thisurl;
    #echo "</div>";

    if ( preg_match($reg_thispage, $thisurl) or preg_match("/mw-redirectedfrom(.*)\/en/m",$redirected))
    {
        //En Seite aktiv
        $reg_en_to_de = '\\1\\3';
        $reg_wiki_uri = '%(.*)(/en)(.*)%';
        $language_text = 'DEUTSCH';
        $language_link = preg_replace($reg_wiki_uri, $reg_en_to_de, $wiki_uri);
        $Impressum_nav_text="Imprint";
        $Impressum_nav_link="Impressum/en";
        $Kontakt_nav_text="Contact";
        $Kontakt_nav_link="Kontakt/en";
        $Datenschutz_nav_text="Data Protection";
	    $Datenschutz_nav_link="Datenschutz/en";
        $Logout_nav_text="Logout";
        $Login_nav_text="Login";
        $Footer_nach_oben="Back to top";
        $Footer_KIT_Text="KIT - The Research University in the Helmholtz Association";

    }
    else
    {
        //DE Seite aktiv
        $reg_de_to_en = '\\1\\2/en\\3';
        $reg_wiki_uri = '%(.*)('.$thisurl.')(.*)%';
        $language_text = 'ENGLISH';
        $language_link = preg_replace($reg_wiki_uri, $reg_de_to_en, $wiki_uri);
        $Impressum_nav_text="Impressum";
        $Impressum_nav_link="Impressum";
        $Kontakt_nav_text="Kontakt";
        $Kontakt_nav_link="Kontakt";
        $Datenschutz_nav_text="Datenschutz";
		$Datenschutz_nav_link="Datenschutz";
        $Logout_nav_text="Abmelden";
        $Login_nav_text="Anmelden";
        $Footer_nach_oben="Nach oben";
        $Footer_KIT_Text="KIT - Die Forschungsuniversit&auml;t in der Helmholtz-Gemeinschaft";
    }

    //Navigation anpassen!
    $aifb_home = htmlspecialchars($this->data['nav_urls']['mainpage']['href']);
    $institute_name = 'Institut f&#252;r Angewandte Informatik und<br>Formale Beschreibungsverfahren (AIFB)';

    $english = $this->isEnglish($_SERVER['REQUEST_URI']);
    if($english){
        $institute_name ='Institute of Applied Informatics and<br>Formal Description Methods (AIFB)';
        $aifb_home= htmlspecialchars($this->data['nav_urls']['mainpage']['href']).'/en';
        $english = true;
    }

    $aiObj = $this->data['skin'];
    $mUser = $aiObj->mUser;
    $Array_mGroups = $mUser->mGroups;
    $User_Status_sysop = $Array_mGroups['1'];

    ?>
    <!-- =================== aifb-page-header =================== --> <!-- Metanavigation: start -->
    <div id="metanavigation"><!--###Metanavigation Links###-->

        <div id="metanavigation_left"><!-- Anzeigen eingeloggter User--> <?php $key ='userpage' ?>
            <?php $item=$this->data['personal_urls'][$key]?> <?php
            if($this->data['loggedin']==1)
            { ?>
                <div style="text-transform: none; float: left;"
                     id="pt-<?php echo Sanitizer::escapeId($key) ?>"
                    <?php
                    if ($item['active']) { ?> class="active" <?php } ?>>Angemeldet als: <b>
                        <a href="<?php
                        echo htmlspecialchars($item['href']) ?>"
                            <?php echo $skin->tooltipAndAccesskey('pt-'.$key) ?>
                            <?php
                            if(!empty($item['class'])) { ?>
                                class="<?php
                                echo htmlspecialchars($item['class']) ?>" <?php } ?>><?php
                            echo htmlspecialchars($item['text']) ?></a></b> <?php if($User_Status_sysop) {echo '<i>(Status: sysop</i>)';} ?>
                    &nbsp;&nbsp;&nbsp;| <a
                            href="<?php echo $wgArticlePath ?>/web/Intern:Dokumentation">Dokumentation</a>&nbsp;|
                    <a
                            href="<?php echo $wgArticlePath ?>/web/Spezial:Letzte_&Auml;nderungen">&Auml;nderungen</a>
                </div>
            <?php } ?></div>


        <!--###Metanavigation Rechts###-->

        <div id="metanavigation_right"><a href="<?php echo $aifb_home;?>">Home</a>&nbsp;|&nbsp;
            <a href="<?php echo htmlspecialchars($language_link);?>"><?php echo $language_text;?></a>&nbsp;|&nbsp;
            <a
                    href="<?php echo $wgArticlePath?>/web/<?php echo $Kontakt_nav_link;?>"><?php echo $Kontakt_nav_text;?></a>&nbsp;|&nbsp;
            <a
                    href="<?php echo $wgArticlePath?>/web/<?php echo $Impressum_nav_link;?>"><?php echo $Impressum_nav_text;?></a>&nbsp;|&nbsp;
            <a
                    href="<?php echo $wgArticlePath?>/web/<?php echo $Datenschutz_nav_link;?>"><?php echo $Datenschutz_nav_text;?></a>&nbsp;|&nbsp;

            <!--###Login/Logout in Metanavigation rechts###--> <?php
            if($this->data['loggedin']==1)
            { ?> <a
                    href="<?php echo htmlspecialchars($this->data['personal_urls']['logout']['href']) ?>">
                <?php echo $Logout_nav_text ?></a>&nbsp;|&nbsp; <?php }
            else
            { ?> <a
                    href="<?php echo htmlspecialchars($this->data['personal_urls']['login']['href']) ?>">
                <?php echo $Login_nav_text ?></a>&nbsp;|&nbsp; <?php } ?> <a
                    href="http://www.kit.edu" target="_blank">KIT</a></div>

    </div>

    <!-- Metanavigation: end --> <!-- Head: start -->
    <div id="head">
        <div id="logo"><a href="http://www.kit.edu">
                <img src="<?php echo $wgServer.$wgScriptPath ?>/skins/aifbportal3/kit_logo_V2_de.png" alt="zur KIT-Homepage"/></a></div>
        <div id="head-image">
            <div id="head-text" class="big_font"><a href="<?php echo $aifb_home;?>"><?php echo $institute_name;?></a>
            </div>
            <div id="head-text-corner">&nbsp;</div>

            <!-- Start: Admintools Head-->
            <div id="head_right_admin_tools" style="float: right;"><?php if($this->data['loggedin']==1) { ?>
                    <div class="adminbox">
                        <div class="adminbox-inner"><!-- ### Persönliche Werkzeuge ### -->
                            <div class="pBody">
                                <ul>

                                    <li>
                                        <a href="<?php global $wgArticlePath; echo str_replace( '$1', "Special:Browse/".$this->data['title'], $wgArticlePath);?>" class="plainlinks" rel="nofollow">Browse</a>
                                    </li>
                                </ul>
                                <ul>

                                    <?php
                                    foreach($this->data['personal_urls'] as $key => $item)
                                    { ?>
                                        <?php switch($key) {
                                        //case 'userpage':
                                        //case 'mytalk':
                                        case 'preferences':
                                            //case 'watchlist':
                                            //case 'mycontris':
                                            //case 'logout':
                                            ?>
                                            <li id="pt-<?php echo Sanitizer::escapeId($key)?>"
                                                <?php
                                                if ($item['active'])
                                                { ?> class="active" <?php } ?>><a
                                                        href="
	<?php
                                                        echo htmlspecialchars($item['href'])
                                                        ?>
		"
                                                    <?php
                                                    echo $skin->tooltipAndAccesskey('pt-'.$key)
                                                    ?>
                                                    <?php
                                                    if(!empty($item['class']))
                                                    { ?>
                                                        class="
	<?php
                                                        echo htmlspecialchars($item['class'])
                                                        ?>
		"
                                                    <?php } ?>> <?php
                                                    echo htmlspecialchars($item['text'])
                                                    ?> </a></li>
                                        <?php			} ?>
                                    <?php			} ?>
                                </ul>


                                <!-- ### Spezialseite ### -->
                                <ul>
                                    <?php
                                    if($this->data['loggedin']==1)
                                    { ?>
                                        <li><a
                                                    href="
        <?php
                                                    echo htmlspecialchars($this->data['nav_urls']['specialpages']['href'])
                                                    ?>
                "> <?php
                                                $this->msg('specialpages')
                                                ?> </a></li>

                                    <?php } ?>
                                </ul>


                                <!-- ### Anischten ### --> <!--	<div id="p-cactions" class="portlet">-->
                                <!--		<h5><?php $this->msg('views') ?></h5>-->
                                <!--<ul>-->
                                <!--	Debugging des Ansichten Arrays <?php #print_r($this->data['content_actions']) ?>-->
                                <?php
                                foreach($this->data['content_actions'] as $key => $tab)
                                { ?>
                                    <?php switch($key) {
                                    case 'edit':
                                       // if (($Form_edit_displayed)and($User_Status_sysop!='sysop')) {break;}
                                    case 'formedit':
                                     //   $Form_edit_displayed = true;
                                    //case 'nstab-main':
                                    //case 'talk':
                                    case 'history':
                                    case 'delete':
                                    case 'move':
                                        //case 'protect':
                                        //case 'watch':
                                    case 'purge':
                                        ?>
                                        <ul><li id="ca-<?php echo Sanitizer::escapeId($key)?>"
                                                <?php if($tab['class']){ ?>
                                                    class="<?php echo htmlspecialchars($tab['class'])?>" <?php } ?>><a
                                                        href="<?php echo htmlspecialchars($tab['href'])?>"
                                                    <?php echo $skin->tooltipAndAccesskey('ca-'.$key)?>> <?php echo htmlspecialchars($tab['text'])?></a></li></ul>
                                    <?php		} ?>
                                <?php		} ?>
                                <!--</ul>-->
                            </div>


                        </div>
                        <!--Infobox-Inner --></div>
                    <!-- Infobox --> <?php } ?></div>
        </div>
        <!-- End: Admintools Head--></div>
    <!-- Head: end --> <!-- Spacer: start -->
    <div class="spacer"><!-- --></div>
    <!-- Spacer: end --> <!-- =================== End aifb-page-header =================== -->


    <!-- Container: start -->
    <div id="container"><!-- Linke Spalte: start -->

        <div id="left-row">

            <div id="menu-box">

                <div class="portlet" id="p-logo"><a style="background-image: url(<?php $this->text('logopath') ?>);" <?php
                    ?>href="<?php echo htmlspecialchars($this->data['nav_urls']['mainpage']['href'])?>"<?php
                    echo $skin->tooltipAndAccesskey('n-mainpage') ?>></a></div>
                <script type="<?php $this->text('jsmimetype') ?>"> if (window.isMSIE55) fixalpha(); </script>

                <div class='portlet'
                     id='p-navigation<?php /* echo Sanitizer::escapeId($bar) */ ?>'

                    <?php $bar = 'TEST'; /* TODO */ echo "Error: unknown bar"; echo $skin->tooltip('p-'.$bar) ?>>
                    <h5><?php $out = wfMessage( $bar )->text(); if ( wfMessage($bar)->inContentLanguage()->isBlank() ) {
                        echo $bar;
                    } else {
                        echo $out;
                    } ?></h5>


                    <!-- ### Suche START ###-->
                    <div id="suchen" style="margin-top: 4px;">
                        <form action="<?php $this->text('searchaction') ?>" id="searchform">
                            <div><input id="suche" name="search" type="text"
                                    <?php echo $skin->tooltipAndAccesskey('search');
                                    if( isset( $this->data['search'] ) ) {
                                        ?>
                                        value="<?php $this->text('search') ?>" <?php } ?> /> <!--						<input type='submit' name="go" class="searchButton" id="searchGoButton"	value="<?php $this->msg('searcharticle') ?>" />-->
                                <input type='submit' name="fulltext" class="searchButton"
                                       id="submit" value="<?php $this->msg('searchbutton') ?>" /></div>
                        </form>
                    </div>

                    <!-- ### Suche END ###-->
                    <div class='pBody'>
                        <ul>
                            <?php foreach ($this->data['sidebar'] as $key => $val) { ?>

                                <li id="<?php echo Sanitizer::escapeId($val['id']) ?>"
                                    class="
			<?php if ( $val['active'] > 0) { ?>
				<?php if ( isset($val['nlevel']) ) { ?>
					li_level_1_selected_children
				<?php }else{ ?>
					li_level_1_selected_no_children
				<?php }?>

			<?php }else{ ?>
				li_level_1_not_selected
			<?php }?>

			">
                                    <a
                                        <?php if ( $val['active'] == 0 ) { ?>
                                            class="level_1_not_selected
				<?php }else{ ?>
					class="level_1_selected
                                            <?php
                                        }
                                        if ( !isset($val['nlevel']) ) { ?>
                                            has_no_children
                                        <?php }else{
                                        if($val['active']>0){?>
                                            has_children_open
                                        <?php }else{ ?>
                                            has_children_closed
                                    <?php
                                    }}?>
                                    "

                                    href="<?php echo htmlspecialchars($val['href']) ?>"
                                    <?php echo $skin->tooltipAndAccesskey($val['id']) ?>><?php if($english){echo htmlspecialchars($val['textengl']);}else{echo htmlspecialchars($val['text']);} ?></a>

                                    <?php if(isset($val['nlevel'])){?>
                                        <ul>
                                            <?php foreach($val['nlevel'] as $key2 => $val2) { ?>
                                                <li>
                                                    <a class="
							<?php if ( $val2['active'] == 0 ) { ?>
								item_not_selected
							<?php }
                                                    if ( !isset($val2['nlevel']) ) { ?>
							 	has_no_children
							<?php if( $val2['active'] > 0 ){ ?>
							 	item_selected
							<?php } }else{
                                                        if($val2['active']>0){?>
									selected has_children_open
								<?php }else{ ?>
									has_children_closed
							<?php
                                                        }}?>
						"
                                                       href="<?php echo htmlspecialchars($val2['href']) ?>"
                                                        <?php echo $skin->tooltipAndAccesskey($val2['id']) ?>><?php if($english){echo htmlspecialchars($val2['textengl']);}else{echo htmlspecialchars($val2['text']);} ?></a>

                                                    <?php if(isset($val2['nlevel'])){?>
                                                        <ul>
                                                            <?php foreach($val2['nlevel'] as $key3 => $val3) { ?>
                                                                <li>
                                                                    <a
                                                                        <?php if ( $val3['active'] == 0 ) { ?>
                                                                            class="item_not_selected"
                                                                        <?php }else{ ?>
                                                                            class="item_selected"
                                                                        <?php }?>
                                                                            href="<?php echo htmlspecialchars($val3['href']) ?>"
                                                                        <?php echo $skin->tooltipAndAccesskey($val3['id']) ?>><?php if($english){echo htmlspecialchars($val3['textengl']);}else{echo htmlspecialchars($val3['text']);} ?></a></li>
                                                            <?php } ?>
                                                        </ul>
                                                    <?php } ?>	<!--  // end if  -->




                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>	<!--  // end if  -->
                                </li>
                            <?php } ?>	<!--  // end foreach  -->
                        </ul>
                    </div>


                </div>
            </div>
        </div>
        <!-- Linke Spalte: end --> <!-- Rechte Spalte: start --> <!-- <div id="right-row"> -->
        <!-- Infobox [start] --> <!-- Wird nun per Wiki Content erstellt. Vorlage:Infobox column -->
        <!-- Infobox [end] --> <!-- Infobox [start] -->

        <div id="right-row">
            <a href="http://www.aik-ev.de/index.php/veranstaltungen/35-aik-symposium/"><div id="bild_rechts"></div></a>
            <div id="#" style="float:left">

                <div class="spacer-rechts"><!-- --></div>
                <?php $boxes = $this->getInfoboxes($english);
                foreach($boxes as $box){ ?>
                    <div class="infobox">
                        <div class="infobox-inner">
                            <div class="infobox-normal">
                                <?php echo $box ?>
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>
        </div>

        <!-- Rechte Spalte: end -->
        <!-- </div> --><!-- Right-Row--> <!-- Mittlere Spalte: start -->

        <div id="middle-row">
            <div id="middlerowimage"></div>
            <div id="content"><a name="top" id="top"></a>
                <div style="clear: both"></div>
                <?php if($this->data['sitenotice']) { ?>
                    <div id="siteNotice"><?php $this->html('sitenotice') ?></div>
                <?php } ?>
                <h1 class="firstHeading"><?php $this->data['displaytitle']!=""?$this->html('title'):$this->text('title') ?></h1>
                <div id="bodyContent">
                    <h3 id="siteSub"><?php $this->msg('tagline') ?></h3>
                    <div id="contentSub"><?php if($this->data['loggedin']==1){$this->html('subtitle');} ?></div>
                    <?php if($this->data['undelete']) { ?>
                        <div id="contentSub2"><?php     $this->html('undelete') ?></div>
                    <?php } ?> <?php if($this->data['newtalk'] ) { ?>
                        <div class="usermessage"><?php $this->html('newtalk')  ?></div>
                    <?php } ?> <?php if($this->data['showjumplinks']) { ?>
                        <div id="jump-to-nav"><?php $this->msg('jumpto') ?> <a
                                    href="#column-one"><?php $this->msg('jumptonavigation') ?></a>, <a
                                    href="#searchInput"><?php $this->msg('jumptosearch') ?></a></div>
                    <?php } ?>
                    <!-- start content -->
                    <?php $this->html('bodytext') ?>
                    <?php if($this->data['catlinks']) { ?>
                        <!--<div id="catlinks">-->
                        <?php       $this->html('catlinks') ?>
                        <!--</div>-->
                    <?php } ?>
                    <!-- end content -->
                    <div class="visualClear"></div>
                </div>

                <div style="clear: both"></div>
                <!-- Homepage-Container [end] --></div>
        </div>
        <!-- Mittlere Spalte: end -->
        <div class="clear"><!-- --></div>

        <!-- Werkzeuge
	<div class="portlet" id="p-tb">
		<h5><?php $this->msg('toolbox') ?></h5>
		<div class="pBody">
			<ul>
<?php
        if($this->data['notspecialpage']) { ?>
				<li id="t-whatlinkshere"><a href="<?php
            echo htmlspecialchars($this->data['nav_urls']['whatlinkshere']['href'])
            ?>"<?php echo $skin->tooltipAndAccesskey('t-whatlinkshere') ?>><?php $this->msg('whatlinkshere') ?></a></li>
<?php
            if( $this->data['nav_urls']['recentchangeslinked'] ) { ?>
				<li id="t-recentchangeslinked"><a href="<?php
                echo htmlspecialchars($this->data['nav_urls']['recentchangeslinked']['href'])
                ?>"<?php echo $skin->tooltipAndAccesskey('t-recentchangeslinked') ?>><?php $this->msg('recentchangeslinked') ?></a></li>
<?php 		}
        }
        if(isset($this->data['nav_urls']['trackbacklink'])) { ?>
			<li id="t-trackbacklink"><a href="<?php
            echo htmlspecialchars($this->data['nav_urls']['trackbacklink']['href'])
            ?>"<?php echo $skin->tooltipAndAccesskey('t-trackbacklink') ?>><?php $this->msg('trackbacklink') ?></a></li>
<?php 	}
        if($this->data['feeds']) { ?>
			<li id="feedlinks"><?php foreach($this->data['feeds'] as $key => $feed) {
            ?><span id="feed-<?php echo Sanitizer::escapeId($key) ?>"><a href="<?php
            echo htmlspecialchars($feed['href']) ?>"<?php echo $skin->tooltipAndAccesskey('feed-'.$key) ?>><?php echo htmlspecialchars($feed['text'])?></a>&nbsp;</span>
					<?php } ?></li><?php
        }

        foreach( array('contributions', 'log', 'blockip', 'emailuser', 'upload', 'specialpages') as $special ) {

            if($this->data['nav_urls'][$special]) {
                ?><li id="t-<?php echo $special ?>"><a href="<?php echo htmlspecialchars($this->data['nav_urls'][$special]['href'])
                ?>"<?php echo $skin->tooltipAndAccesskey('t-'.$special) ?>><?php $this->msg($special) ?></a></li>
<?php		}
        }

        if(!empty($this->data['nav_urls']['print']['href'])) { ?>
				<li id="t-print"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['print']['href'])
            ?>"<?php echo $skin->tooltipAndAccesskey('t-print') ?>><?php $this->msg('printableversion') ?></a></li><?php
        }

        if(!empty($this->data['nav_urls']['permalink']['href'])) { ?>
				<li id="t-permalink"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['permalink']['href'])
            ?>"<?php echo $skin->tooltipAndAccesskey('t-permalink') ?>><?php $this->msg('permalink') ?></a></li><?php
        } elseif ($this->data['nav_urls']['permalink']['href'] === '') { ?>
				<li id="t-ispermalink"<?php echo $skin->tooltip('t-ispermalink') ?>><?php $this->msg('permalink') ?></li><?php
        }

        wfRunHooks( 'AifbPortal3TemplateToolboxEnd', array( &$this ) );
        ?>
			</ul>
		</div>
	</div>
 --> <?php
        if( $this->data['language_urls'] ) { ?>
            <div id="p-lang" class="portlet">
                <h5><?php $this->msg('otherlanguages') ?></h5>
                <div class="pBody">
                    <ul>
                        <?php		foreach($this->data['language_urls'] as $langlink) { ?>
                            <li class="<?php echo htmlspecialchars($langlink['class'])?>"><?php
                                ?><a href="<?php echo htmlspecialchars($langlink['href']) ?>"><?php echo $langlink['text'] ?></a></li>
                        <?php		} ?>
                    </ul>
                </div>
            </div>
        <?php	} ?>
        <div class="visualClear"></div>


        <!--     <div id="footer_spacer"></div>
        --> <!-- =================== aifb-page-footer =================== -->


        <div class="clear"><!-- --></div>
        <!-- Footer: start -->
        <div id="footer-container">

            <div class="spacer"><!-- --></div>
            <div id="footer">
                <div id="footer-corner"><!-- --></div>
                <div id="footer-text">
                    <div id="footer-content"><!--                                <a href="#" class="footer-left">Weiterempfehlen</a>-->
                        <!--                                <a href="http://URL_vervollständigen_wenn_integriert/news.rss" class="footer-left"><img src="http://km.aifb.uni-karlsruhe.de/projects/aifbportal-wiki/skins/aifbportal3/rss.png" style="vertical-align: middle;" alt="RSS-Feed"> RSS-Feed</a>-->


                        <!-- START: Footerbar -->
                        <div id="footer-bar" style="
	margin: 0px 0px 0px 0px;
	float: left;
	width: 564px;
	height: 10px;
	background:">
                            <div id="powered_by_SMW" style="float:right;padding-right:0px;padding-bottom:0px;">
                                <a href="http://semantic-mediawiki.org">
                                    <img src="<?php $this->text('stylepath') ?>/aifbportal3/smw_button.png" border="0" width="88" height="31"></a>
                            </div>
                            <!-- START: RDF -->
                            <!-- TODO make optional, depending on wether SMW is installed -->
                            <!-- TODO fix special characters in $this->data['title'] -->
                            <div id="rdf-logo" style="float:right;padding-right:0px;padding-bottom:0px;">
                                <a href="<?php global $wgArticlePath; echo str_replace( '$1', "Special:ExportRDF/".$this->data['title'], $wgArticlePath);?>"
                                   class="plainlinks" rel="nofollow">
                                    <img alt="RDF Export" src="<?php $this->text('stylepath') ?>/aifbportal3/rdf-export.png" border="0" width="80" height="15" />
                                </a>
                            </div>
                            <!-- END: RDF -->
                        </div>
                        <!-- END: Footerbar -->


                        <a href="#top" class="footer-right"><?php echo $Footer_nach_oben; ?></a></div>
                </div>
            </div>
            <!-- Owner: start -->
            <div id="owner"><span id="owner-text"><?php echo $Footer_KIT_Text; ?></span></div>
            <!-- Owner: end --></div>
        <!-- Footer: end -->

        <!-- =================== end of aifb-page-footer =================== -->


        <?php $this->html('bottomscripts'); /* JS call to runBodyOnloadHook */ ?>

    </div>
    <?php $this->html('reporttime') ?> <?php if ( $this->data['debug'] ): ?>
        <!-- Debug output:
<?php $this->text( 'debug' ); ?>

--> <?php endif; ?>
</div> <!-- end id=wrapper -->
</body>
</html>
<?php
wfRestoreWarnings();
} // end of execute() method

function isEnglish($href){

    if(preg_match('/\/en(&.*)*$/', $href)){
        return true;
    }else{
        return false;
    }
}

function getInfoboxes($english){
    global $wgUser,$wgTitle,$wgParser;

    $infoboxes = array();

    //	$side = new Article(Title::newFromText('Infobox',NS_MEDIAWIKI));
    //	$text = $side->fetchContent();
    //remove html comments
    //	$text = preg_replace ('/<!--(.|\s)*?-->/', '', $text);
    if($english){
        $text = wfMessage( 'infobox-en' )->inContentLanguage()->text();
    }else{
        $text = wfMessage( 'infobox' )->inContentLanguage()->text();
    }
    preg_match_all('%\<infobox\>(.*)\</infobox\>%isU', $text, $matches);

    //get parser ready
    if (is_object($wgParser)) { $psr = $wgParser; $opt = $wgParser->mOptions; }
    else { $psr = new Parser; $opt = NULL; }
    if (!is_object($opt)) $opt = ParserOptions::newFromUser($wgUser);

    foreach($matches[1] as $rawinfobox){
        $infoboxes[] = $psr->parse($rawinfobox,$wgTitle,$opt,true,true)->getText();
    }

    return $infoboxes;
}

} // end of class
