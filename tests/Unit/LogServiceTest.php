<?php

namespace Tests\Unit;

use App\Contracts\Repositories\ILogRepository;
use App\Services\LogService;
use App\User;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class LogServiceTest extends TestCase
{
    public function testWriteLogSuccess()
    {
        $repositoryMock = $this->createMock(ILogRepository::class);
        $repositoryMock->expects($this->once())->method('save');

        $logService = new LogService($repositoryMock);

        $user = new User();
        $user->setId(1);

        $logService->write($user, 'test LogMessage', 3, 'document');
    }

    public function testLogListSuccess()
    {
        $repositoryMock = $this->createMock(ILogRepository::class);
        $repositoryMock->expects($this->once())->method('list');

        $logService = new LogService($repositoryMock);

        $logService->list();
    }
}
