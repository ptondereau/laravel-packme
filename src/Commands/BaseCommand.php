<?php

namespace Ptondereau\PackMe\Commands;

use Symfony\Component\Console\Question\Question;

/**
 * Class BaseCommand
 *
 * @package Ptondereau\PackMe\Commands
 */
abstract class BaseCommand
{
    protected function askAndValidate($question, $validator, $attempts = null, $default = null)
    {
        /** @var \Symfony\Component\Console\Helper\QuestionHelper $helper */
        $helper = $this->helperSet->get('question');
        $question = new Question($question, $default);
        $question->setValidator($validator);
        $question->setMaxAttempts($attempts);
        return $helper->ask($this->input, $this->getErrorOutput(), $question);
    }
}