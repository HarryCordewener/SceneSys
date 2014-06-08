<?php
/**
 * Options for the PHP parser
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup Parser
 */

/**
 * \brief Set options of the Parser
 *
 * All member variables are supposed to be private in theory, although in
 * practise this is not the case.
 *
 * @ingroup Parser
 */
class ParserOptions {

	/**
	 * Interlanguage links are removed and returned in an array
	 */
	var $mInterwikiMagic;

	/**
	 * Allow external images inline?
	 */
	var $mAllowExternalImages;

	/**
	 * If not, any exception?
	 */
	var $mAllowExternalImagesFrom;

	/**
	 * If not or it doesn't match, should we check an on-wiki whitelist?
	 */
	var $mEnableImageWhitelist;

	/**
	 * Date format index
	 */
	var $mDateFormat = null;

	/**
	 * Create "edit section" links?
	 */
	var $mEditSection = true;

	/**
	 * Allow inclusion of special pages?
	 */
	var $mAllowSpecialInclusion;

	/**
	 * Use tidy to cleanup output HTML?
	 */
	var $mTidy = false;

	/**
	 * Which lang to call for PLURAL and GRAMMAR
	 */
	var $mInterfaceMessage = false;

	/**
	 * Overrides $mInterfaceMessage with arbitrary language
	 */
	var $mTargetLanguage = null;

	/**
	 * Maximum size of template expansions, in bytes
	 */
	var $mMaxIncludeSize;

	/**
	 * Maximum number of nodes touched by PPFrame::expand()
	 */
	var $mMaxPPNodeCount;

	/**
	 * Maximum number of nodes generated by Preprocessor::preprocessToObj()
	 */
	var $mMaxGeneratedPPNodeCount;

	/**
	 * Maximum recursion depth in PPFrame::expand()
	 */
	var $mMaxPPExpandDepth;

	/**
	 * Maximum recursion depth for templates within templates
	 */
	var $mMaxTemplateDepth;

	/**
	 * Maximum number of calls per parse to expensive parser functions
	 */
	var $mExpensiveParserFunctionLimit;

	/**
	 * Remove HTML comments. ONLY APPLIES TO PREPROCESS OPERATIONS
	 */
	var $mRemoveComments = true;

	/**
	 * Callback for template fetching. Used as first argument to call_user_func().
	 */
	var $mTemplateCallback =
		array( 'Parser', 'statelessFetchTemplate' );

	/**
	 * Enable limit report in an HTML comment on output
	 */
	var $mEnableLimitReport = false;

	/**
	 * Timestamp used for {{CURRENTDAY}} etc.
	 */
	var $mTimestamp;

	/**
	 * Target attribute for external links
	 */
	var $mExternalLinkTarget;

	/**
	 * Clean up signature texts?
	 *
	 * 1) Strip ~~~, ~~~~ and ~~~~~ out of signatures
	 * 2) Substitute all transclusions
	 */
	var $mCleanSignatures;

	/**
	 * Transform wiki markup when saving the page?
	 */
	var $mPreSaveTransform = true;

	/**
	 * Whether content conversion should be disabled
	 */
	var $mDisableContentConversion;

	/**
	 * Whether title conversion should be disabled
	 */
	var $mDisableTitleConversion;

	/**
	 * Automatically number headings?
	 */
	var $mNumberHeadings;

	/**
	 * Thumb size preferred by the user.
	 */
	var $mThumbSize;

	/**
	 * Maximum article size of an article to be marked as "stub"
	 */
	private $mStubThreshold;

	/**
	 * Language object of the User language.
	 */
	var $mUserLang;

	/**
	 * @var User
	 * Stored user object
	 */
	var $mUser;

	/**
	 * Parsing the page for a "preview" operation?
	 */
	var $mIsPreview = false;

	/**
	 * Parsing the page for a "preview" operation on a single section?
	 */
	var $mIsSectionPreview = false;

