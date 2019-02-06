<?php

namespace App\Custom;
use Exception;

class PhpWord extends \PhpOffice\PhpWord\PhpWord {

	/**
     * Load template by filename
     *
     * @deprecated 0.12.0 Use `new TemplateProcessor($documentTemplate)` instead.
     *
     * @param  string $filename Fully qualified filename
     *
     * @throws \PhpOffice\PhpWord\Exception\Exception
     *
     * @return TemplateProcessor
     *
     * @codeCoverageIgnore
     */
    public function loadTemplate($filename)
    {
        if (file_exists($filename)) {
            return new \App\Custom\TemplateProcessor($filename);
        }
        throw new Exception("Template file {$filename} not found.");
    }
	
}