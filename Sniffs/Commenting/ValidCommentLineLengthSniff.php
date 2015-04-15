<?php
/**
 * TYPO3_Sniffs_Commenting_ValidCommentLineLengthSniff.
 *
 * PHP version 5
 * TYPO3 CMS
 *
 * @category  Commenting
 * @package   TYPO3_PHPCS_Pool
 * @author    Laura Thewalt <laura.thewalt@wmdb.de>
 * @author    Stefano Kowalke <blueduck@gmx.net>
 * @copyright 2010 Laura Thewalt
 * @copyright 2014 Stefano Kowalke
 * @license   http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @link      https://github.com/typo3-ci/TYPO3SniffPool
 */
/**
 * Checks the length of comments.
 * Comment lines should be kept within a limit of about 80 characters
 * (excluding tabs)
 *
 * @category  Commenting
 * @package   TYPO3_PHPCS_Pool
 * @author    Laura Thewalt <laura.thewalt@wmdb.de>
 * @author    Stefano Kowalke <blueduck@gmx.net>
 * @copyright 2010 Laura Thewalt
 * @copyright 2014 Stefano Kowalke
 * @license   http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @version   Release: @package_version@
 * @link      https://github.com/typo3-ci/TYPO3SniffPool
 */
class TYPO3SniffPool_Sniffs_Commenting_ValidCommentLineLengthSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Max character length of comments
     *
     * @var int
     */
    protected $maxCommentLength = 80;

    /**
     * A list of tokenizers this sniff supports
     *
     * @var array
     */
    public $supportedTokenizes = array('PHP');


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
                T_DOC_COMMENT_STAR,
                T_COMMENT,
               );

    }//end register()


    /**
     * Processes this sniff, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in
     *                                        the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens      = $phpcsFile->getTokens();
        $commentLine = $tokens[$stackPtr]['content'];
        $lineEnd     = $phpcsFile->findNext(T_DOC_COMMENT_WHITESPACE, ($stackPtr + 1), null, false, $phpcsFile->eolChar);

        for ($i = ($stackPtr + 1); $i < $lineEnd; $i++) {
            $commentLine .= $tokens[$i]['content'];
        }

        $commentLength = strlen($commentLine);

        if ($commentLength > $this->maxCommentLength) {
            $phpcsFile->addWarning('Comment lines should be kept within a limit of about '.$this->maxCommentLength.' characters but this comment has '.$commentLength.' character!', $stackPtr);
        }

    }//end process()


}//end class