	/**
	 * Parsing the printable version of the page?
	 */
	var $mIsPrintable = false;

	/**
	 * Extra key that should be present in the caching key.
	 */
	var $mExtraKey = '';

	/**
	 * Function to be called when an option is accessed.
	 */
	protected $onAccessCallback = null;

	function getInterwikiMagic() {
		return $this->mInterwikiMagic;
	}

	function getAllowExternalImages() {
		return $this->mAllowExternalImages;
	}

	function getAllowExternalImagesFrom() {
		return $this->mAllowExternalImagesFrom;
	}

	function getEnableImageWhitelist() {
		return $this->mEnableImageWhitelist;
	}

	function getEditSection() {
		return $this->mEditSection;
	}

	function getNumberHeadings() {
		$this->optionUsed( 'numberheadings' );

		return $this->mNumberHeadings;
	}

	function getAllowSpecialInclusion() {
		return $this->mAllowSpecialInclusion;
	}

	function getTidy() {
		return $this->mTidy;
	}

	function getInterfaceMessage() {
		return $this->mInterfaceMessage;
	}

	function getTargetLanguage() {
		return $this->mTargetLanguage;
	}

	function getMaxIncludeSize() {
		return $this->mMaxIncludeSize;
	}

	function getMaxPPNodeCount() {
		return $this->mMaxPPNodeCount;
	}

	function getMaxGeneratedPPNodeCount() {
		return $this->mMaxGeneratedPPNodeCount;
	}

	function getMaxPPExpandDepth() {
		return $this->mMaxPPExpandDepth;
	}

	function getMaxTemplateDepth() {
		return $this->mMaxTemplateDepth;
	}

	/* @since 1.20 */
	function getExpensiveParserFunctionLimit() {
		return $this->mExpensiveParserFunctionLimit;
	}

	function getRemoveComments() {
		return $this->mRemoveComments;
	}

	function getTemplateCallback() {
		return $this->mTemplateCallback;
	}

	function getEnableLimitReport() {
		return $this->mEnableLimitReport;
	}

	function getCleanSignatures() {
		return $this->mCleanSignatures;
	}

	function getExternalLinkTarget() {
		return $this->mExternalLinkTarget;
	}

	function getDisableContentConversion() {
		return $this->mDisableContentConversion;
	}

	function getDisableTitleConversion() {
		return $this->mDisableTitleConversion;
	}

	function getThumbSize() {
		$this->optionUsed( 'thumbsize' );

		return $this->mThumbSize;
	}

	function getStubThreshold() {
		$this->optionUsed( 'stubthreshold' );

		return $this->mStubThreshold;
	}

	function getIsPreview() {
		return $this->mIsPreview;
	}

	function getIsSectionPreview() {
		return $this->mIsSectionPreview;
	}

	function getIsPrintable() {
		$this->optionUsed( 'printable' );

		return $this->mIsPrintable;
	}

	function getUser() {
		return $this->mUser;
	}

	function getPreSaveTransform() {
		return $this->mPreSaveTransform;
	}

	function getDateFormat() {
		$this->optionUsed( 'dateformat' );
		if ( !isset( $this->mDateFormat ) ) {
			$this->mDateFormat = $this->mUser->getDatePreference();
		}
		return $this->mDateFormat;
	}

	function getTimestamp() {
		if ( !isset( $this->mTimestamp ) ) {
			$this->mTimestamp = wfTimestampNow();
		}
		return $this->mTimestamp;
	}

	/**
	 * Get the user language used by the parser for this page.
	 *
	 * You shouldn't use this. Really. $parser->getFunctionLang() is all you need.
	 *
	 * To avoid side-effects where the page will be rendered based on the language
	 * of the user who last saved, this function will triger a cache fragmentation.
	 * Usage of this method is discouraged for that reason.
	 *
	 * When saving, this will return the default language instead of the user's.
	 *
	 * {{int: }} uses this which used to produce inconsistent link tables (bug 14404).
	 *
	 * @return Language
	 * @since 1.19
	 */
	function getUserLangObj() {
		$this->optionUsed( 'userlang' );
		return $this->mUserLang;
	}

