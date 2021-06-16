<?php

declare(strict_types=1);

namespace App\Controller;

use App\Infrastructure\Feed\LocalFileFeedFetcher;
use App\Repository\FoodRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

final class ProcessFeedGetController
{
    public function __construct(
        private LocalFileFeedFetcher $feedFetcher,
        private FoodRepository $foodRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(): Response
    {
        $iterable = $this->feedFetcher->fetch(__DIR__ . '/../../var/branded_food.csv');
        $this->save($iterable);
        return new Response();
    }

    private function save(iterable $csvFoods): void
    {
        $batchSize = 1;
        $total = 0;

        foreach ($csvFoods as $csvFood) {
            $foundFood = $this->foodRepository->find($csvFood->id());

            if (!$foundFood) {
                continue;
            }

            $bannedWords = ['SOUP', 'SOY', 'FARM'];
            if ($csvFood->hasBannedWords($bannedWords)) {
                continue;
            }

            $foundFood->setName('PROCESSED_' . $csvFood->name());

            $this->entityManager->persist($foundFood);
            if (($total % $batchSize) === 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();
            }
            $total++;
        }
        $this->entityManager->flush();
        $this->entityManager->clear();
    }
}
