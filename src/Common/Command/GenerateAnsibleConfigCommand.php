<?php

declare(strict_types=1);

/*
 * Copyright (C) 2020-2025 Iain Cambridge
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU LESSER GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation, either version 2.1 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace Parthenon\Common\Command;

use phpseclib3\Crypt\RSA;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\HttpKernel\KernelInterface;

class GenerateAnsibleConfigCommand extends Command
{
    public function __construct(private KernelInterface $kernel)
    {
        parent::__construct(null);
    }

    public function generateSshKey()
    {
        $applicationRoot = $this->kernel->getProjectDir();
        $fileDir = $applicationRoot.'/ansible/roles/common/files';
        if (!file_exists($fileDir)) {
            mkdir($fileDir, recursive: true);
        }

        $rsa = RSA::createKey();

        file_put_contents($fileDir.'/deploy.pub', $rsa->getPublicKey()->toString('OpenSSH'));
        $privateKey = $rsa->toString('OpenSSH');
        file_put_contents($fileDir.'/deploy.pem', $privateKey);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>Parthenon Ansible Config generator</info>');

        $questionHelper = $this->getHelper('question');

        $ipQuestion = new Question('What is the IP of server? ');

        $questionHelper->ask($input, $output, $ipQuestion);

        // PgSQL

        $sqlUsernameQuestion = new Question('What username do you want for PgSQL? [pgsqlusername] ', 'pgsqlusername');
        $sqlUsername = $questionHelper->ask($input, $output, $sqlUsernameQuestion);

        $sqlPasswordQuestion = new Question('What password do you want for PgSQL? [pgsqlpassword] ', 'pgsqlpassword');
        $sqlPassword = $questionHelper->ask($input, $output, $sqlPasswordQuestion);

        $sqlDatabaseQuestion = new Question('What database do you want for PgSQL? [pgsqldatabase]', 'pgsqldatabase');
        $sqlDatabase = $questionHelper->ask($input, $output, $sqlDatabaseQuestion);

        $sqlHostnameQuestion = new Question('What host do you want for PgSQL? [localhost]', 'localhost');
        $sqlHostname = $questionHelper->ask($input, $output, $sqlHostnameQuestion);

        // Stripe
        $stripePrivateKeyQuestion = new Question('What is your stripe private key []', '');
        $stripePrivateKey = $questionHelper->ask($input, $output, $stripePrivateKeyQuestion);

        $stripePublicKeyQuestion = new Question('What is your stripe public key []', '');
        $stripePublicKey = $questionHelper->ask($input, $output, $stripePublicKeyQuestion);

        // Deploy env questions

        $applicationUrlQuestion = new Question('What is the url for the application? [https://www.application.host]', 'https://www.application.host');
        $applicationUrl = $questionHelper->ask($input, $output, $applicationUrlQuestion);

        $athenaHostnameQuestion = new Question('What is the hostname for athena [athena.application.host]', 'athena.application.host');
        $athenaHostname = $questionHelper->ask($input, $output, $athenaHostnameQuestion);

        $gitQuestion = new Question('What is the git repostiory for the project?');
        $git = $questionHelper->ask($input, $output, $gitQuestion);

        $packagistTokenQuestion = new Question('What is your packagist token?');
        $packagistToken = $questionHelper->ask($input, $output, $packagistTokenQuestion);

        $envVars = sprintf(
            $this->getTemplate(),
            $this->getAppSecret(),
            $sqlUsername,
            $sqlPassword,
            $sqlHostname,
            $sqlDatabase,
            $stripePrivateKey,
            $stripePublicKey,
            $applicationUrl,
            $athenaHostname,
            $git,
            $packagistToken
        );

        $this->generateSshKey();

        $applicationRoot = $this->kernel->getProjectDir();
        $fileDir = $applicationRoot.'/ansible/var';
        if (!file_exists($fileDir)) {
            mkdir($fileDir, recursive: true);
        }
        file_put_contents($fileDir.'/env_prod.yml', $envVars);

        return static::SUCCESS;
    }

    private function getAppSecret(): string
    {
        return bin2hex(random_bytes(32));
    }

    private function getTemplate(): string
    {
        return <<<DOC
---
APP_SECRET: %s

PGSQL_USERNAME: '%s'
PGSQL_PASSWORD: '%s'
PGSQL_HOST: '%s'
PGSQL_DATABASE: '%s'

STRIPE_PRIVATE_API_KEY: '%s'
STRIPE_PUBLIC_API_KEY: '%s'

BASIC_MONTHLY_PRICE_ID: ""
BASIC_YEARLY_PRICE_ID: ""

APPLICATION_URL: '%s'
ATHENA_HOST: "%s"

GIT_URL: '%s'
PACKAGIST_TOKEN: '%s'
DOC;
    }
}