	/**
	 * Same as getUserLangObj() but returns a string instead.
	 *
	 * @return string Language code
	 * @since 1.17
	 */
	function getUserLang() {
		return $this->getUserLangObj()->getCode();
	}

	function setInterwikiMagic( $x ) {
		return wfSetVar( $this->mInterwikiMagic, $x );
	}

	function setAllowExternalImages( $x ) {
		return wfSetVar( $this->mAllowExternalImages, $x );
	}

	function setAllowExternalImagesFrom( $x ) {
		return wfSetVar( $this->mAllowExternalImagesFrom, $x );
	}

	function setEnableImageWhitelist( $x ) {
		return wfSetVar( $this->mEnableImageWhitelist, $x );
	}

	function setDateFormat( $x ) {
		return wfSetVar( $this->mDateFormat, $x );
	}

	function setEditSection( $x ) {
		return wfSetVar( $this->mEditSection, $x );
	}

	function setNumberHeadings( $x ) {
		return wfSetVar( $this->mNumberHeadings, $x );
	}

	function setAllowSpecialInclusion( $x ) {
		return wfSetVar( $this->mAllowSpecialInclusion, $x );
	}

	function setTidy( $x ) {
		return wfSetVar( $this->mTidy, $x );
	}

	/** @deprecated since 1.19 */
	function setSkin( $x ) {
		wfDeprecated( __METHOD__, '1.19' );
	}

	function setInterfaceMessage( $x ) {
		return wfSetVar( $this->mInterfaceMessage, $x );
	}

	function setTargetLanguage( $x ) {
		return wfSetVar( $this->mTargetLanguage, $x, true );
	}

	function setMaxIncludeSize( $x ) {
		return wfSetVar( $this->mMaxIncludeSize, $x );
	}

	function setMaxPPNodeCount( $x ) {
		return wfSetVar( $this->mMaxPPNodeCount, $x );
	}

	function setMaxGeneratedPPNodeCount( $x ) {
		return wfSetVar( $this->mMaxGeneratedPPNodeCount, $x );
	}

	function setMaxTemplateDepth( $x ) {
		return wfSetVar( $this->mMaxTemplateDepth, $x );
	}

	/* @since 1.20 */
	function setExpensiveParserFunctionLimit( $x ) {
		return wfSetVar( $this->mExpensiveParserFunctionLimit, $x );
	}

	function setRemoveComments( $x ) {
		return wfSetVar( $this->mRemoveComments, $x );
	}

	function setTemplateCallback( $x ) {
		return wfSetVar( $this->mTemplateCallback, $x );
	}

	function enableLimitReport( $x = true ) {
		return wfSetVar( $this->mEnableLimitReport, $x );
	}

	function setTimestamp( $x ) {
		return wfSetVar( $this->mTimestamp, $x );
	}

	function setCleanSignatures( $x ) {
		return wfSetVar( $this->mCleanSignatures, $x );
	}

	function setExternalLinkTarget( $x ) {
		return wfSetVar( $this->mExternalLinkTarget, $x );
	}

	function disableContentConversion( $x = true ) {
		return wfSetVar( $this->mDisableContentConversion, $x );
	}

	function disableTitleConversion( $x = true ) {
		return wfSetVar( $this->mDisableTitleConversion, $x );
	}

	function setUserLang( $x ) {
		if ( is_string( $x ) ) {
			$x = Language::factory( $x );
		}

		return wfSetVar( $this->mUserLang, $x );
	}

	function setThumbSize( $x ) {
		return wfSetVar( $this->mThumbSize, $x );
	}

	function setStubThreshold( $x ) {
		return wfSetVar( $this->mStubThreshold, $x );
	}

	function setPreSaveTransform( $x ) {
		return wfSetVar( $this->mPreSaveTransform, $x );
	}

