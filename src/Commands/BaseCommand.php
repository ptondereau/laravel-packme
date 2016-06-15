<?php

namespace Ptondereau\PackMe\Commands;

use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Class BaseCommand
 *
 * @package Ptondereau\PackMe\Commands
 */
abstract class BaseCommand
{
    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var HelperSet
     */
    protected $helperSet;

    /**
     * BaseCommand constructor.
     *
     * @param HelperSet $helperSet
     */
    public function __construct(HelperSet $helperSet)
    {
        $this->helperSet = $helperSet;
    }

    /**
     * @param string   $question
     * @param \Closure $validator
     * @param null     $attempts
     * @param null     $default
     * @return string
     */
    protected function askAndValidate($question, $validator, $attempts = null, $default = null)
    {
        /** @var QuestionHelper $helper */
        $helper = $this->helperSet->get('question');
        $question = new Question($question, $default);
        $question->setValidator($validator);
        $question->setMaxAttempts($attempts);
        return $helper->ask($this->input, $this->getErrorOutput(), $question);
    }

    /**
     * @param string $question
     * @param null   $default
     * @return string
     */
    protected function ask($question, $default = null)
    {
        /** @var \Symfony\Component\Console\Helper\QuestionHelper $helper */
        $helper = $this->helperSet->get('question');
        $question = new Question($question, $default);
        return $helper->ask($this->input, $this->getErrorOutput(), $question);
    }

    /**
     * @return OutputInterface
     */
    private function getErrorOutput()
    {
        if ($this->output instanceof ConsoleOutputInterface) {
            return $this->output->getErrorOutput();
        }
        return $this->output;
    }
}