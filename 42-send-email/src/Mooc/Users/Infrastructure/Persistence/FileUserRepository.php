<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Users\Infrastructure\Persistence;

use CodelyTv\Mooc\Users\Domain\User;
use CodelyTv\Mooc\Users\Domain\UserId;
use CodelyTv\Mooc\Users\Domain\UserRepository;

final class FileUserRepository implements UserRepository
{
    private const FILE_PATH = __DIR__ . '/users';

    public function save(User $user): void
    {
        file_put_contents($this->fileName($user->id()->value()), serialize($user));
    }

    public function search(UserId $id): ?User
    {
        return file_exists($this->fileName($id->value()))
            ? unserialize(file_get_contents($this->fileName($id->value())))
            : null;
    }

    private function fileName(string $id): string
    {
        return sprintf('%s.%s.repo', self::FILE_PATH, $id);
    }
}