	function setIsPreview( $x ) {
		return wfSetVar( $this->mIsPreview, $x );
	}

	function setIsSectionPreview( $x ) {
		return wfSetVar( $this->mIsSectionPreview, $x );
	}

	function setIsPrintable( $x ) {
		return wfSetVar( $this->mIsPrintable, $x );
	}

	/**
	 * Extra key that should be present in the parser cache key.
	 */
	function addExtraKey( $key ) {
		$this->mExtraKey .= '!' . $key;
	}

	/**
	 * Constructor
	 * @param User $user
	 * @param Language $lang
	 */
	function __construct( $user = null, $lang = null ) {
		if ( $user === null ) {
			global $wgUser;
			if ( $wgUser === null ) {
				$user = new User;
			} else {
				$user = $wgUser;
			}
		}
		if ( $lang === null ) {
			global $wgLang;
			if ( !StubObject::isRealObject( $wgLang ) ) {
				$wgLang->_unstub();
			}
			$lang = $wgLang;
		}
		$this->initialiseFromUser( $user, $lang );
	}

	/**
	 * Get a ParserOptions object from a given user.
	 * Language will be taken from $wgLang.
	 *
	 * @param User $user
	 * @return ParserOptions
	 */
	public static function newFromUser( $user ) {
		return new ParserOptions( $user );
	}

	/**
	 * Get a ParserOptions object from a given user and language
	 *
	 * @param User $user
	 * @param Language $lang
	 * @return ParserOptions
	 */
	public static function newFromUserAndLang( User $user, Language $lang ) {
		return new ParserOptions( $user, $lang );
	}

	/**
	 * Get a ParserOptions object from a IContextSource object
	 *
	 * @param IContextSource $context
	 * @return ParserOptions
	 */
	public static function newFromContext( IContextSource $context ) {
		return new ParserOptions( $context->getUser(), $context->getLanguage() );
	}

