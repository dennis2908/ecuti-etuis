<?php

namespace App\Custom;

class TemplateProcessor extends \PhpOffice\PhpWord\TemplateProcessor {
	/**
     * Clone a block - alternative function
     *
     * @author https://github.com/cruachan
     *
     * @param      $blockname
     * @param int  $clones
     * @param bool $replace
     *
     * @return bool|string
     */
    public function cloneBlockString($blockname, $clones = 1, $replace = true)
    {
        $cloneXML = '';
        $replaceXML = null;
        // location of blockname open tag
        $startPosition = strpos($this->tempDocumentMainPart, '${' . $blockname . '}');
        if ($startPosition) {
            // start position of area to be replaced, this is from the start of the <w:p before the blockname
            $startReplacePosition = strrpos($this->tempDocumentMainPart, '<w:p ',
                    -(strlen($this->tempDocumentMainPart) - $startPosition));
            // start position of text we're going to clone, from after the </w:p> after the blockname
            $startClonePosition = strpos($this->tempDocumentMainPart, '</w:p>', $startPosition) + strlen('</w:p>');
            // location of the blockname close tag
            $endPosition = strpos($this->tempDocumentMainPart, '${/' . $blockname . '}');
            if ($endPosition) {
                // end position of the area to be replaced, to the end of the </w:p> after the close blockname
                $endReplace = strpos($this->tempDocumentMainPart, '</w:p>', $endPosition) + strlen('</w:p>');
                // end position of the text we're cloning, from the start of the <w:p before the close blockname
                $endClone = strrpos($this->tempDocumentMainPart, '<w:p ',
                        -(strlen($this->tempDocumentMainPart) - $endPosition));
                $cloneLength = ($endClone - $startClonePosition);
                $replaceLength = ($endReplace - $startReplacePosition);
                $cloneXML = substr($this->tempDocumentMainPart, $startClonePosition, $cloneLength);
                $replaceXML = substr($this->tempDocumentMainPart, $startReplacePosition, $replaceLength);
            }
        }
        if ($replaceXML != null) {
            $cloned = array();
            for ($i = 1; $i <= $clones; $i++) {
                $cloned[] = $cloneXML;
            }
            if ($replace) {
                $this->tempDocumentMainPart = str_replace($replaceXML, implode('', $cloned),
                        $this->tempDocumentMainPart);
            }
        }

        return $cloneXML;
    }

    /**
     * Replace a block - alternative function
     *
     * @param string $blockname
     * @param string $replacement
     */
    public function replaceBlockString($blockname, $replacement)
    {
        preg_match(
                '/(\${' . $blockname . '})(.*)(\${\/' . $blockname . '})/is',
                $this->tempDocumentMainPart,
                $matches
        );
        if (isset($matches[2])) {
            $this->tempDocumentMainPart = str_replace(
                    $matches[1] . $matches[2] . $matches[3],
                    $replacement,
                    $this->tempDocumentMainPart
            );
        }
    }

    /**
     * Delete a block of text - alternative function
     *
     * @param string $blockname
     */
    public function deleteBlockString($blockname)
    {
        $this->replaceBlockString($blockname, '');
    }

}