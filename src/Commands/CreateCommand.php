<?php

namespace Ptondereau\PackMe\Commands;

use Ptondereau\PackMe\Crafters\CrafterInterface;
use Ptondereau\PackMe\Package;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateCommand.
 */
class CreateCommand extends AbstractBaseCommand
{
    /**
     * Crafter.
     *
     * @var CrafterInterface
     */
    protected $crafter;

    /**
     * CreateCommand constructor.
     *
     * @param CrafterInterface $crafter
     * @param HelperSet        $helperSet
     */
    public function __construct(CrafterInterface $crafter, HelperSet $helperSet)
    {
        parent::__construct($helperSet);
        $this->crafter = $crafter;
    }

    public function __invoke($dir, InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $output->writeln('<info>I need to know a little more about your future awesome laravel package...</info>');
        $output->writeln('');

        $package = new Package(
            $this->askForPackageName(),
            $this->askForAuthor(),
            $dir
        );
        $package->setDescription($this->askForDescription());

        $output->writeln('');
        $output->writeln('<info>Crafting your laravel package...</info>');

        $this->crafter->craft($package);

        $output->writeln('');
        $output->writeln('<info>Successfully crafted!</info>');
    }

    /**
     * @param string $package
     *
     * @return string
     */
    protected function askForPackageName($package = 'vendor/package')
    {
        return $this->askAndValidate(
            'Package name (<vendor>/<name>) [<comment>'.$package.'</comment>]: ',
            function ($value) use ($package) {
                if (null === $value) {
                    return $package;
                }
                if (!preg_match('{^[a-z0-9_.-]+/[a-z0-9_.-]+$}', $value)) {
                    throw new \InvalidArgumentException(
                        'The package name '.$value.' is invalid, it should be lowercase and have a vendor name, a forward slash, and a package name, matching: [a-z0-9_.-]+/[a-z0-9_.-]+'
                    );
                }

                return $value;
            },
            null,
            $package
        );
    }

    /**
     * @param string $author
     *
     * @return string
     */
    protected function askForAuthor($author = 'Author Name <author@domain.com>')
    {
        $self = $this;

        return $this->askAndValidate(
            'Author [<comment>'.$author.'</comment>]: ',
            function ($value) use ($self, $author) {
                if (null === $value) {
                    return $author;
                }

                $value = $value ?: $author;
                $parsed = $self->parseAuthorString($value);

                return sprintf('%s <%s>', $parsed['name'], $parsed['email']);
            },
            null,
            $author
        );
    }

    /**
     * @param bool|string $description
     *
     * @return string
     */
    protected function askForDescription($description = false)
    {
        $description = $description ?: false;

        return $this->ask(
            'Description [<comment>'.$description.'</comment>]: ',
            $description
        );
    }

    /**
     * Parse the author string.
     *
     * @private
     *
     * @param string $author
     *
     * @return array
     */
    private function parseAuthorString($author)
    {
        if (
            preg_match('/^(?P<name>[- \.,\p{L}\p{N}\'’]+) <(?P<email>.+?)>$/u', $author, $match)
            && $this->isValidEmail($match['email'])
        ) {
            return [
                'name'  => trim($match['name']),
                'email' => $match['email'],
            ];
        }

        throw new \InvalidArgumentException(
            'Invalid author string.  Must be in the format: '.
            'John Smith <john@example.com>'
        );
    }

    /**
     * Check if a given email is a good email.
     *
     * @param $email
     *
     * @return bool
     */
    private function isValidEmail($email)
    {
        // assume it's valid if we can't validate it
        if (!function_exists('filter_var')) {
            return true;
        }
        // php <5.3.3 has a very broken email validator, so bypass checks
        if (PHP_VERSION_ID < 50303) {
            return true;
        }

        return false !== filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
