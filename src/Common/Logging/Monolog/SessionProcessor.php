<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the MIT License. As found in the LICENSE file in the root or at https://github.com/getparthenon/export-bundle/LICENSE
 */

namespace Parthenon\Common\Logging\Monolog;

use Monolog\Processor\ProcessorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SessionProcessor implements ProcessorInterface
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function __invoke(array $record): array
    {
        if (!$this->session->has('parthenon_session_id')) {
            $sessionId = md5(microtime());
            $this->session->set('parthenon_session_id', $sessionId);
        } else {
            $sessionId = $this->session->get('parthenon_session_id');
        }

        $record['extra']['session_id'] = $sessionId;

        return $record;
    }
}
