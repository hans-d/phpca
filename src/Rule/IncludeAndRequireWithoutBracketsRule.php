<?php
/**
 * Copyright (c) 2009 Stefan Priebsch <stefan@priebsch.de>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 *   * Redistributions of source code must retain the above copyright notice,
 *     this list of conditions and the following disclaimer.
 * 
 *   * Redistributions in binary form must reproduce the above copyright notice,
 *     this list of conditions and the following disclaimer in the documentation
 *     and/or other materials provided with the distribution.
 *
 *   * Neither the name of Stefan Priebsch nor the names of contributors
 *     may be used to endorse or promote products derived from this software 
 *     without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER ORCONTRIBUTORS
 * BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    PHPca
 * @author     Stefan Priebsch <stefan@priebsch.de>
 * @copyright  Stefan Priebsch <stefan@priebsch.de>. All rights reserved.
 * @license    BSD License
 */

namespace spriebsch\PHPca\Rule;

use spriebsch\PHPca\Finder;
use spriebsch\PHPca\Error;
use spriebsch\PHPca\Warning;

use spriebsch\PHPca\Pattern\Pattern;

/**
 * No tabulator rule. Makes sure that only blanks are used for indentation.
 *
 * @author     Stefan Priebsch <stefan@priebsch.de>
 * @copyright  Stefan Priebsch <stefan@priebsch.de>. All rights reserved.
 */
class IncludeAndRequireWithoutBracketsRule extends Rule
{
    protected function doCheck()
    {
        $pattern = new Pattern();
        $pattern->token(T_INCLUDE)
                ->token(T_OPEN_BRACKET);

        foreach (Finder::findPattern($this->file, $pattern) as $token) {
                $this->addError('include statement with bracket', $token);
        }

        $pattern = new Pattern();
        $pattern->token(T_REQUIRE)
                ->token(T_OPEN_BRACKET);

        foreach (Finder::findPattern($this->file, $pattern) as $token) {
                $this->addError('require statement with bracket', $token);
        }

        $pattern = new Pattern();
        $pattern->token(T_INCLUDE_ONCE)
                ->token(T_OPEN_BRACKET);

        foreach (Finder::findPattern($this->file, $pattern) as $token) {
                $this->addError('include_once statement with bracket', $token);
        }

        $pattern = new Pattern();
        $pattern->token(T_REQUIRE_ONCE)
                ->token(T_OPEN_BRACKET);

        foreach (Finder::findPattern($this->file, $pattern) as $token) {
                $this->addError('require_once statement with bracket', $token);
        }
    }
}
?>