	/**
	 * Get user options
	 *
	 * @param User $user
	 * @param Language $lang
	 */
	private function initialiseFromUser( $user, $lang ) {
		global $wgInterwikiMagic, $wgAllowExternalImages,
			$wgAllowExternalImagesFrom, $wgEnableImageWhitelist, $wgAllowSpecialInclusion,
			$wgMaxArticleSize, $wgMaxPPNodeCount, $wgMaxTemplateDepth, $wgMaxPPExpandDepth,
			$wgCleanSignatures, $wgExternalLinkTarget, $wgExpensiveParserFunctionLimit,
			$wgMaxGeneratedPPNodeCount, $wgDisableLangConversion, $wgDisableTitleConversion;

		wfProfileIn( __METHOD__ );

		$this->mInterwikiMagic = $wgInterwikiMagic;
		$this->mAllowExternalImages = $wgAllowExternalImages;
		$this->mAllowExternalImagesFrom = $wgAllowExternalImagesFrom;
		$this->mEnableImageWhitelist = $wgEnableImageWhitelist;
		$this->mAllowSpecialInclusion = $wgAllowSpecialInclusion;
		$this->mMaxIncludeSize = $wgMaxArticleSize * 1024;
		$this->mMaxPPNodeCount = $wgMaxPPNodeCount;
		$this->mMaxGeneratedPPNodeCount = $wgMaxGeneratedPPNodeCount;
		$this->mMaxPPExpandDepth = $wgMaxPPExpandDepth;
		$this->mMaxTemplateDepth = $wgMaxTemplateDepth;
		$this->mExpensiveParserFunctionLimit = $wgExpensiveParserFunctionLimit;
		$this->mCleanSignatures = $wgCleanSignatures;
		$this->mExternalLinkTarget = $wgExternalLinkTarget;
		$this->mDisableContentConversion = $wgDisableLangConversion;
		$this->mDisableTitleConversion = $wgDisableLangConversion || $wgDisableTitleConversion;

		$this->mUser = $user;
		$this->mNumberHeadings = $user->getOption( 'numberheadings' );
		$this->mThumbSize = $user->getOption( 'thumbsize' );
		$this->mStubThreshold = $user->getStubThreshold();
		$this->mUserLang = $lang;

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Registers a callback for tracking which ParserOptions which are used.
	 * This is a private API with the parser.
	 * @param callable $callback
	 */
	function registerWatcher( $callback ) {
		$this->onAccessCallback = $callback;
	}

	/**
	 * Called when an option is accessed.
	 * @param string $optionName Name of the option
	 */
	public function optionUsed( $optionName ) {
		if ( $this->onAccessCallback ) {
			call_user_func( $this->onAccessCallback, $optionName );
		}
	}

	/**
	 * Returns the full array of options that would have been used by
	 * in 1.16.
	 * Used to get the old parser cache entries when available.
	 * @return array
	 */
	public static function legacyOptions() {
		return array(
			'stubthreshold',
			'numberheadings',
			'userlang',
			'thumbsize',
			'editsection',
			'printable'
		);
	}

	/**
	 * Generate a hash string with the values set on these ParserOptions
	 * for the keys given in the array.
	 * This will be used as part of the hash key for the parser cache,
	 * so users sharing the options with vary for the same page share
	 * the same cached data safely.
	 *
	 * Extensions which require it should install 'PageRenderingHash' hook,
	 * which will give them a chance to modify this key based on their own
	 * settings.
	 *
	 * @since 1.17
	 * @param array $forOptions
	 * @param Title $title Used to get the content language of the page (since r97636)
	 * @return string Page rendering hash
	 */
	public function optionsHash( $forOptions, $title = null ) {
		global $wgRenderHashAppend;

		// FIXME: Once the cache key is reorganized this argument
		// can be dropped. It was used when the math extension was
		// part of core.
		$confstr = '*';

		// Space assigned for the stubthreshold but unused
		// since it disables the parser cache, its value will always
		// be 0 when this function is called by parsercache.
		if ( in_array( 'stubthreshold', $forOptions ) ) {
			$confstr .= '!' . $this->mStubThreshold;
		} else {
			$confstr .= '!*';
		}

		if ( in_array( 'dateformat', $forOptions ) ) {
			$confstr .= '!' . $this->getDateFormat();
		}

		if ( in_array( 'numberheadings', $forOptions ) ) {
			$confstr .= '!' . ( $this->mNumberHeadings ? '1' : '' );
		} else {
			$confstr .= '!*';
		}

		if ( in_array( 'userlang', $forOptions ) ) {
			$confstr .= '!' . $this->mUserLang->getCode();
		} else {
			$confstr .= '!*';
		}

		if ( in_array( 'thumbsize', $forOptions ) ) {
			$confstr .= '!' . $this->mThumbSize;
		} else {
			$confstr .= '!*';
		}

		// add in language specific options, if any
		// @todo FIXME: This is just a way of retrieving the url/user preferred variant
		if ( !is_null( $title ) ) {
			$confstr .= $title->getPageLanguage()->getExtraHashOptions();
		} else {
			global $wgContLang;
			$confstr .= $wgContLang->getExtraHashOptions();
		}

		$confstr .= $wgRenderHashAppend;

		if ( !in_array( 'editsection', $forOptions ) ) {
			$confstr .= '!*';
		} elseif ( !$this->mEditSection ) {
			$confstr .= '!edit=0';
		}

		if ( $this->mIsPrintable && in_array( 'printable', $forOptions ) ) {
			$confstr .= '!printable=1';
		}

		if ( $this->mExtraKey != '' ) {
			$confstr .= $this->mExtraKey;
		}

		// Give a chance for extensions to modify the hash, if they have
		// extra options or other effects on the parser cache.
		wfRunHooks( 'PageRenderingHash', array( &$confstr, $this->getUser(), &$forOptions ) );

		// Make it a valid memcached key fragment
		$confstr = str_replace( ' ', '_', $confstr );

		return $confstr;
	}
}
