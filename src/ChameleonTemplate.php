<?php
/**
 * File holding the ChameleonTemplate class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2016, Stephan Gambke
 * @license   GNU General Public License, version 3 (or any later version)
 *
 * The Chameleon skin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option) any
 * later version.
 *
 * The Chameleon skin is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @file
 * @ingroup Skins
 */

namespace Skins\Chameleon;

use BaseTemplate;
use SkinChameleon;

/**
 * BaseTemplate class for the Chameleon skin
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class ChameleonTemplate extends BaseTemplate {

	/**
	 * Outputs the entire contents of the page
	 */
	public function execute() {

		// output the head element
		// The headelement defines the <body> tag itself, it shouldn't be included in the html text
		// To add attributes or classes to the body tag override addToBodyAttributes() in SkinChameleon
		$this->html( 'headelement' );
		echo $this->getSkin()->getComponentFactory()->getRootComponent()->getHtml();
		$this->printTrail();
		echo "</body>\n</html>";

		//Fragmente aus AIFBPortal3Template
		global $wgUser, $wgScriptPath, $wgServer;
    		//$skin = $wgUser->getOption('skin');
   		$skin = $this->getSkin();
    		$user = $this->getSkin()->getUser();
		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings(false);
		$this->html( 'headelement' );
		?>
  		<script src="<?php echo $wgScriptPath; ?>./jquery-1.4.2.min.js"></script>
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
			$english = $this->isEnglish($_SERVER['REQUEST_URI']);
    			if($english){
        			$institute_name ='Institute of Applied Informatics and<br>Formal Description Methods (AIFB)';
        			$aifb_home= htmlspecialchars($this->data['nav_urls']['mainpage']['href']).'/en';
        			$english = true;
   	 		} ?>
			
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
				<?php } ?>

			<?php }else{ ?>
				li_level_1_not_selected
			<?php } ?>

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
                                        if($val['active']>0){ ?>
                                            has_children_open
                                        <?php }else{ ?>
                                            has_children_closed
                                    <?php
                                    }} ?>
                                    "

                                    href="<?php echo htmlspecialchars($val['href']) ?>"
                                    <?php echo $skin->tooltipAndAccesskey($val['id']) ?>><?php if($english){echo htmlspecialchars($val['textengl']);}else{echo htmlspecialchars($val['text']);} ?></a>

                                    <?php if(isset($val['nlevel'])){ ?>
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
                                                        if($val2['active']>0){ ?>
									selected has_children_open
								<?php }else{ ?>
									has_children_closed
							<?php
                                                        }} ?>
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
                                                                        <?php } ?>
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
		
	}

	/**
	 * Overrides method in parent class that is unprotected against non-existent indexes in $this->data
	 *
	 * @param string $key
	 *
	 * @return string|void
	 */
	public function html( $key ) {
		echo $this->get( $key );
	}

	/**
	 * Get the Skin object related to this object
	 *
	 * @return SkinChameleon
	 */
	public function getSkin() {
		return parent::getSkin();
	}

	/**
	 * @param \DOMElement $description
	 * @param int         $indent
	 * @param string      $htmlClassAttribute
	 *
	 * @deprecated since 1.6. Use getSkin()->getComponentFactory()->getComponent()
	 *
	 * @throws \MWException
	 * @return \Skins\Chameleon\Components\Container
	 */
	public function getComponent( \DOMElement $description, $indent = 0, $htmlClassAttribute = '' ) {
		return $this->getSkin()->getComponentFactory()->getComponent( $description, $indent, $htmlClassAttribute );
	}

	/**
	 * Generates a list item for a navigation, portlet, portal, sidebar... list
	 *
	 * Overrides the parent function to ensure ids are unique.
	 *
	 * @param $key     string, usually a key from the list you are generating this link from.
	 * @param $item    array, of list item data containing some of a specific set of keys.
	 *
	 * The "id" and "class" keys will be used as attributes for the list item,
	 * if "active" contains a value of true a "active" class will also be appended to class.
	 *
	 * @param $options array
	 *
	 * @return string
	 */
	public function makeListItem( $key, $item, $options = array() ) {

		foreach ( array( 'id', 'single-id' ) as $attrib ) {

			if ( isset ( $item[ $attrib ] ) ) {
				$item[ $attrib ] = IdRegistry::getRegistry()->getId( $item[ $attrib ], $this );
			}

		}

		return parent::makeListItem( $key, $item, $options );
	}
							  
	//AIFB-Methoden
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

}
