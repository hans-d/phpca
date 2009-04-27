<?php
/**
 * This file is part of phpca, the static code analyzer for PHP.
 *
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

namespace spriebsch\PHPca\Tests;

use spriebsch\PHPca\File as File;
use spriebsch\PHPca\Token as Token;
use spriebsch\PHPca\Tokenizer as Tokenizer;
use spriebsch\PHPca\Result as Result;
use spriebsch\PHPca\NoTrailingWhitespace as NoTrailingWhitespace;

require_once 'PHPUnit/Framework.php';
require_once implode(DIRECTORY_SEPARATOR, array(__DIR__, '..', '..', 'bootstrap.php'));
require_once implode(DIRECTORY_SEPARATOR, array(__DIR__, '..', '..' , 'Rules', 'NoTrailingWhitespace.php'));

/**
 * Tests for the No Trailing Whitespace Rule.
 *
 * @author     Stefan Priebsch <stefan@priebsch.de>
 * @copyright  Stefan Priebsch <stefan@priebsch.de>. All rights reserved.
 */
class NoTrailingWhitespaceTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->rule = new NoTrailingWhitespace();

        $this->tokenizer = new Tokenizer();
        $this->result = new Result();

        parent::setUp();
    }

    protected function tokenize()
    {
        $this->tokenizedFile = $this->tokenizer->tokenize($this->fileName, file_get_contents($this->fileName));
        $this->rule->check($this->tokenizedFile, $this->result);
    }
 
    protected function assertHasErrorOnLine($line)
    {
        foreach ($this->result->getErrors($this->fileName) as $error) {
            if ($error->getLine() == $line) {
              return;
            }
        }

        $this->fail('No error on line ' . $line);
    }

    public function test001()
    {
        $this->fileName = implode(DIRECTORY_SEPARATOR, array(__DIR__, '..', '_files', 'testdata', 'trailing_whitespace', '001.php'));
        $this->tokenize();

        $this->assertEquals(1, $this->result->getNumberOfErrors());
        $this->assertHasErrorOnLine(5);
    }

    public function test002()
    {
        $this->fileName = implode(DIRECTORY_SEPARATOR, array(__DIR__, '..', '_files', 'testdata', 'trailing_whitespace', '002.php'));
        $this->tokenize();

        $this->assertEquals(1, $this->result->getNumberOfErrors());
        $this->assertHasErrorOnLine(1);
    }

    public function test003()
    {
        $this->fileName = implode(DIRECTORY_SEPARATOR, array(__DIR__, '..', '_files', 'testdata', 'trailing_whitespace', '003.php'));
        $this->tokenize();

        $this->assertEquals(3, $this->result->getNumberOfErrors());
        $this->assertHasErrorOnLine(5);
    }

    public function test004()
    {
        $this->fileName = implode(DIRECTORY_SEPARATOR, array(__DIR__, '..', '_files', 'testdata', 'trailing_whitespace', '004.php'));
        $this->tokenize();

        $this->assertEquals(1, $this->result->getNumberOfErrors());
        $this->assertHasErrorOnLine(4);
    }
}
?>
